<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\HairExpert;
use App\Models\ExpertSchedule;
use App\Models\ConsultationBooking;
use App\Models\Order;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'categories' => Category::count(),
            'products' => Product::count(),
            'experts' => HairExpert::count(),
            'bookings' => ConsultationBooking::count(),
            'orders' => Order::count(),
            'total_sales' => Order::where('status', 'paid')->sum('total_price'),
        ];

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $recentBookings = ConsultationBooking::with(['user', 'expert', 'schedule'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentBookings'));
    }

    // --- CATEGORY CRUD ---
    public function categoriesIndex()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function categoriesCreate()
    {
        return view('admin.categories.create');
    }

    public function categoriesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $request->image ?? 'category_default.png',
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dibuat!');
    }

    public function categoriesEdit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function categoriesUpdate($id, Request $request)
    {
        $category = Category::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image' => $request->image ?? $category->image,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function categoriesDestroy($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }

    // --- PRODUCT CRUD ---
    public function productsIndex()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    public function productsCreate()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function productsStore(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string',
            'rating' => 'nullable|numeric|between:1,5',
            'shades' => 'nullable|string', // Comma separated list of hex colors
        ]);

        $shadesArray = null;
        if (!empty($request->shades)) {
            $shadesArray = array_map('trim', explode(',', $request->shades));
        }

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $request->image ?? 'product_default.png',
            'rating' => $request->rating ?? 5.0,
            'shades' => $shadesArray,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dibuat!');
    }

    public function productsEdit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $shadesString = $product->shades ? implode(', ', $product->shades) : '';

        return view('admin.products.edit', compact('product', 'categories', 'shadesString'));
    }

    public function productsUpdate($id, Request $request)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string',
            'rating' => 'nullable|numeric|between:1,5',
            'shades' => 'nullable|string',
        ]);

        $shadesArray = null;
        if (!empty($request->shades)) {
            $shadesArray = array_map('trim', explode(',', $request->shades));
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $request->image ?? $product->image,
            'rating' => $request->rating ?? $product->rating,
            'shades' => $shadesArray,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function productsDestroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }

    // --- HAIR EXPERT CRUD ---
    public function expertsIndex()
    {
        $experts = HairExpert::all();
        return view('admin.experts.index', compact('experts'));
    }

    public function expertsCreate()
    {
        return view('admin.experts.create');
    }

    public function expertsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string',
            'rating' => 'required|numeric|between:1,5',
            'price' => 'required|integer|min:0',
            'experience' => 'required|string',
            'profile' => 'nullable|string',
            'description' => 'nullable|string',
            'photo' => 'nullable|string',
        ]);

        HairExpert::create([
            'name' => $request->name,
            'specialty' => $request->specialty,
            'rating' => $request->rating,
            'price' => $request->price,
            'experience' => $request->experience,
            'profile' => $request->profile,
            'description' => $request->description,
            'photo' => $request->photo ?? 'expert_default.png',
        ]);

        return redirect()->route('admin.experts.index')->with('success', 'Dokter Ahli berhasil dibuat!');
    }

    public function expertsEdit($id)
    {
        $expert = HairExpert::findOrFail($id);
        return view('admin.experts.edit', compact('expert'));
    }

    public function expertsUpdate($id, Request $request)
    {
        $expert = HairExpert::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string',
            'rating' => 'required|numeric|between:1,5',
            'price' => 'required|integer|min:0',
            'experience' => 'required|string',
            'profile' => 'nullable|string',
            'description' => 'nullable|string',
            'photo' => 'nullable|string',
        ]);

        $expert->update([
            'name' => $request->name,
            'specialty' => $request->specialty,
            'rating' => $request->rating,
            'price' => $request->price,
            'experience' => $request->experience,
            'profile' => $request->profile,
            'description' => $request->description,
            'photo' => $request->photo ?? $expert->photo,
        ]);

        return redirect()->route('admin.experts.index')->with('success', 'Dokter Ahli berhasil diperbarui!');
    }

    public function expertsDestroy($id)
    {
        HairExpert::findOrFail($id)->delete();
        return redirect()->route('admin.experts.index')->with('success', 'Dokter Ahli berhasil dihapus!');
    }

    // --- SCHEDULE CRUD ---
    public function schedulesIndex()
    {
        $schedules = ExpertSchedule::with('expert')->orderBy('date', 'asc')->get();
        return view('admin.schedules.index', compact('schedules'));
    }

    public function schedulesCreate()
    {
        $experts = HairExpert::all();
        $timeSlots = ['09:00', '10:00', '11:00', '13:00', '14:00', '16:00'];
        return view('admin.schedules.create', compact('experts', 'timeSlots'));
    }

    public function schedulesStore(Request $request)
    {
        $request->validate([
            'hair_expert_id' => 'required|exists:hair_experts,id',
            'date' => 'required|date|after_or_equal:today',
            'time_slots' => 'required|array',
            'time_slots.*' => 'string',
        ]);

        foreach ($request->time_slots as $slot) {
            // Check if already exists
            $exists = ExpertSchedule::where('hair_expert_id', $request->hair_expert_id)
                                    ->where('date', $request->date)
                                    ->where('time_slot', $slot)
                                    ->exists();
            if (!$exists) {
                ExpertSchedule::create([
                    'hair_expert_id' => $request->hair_expert_id,
                    'date' => $request->date,
                    'time_slot' => $slot,
                    'is_booked' => false,
                ]);
            }
        }

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal dokter berhasil dibuat!');
    }

    public function schedulesDestroy($id)
    {
        ExpertSchedule::findOrFail($id)->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal dokter berhasil dihapus!');
    }

    // --- BOOKING MANAGEMENT ---
    public function bookingsIndex()
    {
        $bookings = ConsultationBooking::with(['user', 'expert', 'schedule'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateBookingStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required|string|in:pending,completed,cancelled',
        ]);

        $booking = ConsultationBooking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        // Release schedule if cancelled
        if ($request->status === 'cancelled') {
            $schedule = ExpertSchedule::find($booking->expert_schedule_id);
            if ($schedule) {
                $schedule->is_booked = false;
                $schedule->save();
            }
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Status booking berhasil diperbarui!');
    }
}
