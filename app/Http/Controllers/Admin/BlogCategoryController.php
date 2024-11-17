<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Language;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Validator;

class BlogCategoryController extends Controller
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
                'lang',
                'name',
                'created_at'
            );
            if ($request->has('lang')) {
                $language = Language::where('code', $request->lang)->firstOrFail();
            }else{
                $language = Language::where('code', env('DEFAULT_LANGUAGE'))->firstOrFail();
            }
            if(!empty($params['search']['value'])){
                $q = $params['search']['value'];
                $categories = BlogCategory::where('lang', $language->code)->with('language')
                    ->where('id', 'like', '%' . $q . '%')
                    ->OrWhere('name', 'like', '%' . $q . '%')
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }else{
                $categories = BlogCategory::where('lang', $language->code)->with('language')
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }

            $totalRecords = BlogCategory::count();
            foreach ($categories as $row) {

                $rows = array();
                $rows[] = '<td>'.$row->id.'</td>';
                $rows[] = '<td><span class="text-uppercase">'.$row->language->code.'</span></td>';
                $rows[] = '<td>'.$row->name.'</td>';
                $rows[] = '<td>'.datetime_formating($row->created_at).'</td>';
                $rows[] = '<td>
                                <div class="d-flex">
                                    <a href="'.route('blog.category', $row->slug).'" target="_blank" title="'.___('View').'" class="btn btn-default btn-icon me-1" data-tippy-placement="top"><i class="icon-feather-eye"></i></a>
                                    <a href="#" data-url="'.route('admin.categories.edit', $row->id).'" data-toggle="slidePanel" title="'.___('Edit').'" class="btn btn-default btn-icon" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
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

        if ($request->has('lang')) {
            $language = Language::where('code', $request->lang)->firstOrFail();

            $current_language = $language->code;
            $lang = $request->lang;
            return view('admin.blog.categories.index', compact('current_language', 'lang'));
        } else {
            return redirect(url()->current() . '?lang=' . env('DEFAULT_LANGUAGE'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blog.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:255'],
            'slug' => ['nullable', 'unique:blog_categories', 'alpha_dash'],
            'lang' => ['required', 'string', 'max:3'],
        ]);
        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $lang = Language::where('code', $request->lang)->firstOrFail();

        $category = BlogCategory::create([
            'name' => $request->name,
            'slug' => !empty($request->slug)
                ? $request->slug
                : SlugService::createSlug(BlogCategory::class, 'slug', $request->name),
            'lang' => $lang->code,
        ]);

        if ($category) {
            $result = array('success' => true, 'message' => ___('Created Successfully'));
            return response()->json($result, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogCategory  $category
     */
    public function show(BlogCategory $category)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogCategory $category)
    {
        return view('admin.blog.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogCategory $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:255'],
            'slug' => ['required', 'alpha_dash', 'unique:blog_categories,slug,' . $category->id],
            'lang' => ['required', 'string', 'max:3'],
        ]);
        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $lang = Language::where('code', $request->lang)->firstOrFail();

        $update = $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'lang' => $lang->code,
        ]);
        if ($update) {
            $blogs = Blog::where('category_id', $category->id)->get();
            foreach ($blogs as $blog) {
                $blog->update(['lang' => $category->lang]);
            }

            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogCategory  $category
     */
    public function destroy(BlogCategory $category)
    {
        abort(404);
    }

    /**
     * Remove the multiple resources from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $ids = array_map('intval', $request->ids);
        $blogs = Blog::whereIn('category_id', $ids)->get();
        foreach ($blogs as $blog) {
            remove_file('storage/blog/'.$blog->image);
            $blog->delete();
        }

        $sql = BlogCategory::whereIn('id',$ids)->delete();
        if($sql){
            $result = array('success' => true, 'message' => ___('Deleted Successfully'));
            return response()->json($result, 200);
        }
    }
}
