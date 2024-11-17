<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanOption;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Http\Request;

class PlanOptionController extends Controller
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
                'position',
                'title',
                'active'
            );

            if(!empty($params['search']['value'])){
                $q = $params['search']['value'];
                $admins = PlanOption::where('title', 'like', '%' . $q . '%')
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }else{
                $admins = PlanOption::orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }

            $totalRecords = PlanOption::count();
            foreach ($admins as $row) {
                $rows = array();

                if($row->active == 1){
                    $status_badge = '<span class="badge bg-success">'.___('Enabled').'</span>';
                } else{
                    $status_badge = '<span class="badge bg-danger">'.___('Disabled').'</span>';
                }
                $rows[] = '<td><i class="icon-feather-menu quick-reorder-icon"
                                       title="' . ___('Reorder') . '"></i> <span class="d-none">' . $row->id . '</span></td>';
                $rows[] = '<td>'.$row->title.'</td>';
                $rows[] = '<td>'.$status_badge.'</td>';
                $rows[] = '<td>
                                <div class="d-flex">
                                    <a href="#" data-url="'.route('admin.planoption.edit', $row->id).'" data-toggle="slidePanel" title="'.___('Edit').'" class="btn btn-default btn-icon" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
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

        return view('admin.planoption.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\PlanOption $planoption
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.planoption.create');
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
            'title' => ['required', 'string', 'max:255']
        ]);

        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $create = PlanOption::create([
            'title' => $request->title,
            'active' => $request->active,
            'translations' => $request->translations,
        ]);

        if ($create) {
            $result = array('success' => true, 'message' => ___('Created Successfully'));
            return response()->json($result, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PlanOption  $planoption
     */
    public function show(PlanOption $planoption)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @param  \App\Models\PlanOption  $planoption
     * @return \Illuminate\Http\Response
     */
    public function edit(PlanOption $planoption)
    {
        return view('admin.planoption.edit', compact('planoption'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PlanOption  $planoption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlanOption $planoption)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255']
        ]);

        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $update = $planoption->update([
            'title' => $request->title,
            'active' => $request->active,
            'translations' => $request->translations,
        ]);

        if ($update) {
            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlanOption $planoption
     * @return \Illuminate\Http\Response
     */
    public function reorder(Request $request)
    {
        $position = $request->position;
        if (is_array($request->position)) {
            $count = 0;
            foreach($position as $id){
                $update = PlanOption::where('id',$id)->update([
                    'position' => $count,
                ]);

                $count++;
            }
            if ($update) {
                $result = array('success' => true, 'message' => ___('Updated Successfully'));
                return response()->json($result, 200);
            }
        }

        $result = array('success' => true, 'message' => ___('Updated Successfully'));
        return response()->json($result, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlanOption  $planoption
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $ids = array_map('intval', $request->ids);
        PlanOption::whereIn('id',$ids)->delete();
        $result = array('success' => true, 'message' => ___('Deleted Successfully'));
        return response()->json($result, 200);
    }
}
