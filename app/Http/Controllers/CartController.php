<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function getOrCreateCart()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id]);
        }
        return $cart;
    }

    public function index()
    {
        $cart = $this->getOrCreateCart();
        $items = CartItem::with('product')->where('cart_id', $cart->id)->get();
        
        $totalPrice = 0;
        foreach ($items as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }

        return view('cart.index', compact('items', 'totalPrice'));
    }

    public function add($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $cart = $this->getOrCreateCart();
        
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $product->id)
                            ->first();

        $quantity = $request->input('quantity', 1);

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        if ($request->wantsJson() || $request->ajax()) {
            $cartCount = $cart->items()->sum('quantity');
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang!',
                'cartCount' => $cartCount
            ]);
        }

        return redirect()->route('cart')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update($id, Request $request)
    {
        $request->validate(['quantity' => 'required|integer']);
        $cartItem = CartItem::findOrFail($id);
        
        $quantity = $request->quantity;
        if ($quantity <= 0) {
            $cartItem->delete();
            return redirect()->route('cart')->with('success', 'Item berhasil dihapus dari keranjang.');
        }

        // Check stock limit
        if ($quantity > $cartItem->product->stock) {
            return redirect()->route('cart')->with('error', 'Stok produk tidak mencukupi.');
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        return redirect()->route('cart')->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
