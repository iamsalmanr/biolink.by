<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
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
                'plan_id',
                'user_id',
                'total',
                'gateway',
                'created_at'
            );

            if (!empty($params['search']['value'])) {
                $q = $params['search']['value'];
                $transaction = Transaction::with(['user', 'plan', 'paymentGateway'])
                    ->whereNot('status', Transaction::STATUS_UNPAID)
                    ->where('id', 'like', '%' . $q . '%')
                    ->whereHas('user')
                    ->orderBy($columns[$params['order'][0]['column']], $params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            } else {
                $transaction = Transaction::with(['user', 'plan', 'paymentGateway'])
                    ->whereNot('status', Transaction::STATUS_UNPAID)
                    ->whereHas('user')
                    ->orderBy($columns[$params['order'][0]['column']], $params['order'][0]['dir'])
                    ->limit($params['length'])->offset($params['start'])
                    ->get();
            }

            $totalRecords = Transaction::whereNot('status', Transaction::STATUS_UNPAID)->whereHas('user')->count();
            foreach ($transaction as $row) {
                if ($row->paymentGateway) {
                    $gateway_badge = '<span class="badge bg-secondary">' . $row->paymentGateway->name . '</span>';
                } else {
                    $gateway_badge = '<span>-</span>';
                }

                if ($row->status == Transaction::STATUS_PENDING) {
                    $status_badge = '<span class="badge bg-info">' . ___('Pending') . '</span>';
                } elseif ($row->status == Transaction::STATUS_PAID) {
                    $status_badge = '<span class="badge bg-success">' . ___('Paid') . '</span>';
                } elseif ($row->status == Transaction::STATUS_CANCELLED) {
                    $status_badge = '<span class="badge bg-warning">' . ___('Cancelled') . '</span>';
                }

                $invoice_button = '';
                if ($row->status == Transaction::STATUS_PAID && $row->total > 0) {
                    $invoice_button = '<a href="' . route('invoice', $row->id) . '" title="' . ___('Invoice') . '" class="btn btn-default btn-icon ms-1" data-tippy-placement="top" target="_blank"><i class="icon-feather-paperclip"></i></a>';
                }

                $rows = array();
                $rows[] = '<td>' . $row->id . '</td>';
                $rows[] = '<td>' . $row->plan->name . '</td>';
                $rows[] = '<td><a class="text-body" href="'. route('admin.users.edit', $row->user->id).'">' . $row->user->name . '</a></td>';
                $rows[] = '<td>' . price_symbol_format($row->total) . '</td>';
                $rows[] = '<td>' . $gateway_badge . '</td>';
                $rows[] = '<td>' . $status_badge . '</td>';
                $rows[] = '<td>' . datetime_formating($row->created_at) . '</td>';
                $rows[] = '<td>
                                <div class="d-flex">
                                <button data-url=" ' . route('admin.transactions.edit', $row->id) . '" data-toggle="slidePanel" title="' . ___('Details') . '" class="btn btn-default btn-icon" data-tippy-placement="top"><i class="icon-feather-list"></i></button>
                                   '.$invoice_button.'
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

        /* Mark transactions as viewed */
        $rows = Transaction::where('is_viewed', 0)
            ->whereIn('status', [Transaction::STATUS_PENDING, Transaction::STATUS_PAID])
            ->get();
        foreach ($rows as $row) {
            $row->is_viewed = true;
            $row->save();
        }

        return view('admin.transactions.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        abort_if($transaction->status == Transaction::STATUS_UNPAID, 404);
        return view('admin.transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->status != Transaction::STATUS_PAID) {
            quick_alert_error(___('Can not cancel paid transaction.'));
            return back();
        }

        $response = $transaction->update(['status' => Transaction::STATUS_CANCELLED]);
        if ($response) {
            quick_alert_success(___('Transaction Canceled'));
            return back();
        }
    }

    /**
     * Remove multiple resources from storage.
     *
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $ids = array_map('intval', $request->ids);
        $sql = Transaction::whereIn('id', $ids)->delete();
        if ($sql) {
            $result = array('success' => true, 'message' => ___('Deleted Successfully'));
            return response()->json($result, 200);
        }
    }
}
