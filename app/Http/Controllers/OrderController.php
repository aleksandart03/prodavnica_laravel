<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkoutForm()
    {
        return view('checkout.home');
    }

    public function checkoutConfirmed()
    {
        return view('checkout.confirmed');
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
        ]);

        $cartId = Cookie::get('cart_id');
        $cart = Cart::with('products')->findOrFail($cartId);

        $total = 0;
        foreach ($cart->products as $product) {
            $total += $product->pivot->quantity * $product->price;
        }

        $order = Order::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'total_price' => $total,
        ]);

        $data = [];

        foreach ($cart->products as $product) {
            $data[] = [
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $product->pivot->quantity,
                'price' => $product->price,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        OrderProduct::insert($data);

        $cart->products()->detach();
        $cart->delete();
        Cookie::queue(Cookie::forget('cart_id'));

        return redirect()->route('checkout.confirmed')->with('order', $order);
    }
}
