<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function dummy($id)
    {
        $order = Order::findOrFail($id);
        
        // Block paid orders from paying again
        if ($order->status === 'paid') {
            return redirect()->route('payment.success', $order->id);
        }

        // Setup mock details based on selected payment method
        $paymentDetails = [];
        switch ($order->payment_method) {
            case 'QRIS':
                $paymentDetails['title'] = 'Scan Kode QRIS';
                $paymentDetails['instruction'] = 'Gunakan aplikasi e-wallet Anda (Gopay, OVO, Dana, LinkAja) untuk melakukan scan QR code di bawah ini.';
                $paymentDetails['value'] = 'PureStrands QRIS Code';
                break;
            case 'BCA VA':
                $paymentDetails['title'] = 'Transfer BCA Virtual Account';
                $paymentDetails['instruction'] = 'Lakukan transfer ke nomor BCA Virtual Account berikut melalui m-BCA, klikBCA, atau ATM BCA.';
                $paymentDetails['value'] = '88012' . date('Ymd') . rand(10, 99);
                break;
            case 'Mandiri VA':
                $paymentDetails['title'] = 'Transfer Mandiri Virtual Account';
                $paymentDetails['instruction'] = 'Lakukan transfer ke nomor Mandiri Virtual Account berikut melalui Livin by Mandiri atau ATM Mandiri.';
                $paymentDetails['value'] = '89102' . date('Ymd') . rand(10, 99);
                break;
            case 'GoPay':
            case 'OVO':
            case 'DANA':
                $paymentDetails['title'] = 'E-Wallet ' . $order->payment_method;
                $paymentDetails['instruction'] = 'Lakukan transfer ke nomor e-wallet / nomor HP terdaftar berikut.';
                $paymentDetails['value'] = '0812-3456-7890';
                break;
            default:
                $paymentDetails['title'] = 'Pembayaran PureStrands';
                $paymentDetails['instruction'] = 'Lakukan pembayaran sesuai instruksi.';
                $paymentDetails['value'] = 'PAY-' . Str::random(10);
        }

        return view('payment.dummy', compact('order', 'paymentDetails'));
    }

    public function simulateProcess($id, Request $request)
    {
        $order = Order::findOrFail($id);
        
        if ($order->status !== 'paid') {
            // Update order status
            $order->status = 'paid';
            $order->save();

            // Create Payment record
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $order->payment_method,
                'payment_status' => 'success',
                'payment_amount' => $order->total_price,
                'transaction_id' => 'TX-' . date('YmdHis') . '-' . strtoupper(Str::random(4)),
            ]);
        }

        return response()->json(['status' => 'success', 'redirect' => route('payment.success', $order->id)]);
    }

    public function success($id)
    {
        $order = Order::findOrFail($id);
        return view('payment.success', compact('order'));
    }

    public function invoice($id)
    {
        $order = Order::with(['items.product', 'payment'])->findOrFail($id);
        return view('payment.invoice', compact('order'));
    }
}
