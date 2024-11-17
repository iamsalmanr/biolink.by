<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostLink;
use Illuminate\Http\Request;
use Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $params = $columns = $order = $totalRecords = $data = array();
            $params = $request;

            //define index of column
            $columns = array(
                'id',
                'title',
                'created_at'
            );

            if(!empty($params['search']['value'])){
                $q = $params['search']['value'];
                $admins = Post::where('title', 'like', '%' . $q . '%')
                    ->OrWhere('content', 'like', '%' . $q . '%')
                    ->with('user')
                    ->whereHas('user')
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }else{
                $admins = Post::with('user')
                    ->whereHas('user')
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }

            $totalRecords = Post::whereHas('user')->count();
            foreach ($admins as $row) {

                /* handle deleted users */
                if(!$row->user){
                    continue;
                }

                $rows = array();
                $rows[] = '<td>'.$row->id.'</td>';
                $rows[] = '<td>
                                <div class="quick-user-box">
                                    <a class="quick-user-avatar"
                                        href="#">
                                        <img src="'.asset('storage/post/logo/'.$row->image).'" />
                                    </a>
                                    <div>
                                        <a class="text-reset"
                                            href="'.url('/').'/'.$row->slug.'">'.$row->title.'</a>
                                        <p class="text-muted mb-0">'.$row->content.'</p>
                                    </div>
                                </div>
                            </td>';
                $rows[] = '<td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-2">
                                        <a href="'.route('admin.users.edit', $row->user->id).'">
                                            <img class="rounded-circle" alt="'.$row->user->username.'" src="'.asset('storage/users/'.$row->user->avatar).'" />
                                        </a>
                                    </div>
                                    <div>
                                        <a class="text-body fw-semibold text-truncate"
                                            href="'.route('admin.users.edit', $row->user->id).'">'.$row->user->name.'</a>
                                        <p class="text-muted mb-0">@'.$row->user->username.'</p>
                                    </div>
                                </div>
                            </td>';
                $rows[] = '<td>'.datetime_formating($row->created_at).'</td>';
                $rows[] = '<td>
                                <div class="d-flex">
                                    <a href="'.url('/').'/'.$row->slug.'" title="'.___('View').'" class="btn btn-primary btn-icon" data-tippy-placement="top" target="_blank"><i class="icon-feather-eye"></i></a>
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

        return view('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $ids = array_map('intval', $request->ids);
        $biolinks = Post::whereIn('id',$ids)->get();
        foreach($biolinks as $biolink){
            $links = PostLink::where('post_id', $biolink->id)->get();
            foreach($links as $link){
                if($link->type == "link"){
                    if ($link->settings->logo != '') {
                        remove_file('storage/post/biolink/'.$link->settings->logo);
                    }
                }
                $link->delete();
            }

            if(!empty($biolink->image)) {
                remove_file('storage/post/logo/' . $biolink->image);
            }

            $postOptions = post_options($biolink->id);
            $coverImage = @$postOptions->cover_image;
            if(!empty($coverImage)) {
                remove_file('storage/post/logo/' . $coverImage);
            }
        }

        Post::whereIn('id',$ids)->delete();
        $result = array('success' => true, 'message' => ___('Deleted Successfully'));
        return response()->json($result, 200);
    }

}
