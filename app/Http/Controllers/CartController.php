<?php


namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function addProductToCart(Request $request, $productId)
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

        Log::info('Product added to cart', [
            'cart_id' => $cart->id,
            'product_id' => $productId,
            'quantity' => $existing ? 'incremented by 1' : 1,
        ]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Product added to cart!']);
        }

        return back()->with('success', 'Product added to cart.');
    }

    public function removeProductFromCart(Request $request, $productId)
    {
        $cart = $this->getOrCreateCart();
        $cart->products()->detach($productId);

        if ($request->ajax()) {
            $cartCount = $cart->products()->count();
            $total = $cart->products->sum(fn($p) => $p->price * $p->pivot->quantity);

            return response()->json([
                'removed' => true,
                'product_id' => $productId,
                'cart_total' => number_format($total, 2),
                'message' => 'Product removed from cart.',
                'cart_count' => $cartCount,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed.');
    }

    public function increaseQuantity(Request $request, $productId)
    {
        $cart = $this->getOrCreateCart();
        $cart->products()->updateExistingPivot($productId, [
            'quantity' => DB::raw('quantity + 1')
        ]);

        $product = $cart->products()->where('product_id', $productId)->first();
        $total = $cart->products->sum(fn($p) => $p->price * $p->pivot->quantity);

        if ($request->ajax()) {
            return response()->json([
                'quantity' => $product->pivot->quantity,
                'item_total' => number_format($product->price * $product->pivot->quantity, 2),
                'cart_total' => number_format($total, 2),
                'message' => 'Quantity increased.'
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Quantity increased.');
    }

    public function decreaseQuantity(Request $request, $productId)
    {
        $cart = $this->getOrCreateCart();
        $product = $cart->products()->where('product_id', $productId)->first();

        if ($product && $product->pivot->quantity <= 1) {
            $cart->products()->detach($productId);

            if ($request->ajax()) {
                $total = $cart->products->sum(fn($p) => $p->price * $p->pivot->quantity);

                return response()->json([
                    'removed' => true,
                    'product_id' => $productId,
                    'cart_total' => number_format($total, 2),
                    'message' => 'Product removed (quantity was 1).'
                ]);
            }

            return redirect()->route('cart.index')->with('success', 'Product removed');
        } else {
            $cart->products()->updateExistingPivot($productId, [
                'quantity' => DB::raw('quantity - 1')
            ]);

            $product = $cart->products()->where('product_id', $productId)->first();
            $total = $cart->products->sum(fn($p) => $p->price * $p->pivot->quantity);

            if ($request->ajax()) {
                return response()->json([
                    'quantity' => $product->pivot->quantity,
                    'item_total' => number_format($product->price * $product->pivot->quantity, 2),
                    'cart_total' => number_format($total, 2),
                    'message' => 'Quantity decreased.'
                ]);
            }

            return redirect()->route('cart.index')->with('success', 'Quantity decreased.');
        }
    }

    public function clearCart(Request $request)
    {
        $cart = $this->getOrCreateCart();
        $cart->products()->detach();

        if ($request->ajax()) {
            return response()->json([
                'cleared' => true,
                'cart_total' => '0.00',
                'message' => 'Cart cleared.',
                'cart_count' => 0,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

    public function updateQuantity(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $this->getOrCreateCart();
        $cart->products()->updateExistingPivot($productId, [
            'quantity' => $request->quantity
        ]);

        $product = $cart->products()->where('product_id', $productId)->first();
        $total = $cart->products->sum(fn($p) => $p->price * $p->pivot->quantity);

        if ($request->ajax()) {
            return response()->json([
                'quantity' => $product->pivot->quantity,
                'item_total' => number_format($product->price * $product->pivot->quantity, 2),
                'cart_total' => number_format($total, 2),
                'message' => 'Quantity updated.'
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Quantity updated.');
    }
}
