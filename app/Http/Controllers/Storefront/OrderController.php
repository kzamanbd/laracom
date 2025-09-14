<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Orders\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function confirmOrder(Request $request, Order $order)
    {
        return view('storefront.order-confirmation', compact('order'));
    }
}
