<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\HairExpert;
use App\Models\ExpertSchedule;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        User::create([
            'name' => 'Joko Damm',
            'email' => 'joko@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '08123456789',
            'address' => 'Jl. Mawar No. 12, Jakarta',
        ]);

        User::create([
            'name' => 'Admin PureStrands',
            'email' => 'admin@purestrands.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '08987654321',
            'address' => 'PureStrands HQ, Jakarta',
        ]);

        // 2. Seed Categories
        $catStylist = Category::create([
            'name' => 'Stylist',
            'slug' => 'stylist',
            'description' => 'Produk styling untuk tatanan rambut yang stylish dan sehat',
            'image' => 'category_stylist.png'
        ]);

        $catPerawatan = Category::create([
            'name' => 'Perawatan',
            'slug' => 'perawatan',
            'description' => 'Shampoo, conditioner, serum dan vitamin rambut berkualitas tinggi',
            'image' => 'category_perawatan.png'
        ]);

        $catCatRambut = Category::create([
            'name' => 'Cat Rambut',
            'slug' => 'cat-rambut',
            'description' => 'Pewarna rambut aman, bernutrisi tinggi dan minim iritasi',
            'image' => 'category_cat_rambut.png'
        ]);

        // 3. Seed Products
        Product::create([
            'category_id' => $catCatRambut->id,
            'name' => 'Velvet Black Dye',
            'slug' => 'velvet-black-dye',
            'description' => 'Rich, long-lasting dye with a healthy shine finish. Specially formulated for scalp sensitivity and hair cortex integrity. Vegan formula and 20 Min Process.',
            'price' => 95000,
            'stock' => 15,
            'image' => 'product_velvet_black.png',
            'rating' => 4.9,
            'shades' => ['#1F1F1F', '#2A2533', '#4A3B32', '#A66A4E'],
        ]);

        Product::create([
            'category_id' => $catPerawatan->id,
            'name' => 'Forest Silk',
            'slug' => 'forest-silk',
            'description' => 'Memperkuat akar rambut dengan nutrisi alami dari daun mint dan rosemary.',
            'price' => 85000,
            'stock' => 20,
            'image' => 'product_forest_silk.png',
            'rating' => 4.8,
            'shades' => null,
        ]);

        Product::create([
            'category_id' => $catPerawatan->id,
            'name' => 'Botanical Tonic',
            'slug' => 'botanical-tonic',
            'description' => 'Nutrisi harian rambut untuk merangsang pertumbuhan baru dan mencegah kerontokan.',
            'price' => 120000,
            'stock' => 10,
            'image' => 'product_botanical_tonic.png',
            'rating' => 4.7,
            'shades' => null,
        ]);

        Product::create([
            'category_id' => $catPerawatan->id,
            'name' => 'Deep Hydration Balm',
            'slug' => 'deep-hydration-balm',
            'description' => 'Untuk rambut sangat kering, memberikan kelembapan intensif sepanjang hari.',
            'price' => 50000,
            'stock' => 30,
            'image' => 'product_deep_hydration.png',
            'rating' => 4.6,
            'shades' => null,
        ]);

        Product::create([
            'category_id' => $catPerawatan->id,
            'name' => 'Scalp Balance Pro',
            'slug' => 'scalp-balance-pro',
            'description' => 'Kontrol minyak berlebih dan atasi ketombe basah atau kering.',
            'price' => 145000,
            'stock' => 8,
            'image' => 'product_scalp_balance.png',
            'rating' => 4.9,
            'shades' => null,
        ]);

        Product::create([
            'category_id' => $catStylist->id,
            'name' => 'Sculpting Edge Gel',
            'slug' => 'sculpting-edge-gel',
            'description' => 'Ketahanan 24 jam untuk gaya rambut sleek dan rapi.',
            'price' => 65000,
            'stock' => 25,
            'image' => 'product_sculpting_gel.png',
            'rating' => 4.8,
            'shades' => null,
        ]);

        Product::create([
            'category_id' => $catPerawatan->id,
            'name' => 'Pure Argan Elixir',
            'slug' => 'pure-argan-elixir',
            'description' => 'Kilau alami tanpa lepek untuk perlindungan dari panas catokan.',
            'price' => 175000,
            'stock' => 5,
            'image' => 'product_argan.png',
            'rating' => 4.9,
            'shades' => null,
        ]);

        Product::create([
            'category_id' => $catPerawatan->id,
            'name' => 'Keratin Infusion',
            'slug' => 'keratin-infusion',
            'description' => 'Perbaikan instan batang rambut bercabang akibat bahan kimia.',
            'price' => 110000,
            'stock' => 12,
            'image' => 'product_keratin.png',
            'rating' => 4.7,
            'shades' => null,
        ]);

        Product::create([
            'category_id' => $catPerawatan->id,
            'name' => 'Verde Botanica Clarifying',
            'slug' => 'verde-botanica-clarifying',
            'description' => 'Clarifying shampoo infused with tea tree oil and organic mint for deep scalp detox and long-lasting freshness.',
            'price' => 245000,
            'stock' => 14,
            'image' => 'product_clarifying.png',
            'rating' => 4.9,
            'shades' => null,
        ]);

        Product::create([
            'category_id' => $catPerawatan->id,
            'name' => 'Volume Lift Shampoo',
            'slug' => 'volume-lift-shampoo',
            'description' => 'Memberikan volume ekstra untuk rambut tipis dan lepek.',
            'price' => 190000,
            'stock' => 16,
            'image' => 'product_volume_shampoo.png',
            'rating' => 4.8,
            'shades' => null,
        ]);

        Product::create([
            'category_id' => $catPerawatan->id,
            'name' => 'Scalp Purifier Pro',
            'slug' => 'scalp-purifier-pro',
            'description' => 'Deep cleanser for damaged and chemically treated hair.',
            'price' => 150000,
            'stock' => 11,
            'image' => 'product_scalp_purifier.png',
            'rating' => 4.7,
            'shades' => null,
        ]);

        Product::create([
            'category_id' => $catPerawatan->id,
            'name' => 'Intensive Keratin Repair',
            'slug' => 'intensive-keratin-repair',
            'description' => 'For damaged and chemically treated hair, restoring vital protein structure.',
            'price' => 200000,
            'stock' => 9,
            'image' => 'product_keratin_repair.png',
            'rating' => 4.9,
            'shades' => null,
        ]);

        // 4. Seed Hair Experts
        $experts = [
            [
                'name' => 'Dr. Jake Damm',
                'photo' => 'expert_jake.png',
                'specialty' => 'Dermatologi',
                'rating' => 4.9,
                'price' => 50000,
                'experience' => '8 thn pengalaman',
                'profile' => 'Dermatologi & Kesehatan Rambut',
                'description' => 'Spesialis Kesehatan Kulit dan Rambut lulusan Universitas Indonesia. Berpengalaman menangani kerontokan parah dan iritasi kulit kepala akibat bahan kimia keras.'
            ],
            [
                'name' => 'Dr. Rusdi',
                'photo' => 'expert_rusdi.png',
                'specialty' => 'Dermatologi',
                'rating' => 4.8,
                'price' => 45000,
                'experience' => '5 thn pengalaman',
                'profile' => 'Dermatologi & Kesehatan Rambut',
                'description' => 'Ahli trikologi fokus pada masalah ketombe membandel, ketombe basah, serta alergi kulit kepala pasca pewarnaan rambut.'
            ],
            [
                'name' => 'Dr. Sarah Wijaya',
                'photo' => 'expert_sarah.png',
                'specialty' => 'Dermatologi',
                'rating' => 4.9,
                'price' => 60000,
                'experience' => '10 thn pengalaman',
                'profile' => 'Trichologist Specialist',
                'description' => 'Dermatologist senior dengan sertifikasi internasional dalam regenerasi folikel rambut dan stimulasi pertumbuhan rambut alami.'
            ],
            [
                'name' => 'Dr. Anita Sari',
                'photo' => 'expert_anita.png',
                'specialty' => 'Dermatologi',
                'rating' => 4.7,
                'price' => 40000,
                'experience' => '6 thn pengalaman',
                'profile' => 'Trichologist Specialist',
                'description' => 'Fokus pada perawatan restoratif pasca-kerusakan kimiawi akibat styling berlebih (smoothing/bleaching).'
            ],
            [
                'name' => 'Dr. Budi Santoso',
                'photo' => 'expert_budi.png',
                'specialty' => 'Dermatologi',
                'rating' => 4.9,
                'price' => 55000,
                'experience' => '12 thn pengalaman',
                'profile' => 'Dermatologi & Kesehatan Rambut',
                'description' => 'Konsultan senior untuk kebotakan genetik (alopecia) dan inflamasi kulit kepala akut.'
            ],
            [
                'name' => 'Dr. Citra Dewi',
                'photo' => 'expert_citra.png',
                'specialty' => 'Hair Stylist',
                'rating' => 4.8,
                'price' => 35000,
                'experience' => '7 thn pengalaman',
                'profile' => 'Hair Stylist & Scalp Expert',
                'description' => 'Hair stylist profesional bersertifikat, ahli dalam rekomendasi gaya rambut sehat pasca-treatment kimiawi.'
            ]
        ];

        $timeSlots = ['09:00', '10:00', '11:00', '13:00', '14:00', '16:00'];
        
        foreach ($experts as $expertData) {
            $expert = HairExpert::create($expertData);
            
            // Seed schedules for the next 5 days
            for ($i = 1; $i <= 5; $i++) {
                $date = Carbon::now()->addDays($i)->format('Y-m-d');
                
                foreach ($timeSlots as $slot) {
                    ExpertSchedule::create([
                        'hair_expert_id' => $expert->id,
                        'date' => $date,
                        'time_slot' => $slot,
                        'is_booked' => false
                    ]);
                }
            }
        }
    }
}
