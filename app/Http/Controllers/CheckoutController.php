<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        
        if (!$cart || $cart->items()->count() === 0) {
            return redirect()->route('cart')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $items = CartItem::with('product')->where('cart_id', $cart->id)->get();
        
        $totalPrice = 0;
        foreach ($items as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }

        $paymentMethods = [
            'QRIS' => 'QRIS (Gopay, OVO, Dana)',
            'BCA VA' => 'BCA Virtual Account',
            'Mandiri VA' => 'Mandiri Virtual Account',
            'GoPay' => 'GoPay',
            'OVO' => 'OVO',
            'DANA' => 'DANA'
        ];

        return view('checkout.index', compact('items', 'totalPrice', 'user', 'paymentMethods'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->items()->count() === 0) {
            return redirect()->route('cart')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $items = CartItem::with('product')->where('cart_id', $cart->id)->get();
        
        // Calculate total price and validate stock
        $totalPrice = 0;
        foreach ($items as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->route('cart')->with('error', "Stok untuk produk {$item->product->name} tidak mencukupi.");
            }
            $totalPrice += $item->product->price * $item->quantity;
        }

        // Generate invoice number e.g. INV-20260630-XXXX
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        // Create Order
        $order = Order::create([
            'user_id' => $user->id,
            'invoice_number' => $invoiceNumber,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
        ]);

        // Create Order Items and update product stock
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);

            // Deduct stock
            $item->product->stock -= $item->quantity;
            $item->product->save();
        }

        // Clear cart
        CartItem::where('cart_id', $cart->id)->delete();

        // Save phone and address to user profile if blank
        if (empty($user->address) || empty($user->phone)) {
            $user->address = $request->shipping_address;
            if ($request->has('phone')) {
                $user->phone = $request->phone;
            }
            $user->save();
        }

        // Simulate payment success immediately (bypassing dummy payment page)
        $order->status = 'paid';
        $order->save();

        \App\Models\Payment::create([
            'order_id' => $order->id,
            'payment_method' => $order->payment_method,
            'payment_status' => 'success',
            'payment_amount' => $order->total_price,
            'transaction_id' => 'TX-' . date('YmdHis') . '-' . strtoupper(Str::random(4)),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'redirect' => route('payment.success', $order->id)
            ]);
        }

        return redirect()->route('payment.success', $order->id);
    }
}
