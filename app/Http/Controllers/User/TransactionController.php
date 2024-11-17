<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Str;

class TransactionController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activeTheme = active_theme();
    }

    /**
     * Display the page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $transactions = Transaction::where('user_id', request()->user()->id)->whereNot('status', Transaction::STATUS_UNPAID)->orderbyDesc('id')->get();
        return view($this->activeTheme.'.user.transactions', ['transactions' => $transactions]);
    }

    /**
     * Display the invoice
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function invoice(Transaction $transaction)
    {
        abort_if($transaction->status != Transaction::STATUS_PAID || $transaction->total == 0, 404);

        if(request()->user()->user_type != 'admin' && $transaction->user_id != request()->user()->id){
            abort(404);
        }

        return view('admin.transactions.invoice', ['transaction' => $transaction]);
    }
}
