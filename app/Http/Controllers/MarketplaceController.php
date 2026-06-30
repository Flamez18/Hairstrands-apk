<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        
        // Search filter
        if ($request->has('q') && !empty($request->q)) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category') && !empty($request->category)) {
            $categorySlug = $request->category;
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $products = $query->get();
        $categories = Category::all();
        $activeCategory = $request->category ?? '';
        $searchQuery = $request->q ?? '';

        return view('marketplace.index', compact('products', 'categories', 'activeCategory', 'searchQuery'));
    }

    public function detail($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        
        // Let's pass standard highlights
        $highlights = [
            '20 Min Process',
            'Vegan Formula'
        ];

        return view('marketplace.detail', compact('product', 'highlights'));
    }
}
