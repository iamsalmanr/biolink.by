<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Validator;
use Illuminate\Http\Request;

class TestimonialController extends Controller
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
                'name',
                'created_at'
            );

            if (!empty($params['search']['value'])) {
                $q = $params['search']['value'];
                $testimonial = Testimonial::where('name', 'like', '%' . $q . '%')
                    ->orderBy($columns[$params['order'][0]['column']], $params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            } else {
                $testimonial = Testimonial::orderBy($columns[$params['order'][0]['column']], $params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }

            $totalRecords = Testimonial::count();
            foreach ($testimonial as $row) {
                $rows = array();
                $rows[] = '<td>
                    <div class="d-flex align-items-center">
                        <img class="rounded-circle me-4" width="60" src="' . asset('storage/testimonials/'.$row->image) . '" />
                        <div>
                            <h6 class="mb-1 fw-bold">' . $row->name . '</h6>
                            <p class="text-muted mb-0">' . $row->designation . '</p>
                        </div>
                    </div>
                </td>';
                $rows[] = '<td>
                                <p>' . $row->content . '</p>
                            </td>';
                $rows[] = '<td>
                            <div class="d-flex">
                                <button data-url=" ' . route('admin.testimonials.edit', $row->id) . '" data-toggle="slidePanel" title="' . ___('Edit') . '" class="btn btn-default btn-icon" data-tippy-placement="top"><i class="icon-feather-edit"></i></button>
                            </div>
                            </td>';
                $rows[] = '<td>
                                <div class="checkbox">
                                <input type="checkbox" id="check_' . $row->id . '" value="' . $row->id . '" class="quick-check">
                                <label for="check_' . $row->id . '"><span class="checkbox-icon"></span></label>
                            </div>
                           </td>';
                $rows['DT_RowId'] = $row->id;
                $data[] = $rows;
            }

            $json_data = array(
                "draw" => intval($params['draw']),
                "recordsTotal" => intval($totalRecords),
                "recordsFiltered" => intval($totalRecords),
                "data" => $data // total data array
            );
            return response()->json($json_data, 200);
        }

        return view('admin.testimonials.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimonials.create');
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
            'name' => ['required', 'string', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:255'],
            'image' => ['image', 'mimes:png,jpg,jpeg'],
        ]);
        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        if ($request->has('image') && !empty($request->image)) {
            $uploadAvatar = image_upload($request->file('image'), 'storage/testimonials/', '110x110');
        } else {
            $uploadAvatar = 'default.png';
        }

        $create = Testimonial::create([
            'name' => $request->name,
            'content' => $request->content,
            'designation' => $request->designation,
            'image' => $uploadAvatar,
            'translations' => $request->translations,
        ]);

        if ($create) {
            $result = array('success' => true, 'message' => ___('Created Successfully'));
            return response()->json($result, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit(testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, testimonial $testimonial)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
        ]);

        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        if ($request->has('image') && $request->image != null) {
            if ($testimonial->image == 'default.png') {
                $uploadAvatar = image_upload($request->file('image'), 'storage/testimonials/', '110x110');
            } else {
                $uploadAvatar = image_upload($request->file('image'), 'storage/testimonials/', '110x110', null, $testimonial->image);
            }
        } else {
            $uploadAvatar = $testimonial->image;
        }

        $update = $testimonial->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'content' => $request->content,
            'image' => $uploadAvatar,
            'translations' => $request->translations,
        ]);
        if ($update) {
            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }
    }

    /**
     * Remove multiple resources from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $ids = array_map('intval', $request->ids);
        $admins = Testimonial::whereIn('id', $ids)->get();
        foreach ($admins as $admin) {
            if ($admin->image != "default.png") {
                remove_file('storage/testimonials/'.$admin->image);
            }
        }
        Testimonial::whereIn('id', $ids)->delete();

        $result = array('success' => true, 'message' => ___('Deleted Successfully'));
        return response()->json($result, 200);
    }
}
