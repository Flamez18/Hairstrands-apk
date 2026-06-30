@extends('layouts.app')

@section('title', $expert->name . ' - Booking Konsultasi')

@section('header')
    <a href="{{ route('experts') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="header-title">Booking Konsultasi</div>
    <div></div>
@endsection

@section('content')
{{-- Expert Info Card --}}
<div style="display: flex; align-items: center; gap: 14px; background: white; border: 1px solid var(--border); border-radius: 16px; padding: 16px; margin-bottom: 24px;">
    <div style="width: 56px; height: 56px; border-radius: 12px; background: linear-gradient(135deg, var(--primary-light), #c6eed9); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 700; color: var(--primary); flex-shrink: 0;">
        {{ substr($expert->name, 4, 1) }}
    </div>
    <div style="flex: 1;">
        <div style="font-size: 0.95rem; font-weight: 700;">{{ $expert->name }}</div>
        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $expert->profile }}</div>
        <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 2px;"><i class="fa-regular fa-clock"></i> {{ $expert->experience }}</div>
    </div>
    <div>
        <div style="font-size: 0.8rem; font-weight: 800; color: var(--primary);">Rp {{ number_format($expert->price, 0, ',', '.') }}</div>
        <div style="font-size: 0.65rem; color: var(--text-muted); text-align: right;">/sesi</div>
    </div>
</div>

<form action="{{ route('experts.booking') }}" method="POST">
    @csrf
    <input type="hidden" name="hair_expert_id" value="{{ $expert->id }}">
    <input type="hidden" name="expert_schedule_id" id="selected-schedule-id" value="">

    @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <div><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</div>
        @endforeach
    </div>
    @endif

    {{-- Consultation Type --}}
    <div style="font-size: 0.85rem; font-weight: 700; margin-bottom: 12px;">Tipe Konsultasi</div>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 24px;">
        <label class="payment-option active" id="type-livechat" onclick="selectType('Live Chat', this)">
            <div style="font-size: 1.2rem; margin-bottom: 6px;"><i class="fa-regular fa-comment-dots"></i></div>
            <div>Live Chat</div>
        </label>
        <label class="payment-option" id="type-videocall" onclick="selectType('Video Call', this)">
            <div style="font-size: 1.2rem; margin-bottom: 6px;"><i class="fa-solid fa-video"></i></div>
            <div>Video Call</div>
        </label>
    </div>
    <input type="hidden" name="type" id="type-input" value="Live Chat">

    {{-- Date Selector --}}
    <div style="font-size: 0.85rem; font-weight: 700; margin-bottom: 12px;">Pilih Tanggal</div>
    <div class="date-selector-container">
        @foreach($dates as $date)
            <a href="{{ route('experts.detail', [$expert->id, 'date' => $date['full']]) }}" class="date-pill {{ $selectedDate === $date['full'] ? 'active' : '' }}" style="text-decoration: none; color: inherit;">
                <div class="date-pill-day">{{ strtoupper(substr($date['day_name'], 0, 3)) }}</div>
                <div class="date-pill-num">{{ $date['day_num'] }}</div>
            </a>
        @endforeach
    </div>

    {{-- Time Slots --}}
    <div style="font-size: 0.85rem; font-weight: 700; margin-bottom: 12px;">Pilih Jam</div>
    @if($slots->isEmpty())
        <div style="text-align: center; padding: 20px; color: var(--text-muted); font-size: 0.85rem;">
            <i class="fa-regular fa-calendar-xmark"></i> Tidak ada jadwal tersedia untuk tanggal ini.
        </div>
    @else
        <div class="time-slots-grid">
            @foreach($slots as $slot)
                <button type="button"
                    class="time-slot-btn {{ $slot->is_booked ? 'disabled' : '' }}"
                    {{ $slot->is_booked ? 'disabled' : '' }}
                    onclick="{{ !$slot->is_booked ? 'selectSlot(this, ' . $slot->id . ')' : '' }}"
                    id="slot-{{ $slot->id }}">
                    {{ $slot->time_slot }}
                </button>
            @endforeach
        </div>
    @endif

    {{-- Complaint Field --}}
    <div style="font-size: 0.85rem; font-weight: 700; margin-bottom: 8px; margin-top: 4px;">Keluhan Utama</div>
    <div class="form-group">
        <textarea name="complaint" class="form-textarea" rows="3" placeholder="Deskripsikan keluhan rambut Anda...">{{ old('complaint') }}</textarea>
    </div>

    <button type="submit" id="confirm-btn" class="btn btn-primary" style="margin-top: 8px;" onclick="return validateBooking()">
        <i class="fa-solid fa-calendar-check"></i> Konfirmasi Booking
    </button>
</form>
@endsection

@section('scripts')
<script>
    function selectType(type, element) {
        document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
        document.getElementById('type-input').value = type;
    }

    function selectSlot(element, slotId) {
        document.querySelectorAll('.time-slot-btn:not(.disabled)').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
        document.getElementById('selected-schedule-id').value = slotId;
    }

    function validateBooking() {
        const scheduleId = document.getElementById('selected-schedule-id').value;
        if (!scheduleId) {
            alert('Silakan pilih jam konsultasi terlebih dahulu!');
            return false;
        }
        return true;
    }
</script>
@endsection
