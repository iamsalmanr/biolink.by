<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanOption;
use App\Models\Settings;
use Illuminate\Http\Request;
use Validator;

class PlanController extends Controller
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
                'name',
                'monthly_price',
                'annual_price',
                'lifetime_price'
            );

            if (!empty($params['search']['value'])) {
                $q = $params['search']['value'];
                $plans = Plan::where('name', 'like', '%' . $q . '%')
                    ->OrWhere('price', 'like', '%' . $q . '%')
                    ->orderBy($columns[$params['order'][0]['column']], $params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            } else {
                $plans = Plan::orderBy($columns[$params['order'][0]['column']], $params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }

            $totalRecords = Plan::count();

            /* get default plans */
            $free_plan = config('settings.free_membership_plan');
            $rows = array();
            $rows[] = '<td></td>';
            $rows[] = '<td>' . $free_plan->name . '</td>';
            $rows[] = '<td>-</td>';
            $rows[] = '<td>-</td>';
            $rows[] = '<td>-</td>';
            $rows[] = '<td>
                            <div class="d-flex">
                                <a href="#" data-url="' . route('admin.plans.edit', $free_plan->id) . '" data-toggle="slidePanel" title="' . ___('Edit') . '" class="btn btn-icon btn-default" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                            </div>
                        </td>';
            $rows[] = '<td></td>';
            $rows['DT_RowId'] = $free_plan->id;
            $data[] = $rows;

            $trial_plan = config('settings.trial_membership_plan');
            $rows = array();
            $rows[] = '<td></td>';
            $rows[] = '<td>' . $trial_plan->name . '</td>';
            $rows[] = '<td>-</td>';
            $rows[] = '<td>-</td>';
            $rows[] = '<td>-</td>';
            $rows[] = '<td>
                            <div class="d-flex">
                                <a href="#" data-url="' . route('admin.plans.edit', $trial_plan->id) . '" data-toggle="slidePanel" title="' . ___('Edit') . '" class="btn btn-icon btn-default" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                            </div>
                        </td>';
            $rows[] = '<td></td>';
            $rows['DT_RowId'] = $trial_plan->id;
            $data[] = $rows;

            foreach ($plans as $row) {

                $rows = array();
                $rows[] = '<td><i class="icon-feather-menu quick-reorder-icon"
                                       title="' . ___('Reorder') . '"></i> <span class="d-none">' . $row->id . '</span></td>';
                $rows[] = '<td>' . $row->name . '</td>';
                $rows[] = '<td>' . ($row->monthly_price ? price_symbol_format($row->monthly_price) : '-') . '</td>';
                $rows[] = '<td>' . ($row->monthly_price ? price_symbol_format($row->annual_price) : '-') . '</td>';
                $rows[] = '<td>' . ($row->monthly_price ? price_symbol_format($row->lifetime_price) : '-') . '</td>';
                $rows[] = '<td>
                                <div class="d-flex">
                                    <a href="#" data-url="' . route('admin.plans.edit', $row->id) . '" data-toggle="slidePanel" title="' . ___('Edit') . '" class="btn btn-icon btn-default" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
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
                "data" => $data   // total data array
            );
            return response()->json($json_data, 200);
        }

        return view('admin.plans.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\PlanOption $PlanOption
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $PlanOption = PlanOption::where('active', '1')->get();
        return view('admin.plans.create', compact('PlanOption'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'monthly_price' => ['required', 'numeric'],
            'annual_price' => ['required', 'numeric'],
            'lifetime_price' => ['required', 'numeric'],
            'biolink_limit' => ['required', 'integer', 'min:-1'],
            'biopage_limit' => ['required', 'integer', 'min:-1'],
        ]);

        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $settings = array(
            'biolink_limit' => $request->biolink_limit,
            'biopage_limit' => $request->biopage_limit,
            'hide_branding' => $request->hide_branding,

            'advertisements' => $request->advertisements,
            'custom_features' => $request->planoptions
        );

        $plan = Plan::create([
            'status' => $request->status,
            'name' => $request->name,
            'description' => $request->description,
            'translations' => $request->translations,
            'monthly_price' => $request->monthly_price,
            'annual_price' => $request->annual_price,
            'lifetime_price' => $request->lifetime_price,
            'recommended' => $request->recommended,
            'settings' => $settings,
        ]);
        if ($plan) {
            $result = array('success' => true, 'message' => ___('Created Successfully'));
            return response()->json($result, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Plan $plan
     */
    public function show(Plan $plan)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $plan
     * @param \App\Models\Plan $PlanOption
     * @return \Illuminate\Http\Response
     */
    public function edit($plan)
    {
        if($plan == 'free'){
            $plan = config('settings.free_membership_plan');
        } else if($plan == 'trial'){
            $plan = config('settings.trial_membership_plan');
        } else {
            $plan = Plan::findOrFail($plan);
        }

        $PlanOption = PlanOption::where('active', '1')->get();
        return view('admin.plans.edit', compact('plan', 'PlanOption'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $plan)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'monthly_price' => ['sometimes', 'numeric'],
            'annual_price' => ['sometimes', 'numeric'],
            'lifetime_price' => ['sometimes', 'numeric'],
            'biolink_limit' => ['required', 'integer', 'min:-1'],
            'biopage_limit' => ['required', 'integer', 'min:-1'],
            'days' => ['sometimes', 'integer', 'min:1'],
        ]);
        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $settings = array(
            'biolink_limit' => $request->biolink_limit,
            'biopage_limit' => $request->biopage_limit,
            'hide_branding' => $request->hide_branding,

            'advertisements' => $request->advertisements,
            'custom_features' => $request->planoptions
        );

        if($plan == 'free'){
            Settings::updateSettings('free_membership_plan',[
                'id' => 'free',
                'status' => $request->status,
                'name' => $request->name,
                'description' => $request->description,
                'translations' => $request->translations,
                'settings' => $settings,
            ]);
        } else if($plan == 'trial'){
            Settings::updateSettings('trial_membership_plan',[
                'id' => 'trial',
                'status' => $request->status,
                'name' => $request->name,
                'description' => $request->description,
                'translations' => $request->translations,
                'settings' => $settings,
                'days' => $request->days,
            ]);
        } else {
            $plan = Plan::findOrFail($plan);
            $plan->update([
                'status' => $request->status,
                'name' => $request->name,
                'description' => $request->description,
                'translations' => $request->translations,
                'monthly_price' => $request->monthly_price,
                'annual_price' => $request->annual_price,
                'lifetime_price' => $request->lifetime_price,
                'recommended' => $request->recommended,
                'settings' => $settings,
            ]);
        }

        $result = array('success' => true, 'message' => ___('Updated Successfully'));
        return response()->json($result, 200);

    }

    /**
     * Reorder the resources
     *
     * @param \App\Models\Plan $plan
     * @return \Illuminate\Http\Response
     */
    public function reorder(Request $request)
    {
        $position = $request->position;
        if (is_array($request->position)) {
            $count = 0;
            foreach ($position as $id) {
                $update = Plan::where('id', $id)->update([
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
     * @param \App\Models\Plan $plan
     */
    public function destroy(Plan $plan)
    {
        abort(404);
    }

    /**
     * Remove the multiple resources from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $ids = array_map('intval', $request->ids);
        $plans = Plan::whereIn('id', $ids)->get();
        foreach ($plans as $plan) {

            if ($plan->users->count() > 0) {
                $result = array('success' => false, 'message' => $plan->name . ' : '.___("This plan is assigned to a few users, edit user's plan first."));
                return response()->json($result, 200);
            }
        }

        Plan::whereIn('id', $ids)->delete();

        $result = array('success' => true, 'message' => ___('Deleted Successfully'));
        return response()->json($result, 200);
    }
}
