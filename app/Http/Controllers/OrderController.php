<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index() {
        $orders = Order::with('user')->get();
        return view('admin.orders', ['orders' => $orders]);
    }

    public function cindex() {
        return view('orders', ['orders' => Order::with('user')->where('customer_id', Auth::user()->id)->get()]);
    }

    public function add(Request $r) {
        $r->validate([
            'address1' => 'required|string',
            'address2' => 'string|nullable',
            'city' => 'required|string',
            'state' => 'string|nullable',
            'country' => 'required',
            'postal' => 'required|integer|min:4|gt:0',
            'payment' => 'required'
        ]);

        $total = 0;
        $no_of_items = 0;

        foreach($_SESSION['cart'] as $p) {
            $total += $p['product']->price * $p['quantity'];
            $no_of_items += $p['quantity'];
        }

        $o = new Order;
        $o->created_at = date('Y-m-d');
        $o->customer_id = Auth::user()->id;
        $o->items = serialize($_SESSION['cart']);
        $o->status = 'Processing';
        $o->address = serialize([
            $r->address1,$r->address2,
            $r->city,$r->state,$r->country,
            $r->postal,$r->payment
        ]);
        $o->total = $total;
        $o->no_of_items = $no_of_items;
        $o->save();
        unset($_SESSION['cart']);
        return  redirect('/cart');
    }

    public function update(Request $r) {
        $o = Order::find($r->id);
        $o->status = $r->status;
        $o->save();
        return redirect('/admin/orders');
    }
    
}
