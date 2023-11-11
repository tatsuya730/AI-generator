<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * 決済フォーム表示
     */
    public function create()
    {
        return view('payment.create');
    }
}
