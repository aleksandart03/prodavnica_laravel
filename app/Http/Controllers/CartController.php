<?php


namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function getOrCreateCart()
    {
        $cartId = Cookie::get('cart_id');

        if (!$cartId || !Cart::find($cartId)) {
            $cart = Cart::create();
            Cookie::queue('cart_id', $cart->id,  10080);
            return $cart;
        }

        return Cart::find($cartId);
    }

    public function index()
    {
        $cart = $this->getOrCreateCart();
        return view('cart.index', compact('cart'));
    }

    public function addProductToCart($productId)
    {
        $cart = $this->getOrCreateCart();
        $product = Product::findOrFail($productId);

        $existing = $cart->products()->where('product_id', $productId)->first();

        if ($existing) {
            $cart->products()->updateExistingPivot($productId, [
                'quantity' => DB::raw('quantity + 1')
            ]);
        } else {
            $cart->products()->attach($productId, ['quantity' => 1]);
        }

        return back()->with('success', 'Product added to cart.');
    }

    public function removeProductFromCart($productId)
    {
        $cart = $this->getOrCreateCart();
        $cart->products()->detach($productId);
        return redirect()->route('cart.index')->with('success', 'Product removed.');
    }

    public function increaseQuantity($productId)
    {
        $cart = $this->getOrCreateCart();
        $cart->products()->updateExistingPivot($productId, [
            'quantity' => DB::raw('quantity + 1')
        ]);
        return redirect()->route('cart.index')->with('success', 'Quantity increased.');
    }

    public function decreaseQuantity($productId)
    {
        $cart = $this->getOrCreateCart();
        $product = $cart->products()->where('product_id', $productId)->first();

        if ($product && $product->pivot->quantity <= 1) {
            $cart->products()->detach($productId);
            return redirect()->route('cart.index')->with('success', 'Product removed');
        } else {
            $cart->products()->updateExistingPivot($productId, [
                'quantity' => DB::raw('quantity - 1')
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Quantity decreased.');
    }

    public function clearCart()
    {
        $cart = $this->getOrCreateCart();
        $cart->products()->detach();
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
