<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Fetch a couple of products as recommendations for the home screen
        $recommendations = Product::take(2)->get();
        
        // Mock video guides for the UI
        $videos = [
            [
                'title' => 'Prompt Scan Rambut',
                'thumbnail' => 'video1.png',
                'desc' => 'Teknologi rambut sehat Lewat AI'
            ],
            [
                'title' => 'Cara menggunakan Aplikasi',
                'thumbnail' => 'video2.png',
                'desc' => 'Tutorial Lengkap & Mudah'
            ]
        ];

        return view('home', compact('user', 'recommendations', 'videos'));
    }
}
