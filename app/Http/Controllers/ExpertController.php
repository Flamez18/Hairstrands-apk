<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HairExpert;
use App\Models\ExpertSchedule;
use App\Models\ConsultationBooking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExpertController extends Controller
{
    public function index(Request $request)
    {
        $query = HairExpert::query();

        if ($request->has('specialty') && !empty($request->specialty)) {
            $query->where('specialty', $request->specialty);
        }

        $experts = $query->get();
        $activeSpecialty = $request->specialty ?? '';

        return view('experts.index', compact('experts', 'activeSpecialty'));
    }

    public function detail($id, Request $request)
    {
        $expert = HairExpert::findOrFail($id);
        
        // Generate dates for next 5 days
        $dates = [];
        for ($i = 1; $i <= 5; $i++) {
            $d = Carbon::now()->addDays($i);
            $dates[] = [
                'full' => $d->format('Y-m-d'),
                'day_name' => $d->translatedFormat('D'), // e.g. Sen, Sel
                'day_num' => $d->format('d'),
            ];
        }

        // Active selected date
        $selectedDate = $request->input('date', $dates[0]['full']);

        // Fetch available slots for that date
        $slots = ExpertSchedule::where('hair_expert_id', $expert->id)
                                ->where('date', $selectedDate)
                                ->get();

        return view('experts.detail', compact('expert', 'dates', 'selectedDate', 'slots'));
    }

    public function booking(Request $request)
    {
        $request->validate([
            'hair_expert_id' => 'required|exists:hair_experts,id',
            'expert_schedule_id' => 'required|exists:expert_schedules,id',
            'type' => 'required|string|in:Live Chat,Video Call',
            'complaint' => 'nullable|string',
        ]);

        $schedule = ExpertSchedule::findOrFail($request->expert_schedule_id);

        // Check if already booked
        if ($schedule->is_booked) {
            return back()->with('error', 'Jadwal yang Anda pilih sudah dipesan oleh orang lain. Silakan pilih jadwal lain.');
        }

        $user = Auth::user();

        // Create Booking
        $booking = ConsultationBooking::create([
            'user_id' => $user->id,
            'hair_expert_id' => $request->hair_expert_id,
            'expert_schedule_id' => $request->expert_schedule_id,
            'type' => $request->type,
            'complaint' => $request->complaint,
            'status' => 'pending' // pending, completed, cancelled
        ]);

        // Mark slot as booked
        $schedule->is_booked = true;
        $schedule->save();

        return redirect()->route('experts.booking_success', $booking->id);
    }

    public function bookingSuccess($id)
    {
        $booking = ConsultationBooking::with(['expert', 'schedule'])->findOrFail($id);
        return view('experts.success', compact('booking'));
    }
}
