<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $orders = (\Auth::user()->hasRole('admin')) ? Order::all() : \Auth::user()->orders;
        return view('orders', [
            'orders' => $orders
        ]);
    }
}
