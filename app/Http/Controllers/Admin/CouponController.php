<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class CouponController extends Controller
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
                'code',
                'percentage',
                'used',
                'limit',
                'expiry_at',
                ''
            );

            if(!empty($params['search']['value'])){
                $q = $params['search']['value'];
                $coupon = Coupon::where('id', 'like', '%' . $q . '%')
                    ->OrWhere('code', 'like', '%' . $q . '%')
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }else{
                $coupon = Coupon::orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();

            }

            $totalRecords = Coupon::count();
            foreach ($coupon as $row) {

                if (!$row->isExpiry()){
                    $expiry_badge = datetime_formating($row->expiry_at);
                } else{
                    $expiry_badge = '<span class="badge bg-danger">'.___('Expired').'</span>';
                }

                $rows = array();
                $rows[] = '<td>'.$row->id.'</td>';
                $rows[] = '<td><strong>'.$row->code.'</strong></td>';
                $rows[] = '<td>'.$row->percentage.'% '.'</td>';
                $rows[] = '<td>'.$row->used.'</td>';
                $rows[] = '<td>'.$row->limit.'</td>';
                $rows[] = '<td>'.$expiry_badge.'</td>';
                $rows[] = '<td>
                                <div class="d-flex">
                                    <a href="#" data-url="'.route('admin.coupons.edit', $row->id).'" data-toggle="slidePanel" title="'.___('Edit').'" class="btn btn-default btn-icon" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
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

        return view('admin.coupons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.create');
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
            'code' => ['required', 'string', 'min:3', 'max:20', 'unique:coupons', 'regex:/^[a-zA-Z0-9]*$/'],
            'discount_percentage' => ['required', 'integer', 'min:1', 'max:100'],
            'expiry_at' => ['required'],
            'uses_limit' => ['required', 'integer', 'min:1'],
        ]);
        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        $request->expiry_at = Carbon::parse($request->expiry_at);

        if ($request->expiry_at < Carbon::now()) {
            $result = array('success' => false, 'message' => ___('The expiry date should be in the future.'));
            return response()->json($result, 200);
        }

        $coupon = Coupon::create([
            'code' => $request->code,
            'percentage' => $request->discount_percentage,
            'expiry_at' => $request->expiry_at,
            'limit' => $request->uses_limit,
        ]);
        if ($coupon) {
            $result = array('success' => true, 'message' => ___('Created Successfully'));
            return response()->json($result, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     */
    public function show(Coupon $coupon)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validator = Validator::make($request->all(), [
            'expiry_at' => ['required'],
            'uses_limit' => ['required', 'integer', 'min:1'],
        ]);
        $errors = [];
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $errors[] = $error;
            }
            $result = array('success' => false, 'message' => implode('<br>', $errors));
            return response()->json($result, 200);
        }

        if (Carbon::parse($request->expiry_at) != $coupon->expiry_at) {
            $request->expiry_at = Carbon::parse($request->expiry_at);

            if ($request->expiry_at < Carbon::now()) {
                $result = array('success' => false, 'message' => ___('The expiry date should be in the future.'));
                return response()->json($result, 200);
            }
        } else {
            $request->expiry_at = $coupon->expiry_at;
        }

        $update = $coupon->update([
            'expiry_at' => $request->expiry_at,
            'limit' => $request->uses_limit,
        ]);
        if ($update) {
            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     */
    public function destroy(Coupon $coupon)
    {
        abort(404);
    }

    /**
     * Remove the multiple resources from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $ids = array_map('intval', $request->ids);
        $sql = Coupon::whereIn('id',$ids)->delete();
        if($sql){
            $result = array('success' => true, 'message' => ___('Deleted Successfully'));
            return response()->json($result, 200);
        }
    }
}
