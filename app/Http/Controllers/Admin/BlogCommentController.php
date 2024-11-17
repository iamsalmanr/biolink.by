<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {
        abort_if(!config('settings.blog')->status, 404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $params = $columns = $order = $totalRecords = $data = array();
            $params = $request;

            //define index of column
            $columns = array(
                'id',
                'user_id',
                'article_id',
                'status',
                'created_at'
            );

            if ($request->has('article_id') && !empty($request->article_id)) {
                if(!empty($params['search']['value'])){
                    $q = $params['search']['value'];
                    $comments = BlogComment::where('article_id', $request->article_id)->with(['user', 'blog'])
                        ->where('id', 'like', '%' . $q . '%')
                        ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                        ->limit($params['length'])->offset($params['start'])
                        ->get();
                }else{
                    $comments = BlogComment::where('article_id', $request->article_id)->with(['user', 'blog'])
                        ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                        ->limit($params['length'])->offset($params['start'])
                        ->get();
                }
            } else {
                if(!empty($params['search']['value'])){
                    $q = $params['search']['value'];
                    $comments = BlogComment::with(['user', 'blog'])
                        ->where('id', 'like', '%' . $q . '%')
                        ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                        ->limit($params['length'])->offset($params['start'])
                        ->get();
                }else{
                    $comments = BlogComment::with(['user', 'blog'])
                        ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                        ->limit($params['length'])->offset($params['start'])
                        ->get();
                }
            }

            $totalRecords = BlogComment::count();
            foreach ($comments as $row) {

                if ($row->user){
                    $user_detail = '<a href="'.route('admin.users.edit', $row->user->id).'" class="text-body">'.$row->user->firstname . ' ' . $row->user->lastname.'</a>';
                } else{
                    $user_detail = '<span>'.___('Anonymous').'</span>';
                }

                $approve_button = '';
                if ($row->status){
                    $status_badge = '<span class="badge bg-success">'.___('Approved').'</span>';
                } else{
                    $status_badge = '<span class="badge bg-warning text-dark">'.___('Pending').'</span>';
                    $approve_button = '<form class="d-inline" action = "'.route('admin.comments.approve', $row->id).'" method = "POST">
                                    '.csrf_field().'
                                <button class="btn btn-icon btn-primary me-1" title="'.___('Approve').'" data-tippy-placement="top"><i class="icon-feather-check"></i ></button>
                            </form>';
                }

                $rows = array();
                $rows[] = '<td>'.$row->id.'</td>';
                $rows[] = '<td>'.$user_detail.'</td>';
                $rows[] = '<td><a href="'.route('admin.blogs.edit', $row->blog->id).'" class="text-body">'.text_shorting($row->blogArticle->title, 30).'</a></td>';
                $rows[] = '<td>'.$row->comment.'</td>';
                $rows[] = '<td>'.$status_badge.'</td>';
                $rows[] = '<td>'.datetime_formating($row->created_at).'</td>';
                $rows[] = '<td>
                                <div class="d-flex">
                                    '.$approve_button.'
                                    <form class="d-inline" action="'.route('admin.comments.destroy', $row->id).'" method="POST" onsubmit=\'return confirm("'.___('Are you sure?').'")\'>
                                        '.method_field('DELETE').'
                                        '.csrf_field().'
                                    <button class="btn btn-icon btn-danger" title="'.___('Delete').'" data-tippy-placement="top"><i class="icon-feather-trash-2"></i ></button>
                                </form>
                                </div>
                            </td>';
                $rows[] = '<td>
                                <div class="checkbox">
                                <input type="checkbox" id="check_'.$row->id.'" value="'.$row->id.'" class="quick-check">
                                <label for="check_'.$row->id.'"><span class="checkbox-icon"></span></label>
                            </div>
                           </td>';
                $rows['DT_RowId'] = $row->id;
                $data[] = $rows;
            }

            $json_data = array(
                "draw"            => intval( $params['draw'] ),
                "recordsTotal"    => intval( $totalRecords ),
                "recordsFiltered" => intval($totalRecords),
                "data"            => $data   // total data array
            );
            return response()->json($json_data, 200);
        }

        if ($request->has('article_id')) {
            $article_id = $request->article_id;
        } else {
            $article_id = '';
        }
        return view('admin.blog.comments.index', compact('article_id'));
    }

    /**
     * Approve comment status
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Request $request, $id)
    {
        $comment = BlogComment::find($id);

        $comment->update(['status' => true]);
        quick_alert_success(___('Approved Successfully'));
        return back();
    }

    /**
     * Delete multiple comments
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $ids = array_map('intval', $request->ids);
        foreach($ids as $id){
            BlogComment::findOrFail($id);
        }
        BlogComment::whereIn('id',$ids)->delete();
        $result = array('success' => true, 'message' => ___('Deleted Successfully'));
        return response()->json($result, 200);
    }
}
