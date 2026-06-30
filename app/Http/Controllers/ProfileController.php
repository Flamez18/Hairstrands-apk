<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ConsultationBooking;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Fetch order history (latest first)
        $orders = Order::with('items.product')
                       ->where('user_id', $user->id)
                       ->orderBy('created_at', 'desc')
                       ->get();

        // Fetch booking history (latest first)
        $bookings = ConsultationBooking::with(['expert', 'schedule'])
                                       ->where('user_id', $user->id)
                                       ->orderBy('created_at', 'desc')
                                       ->get();

        // Mock Hair Scan History (Matches the design layouts)
        $scans = [
            [
                'date' => '24 Okt 2023',
                'issue' => 'Iritasi Kulit Kepala',
                'score' => '82/100',
                'type' => 'Rekomendasi AI',
                'status' => 'Kekeringan'
            ],
            [
                'date' => '12 Okt 2023',
                'issue' => 'Kerusakan Panas',
                'score' => '64/100',
                'type' => 'Rekomendasi AI',
                'status' => 'Paling Buruk'
            ],
            [
                'date' => '28 Sep 2023',
                'issue' => 'Kesehatan Optimal',
                'score' => '94/100',
                'type' => 'Minyak Rendah',
                'status' => 'Sehat'
            ]
        ];

        // Mock Current Hair Analysis for profile view card
        $analysis = [
            'type' => 'Bergelombang 2A',
            'scalp' => 'Agak Kering',
            'porosity' => 'Low Porosity',
            'date' => '25 April 2026',
            'moisture' => 70,
            'strength' => 50,
            'health' => 30
        ];

        return view('profile.index', compact('user', 'orders', 'bookings', 'scans', 'analysis'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('profile')->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
