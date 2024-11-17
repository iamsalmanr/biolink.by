<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adsense;
use Illuminate\Http\Request;

class AdsController extends Controller
{
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
                'title',
                'status',
            );

            if(!empty($params['search']['value'])){
                $q = $params['search']['value'];
                $advertisements = Adsense::where('key','!=','head_code')
                    ->OrWhere('id', 'like', '%' . $q . '%')
                    ->OrWhere('title', 'like', '%' . $q . '%')
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }else{
                $advertisements = Adsense::where('key','!=','head_code')
                    ->orderBy($columns[$params['order'][0]['column']],$params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();

            }

            $totalRecords = Adsense::count();
            foreach ($advertisements as $row) {

                if ($row->status){
                    $status_badge = '<span class="badge bg-success">'.___('Enabled').'</span>';
                }else{
                    $status_badge = '<span class="badge bg-danger">'.___('Disabled').'</span>';
                }

                $rows = array();
                $rows[] = '<td>'.$row->id.'</td>';
                $rows[] = '<td>'.$row->title.'</td>';
                $rows[] = '<td>'.$status_badge.'</td>';
                $rows[] = '<td>
                                <div class="d-flex">
                                    <a href="#" data-url="'.route('admin.advertisements.edit', $row->id).'" data-toggle="slidePanel" title="'.___('Edit').'" class="btn btn-default btn-icon" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
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

        $headAd = Adsense::where('key', 'head_code')->first();
        return view('admin.ads.index', compact('headAd'));
    }

    /**
     * Display edit form
     *
     * @param Adsense $advertisement
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Adsense $advertisement)
    {
        return view('admin.ads.edit', compact('advertisement'));
    }

    /**
     * Update a resource
     *
     * @param Request $request
     * @param Adsense $advertisement
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function update(Request $request, Adsense $advertisement)
    {
        $update = $advertisement->update([
            'status' => $request->status,
            'code' => $request->code,
        ]);
        if ($update) {
            $result = array('success' => true, 'message' => ___('Updated Successfully'));
            return response()->json($result, 200);
        }
    }
}
