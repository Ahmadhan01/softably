<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product; // Import model Product

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productsData = [
            [
                'name' => 'Novel Hujan',
                'description' => 'Sebuah novel fiksi ilmiah romantis karya Tere Liye tentang kisah cinta di tengah hujan.',
                'price' => 75000.00,
                'image_path' => 'https://placehold.co/300x400/FF0000/FFFFFF/png?text=Novel+Hujan' // Placeholder
            ],
            [
                'name' => 'Buku Resep Masakan Nusantara',
                'description' => 'Kumpulan resep masakan tradisional Indonesia dari berbagai daerah.',
                'price' => 120000.00,
                'image_path' => 'https://placehold.co/300x400/00FF00/000000/png?text=Buku+Resep' // Placeholder
            ],
            [
                'name' => 'E-Book Panduan Investasi',
                'description' => 'Panduan lengkap untuk pemula di dunia investasi saham dan reksadana.',
                'price' => 45000.00,
                'image_path' => 'https://placehold.co/300x400/0000FF/FFFFFF/png?text=E-Book+Investasi' // Placeholder
            ],
            [
                'name' => 'Template Presentasi Powerpoint Modern',
                'description' => 'Kumpulan template profesional untuk presentasi bisnis dan pendidikan.',
                'price' => 85000.00,
                'image_path' => 'https://placehold.co/300x400/FFFF00/000000/png?text=Template+PPT' // Placeholder
            ],
            [
                'name' => 'Course Desain Grafis Pemula',
                'description' => 'Video tutorial interaktif untuk mempelajari dasar-dasar desain grafis.',
                'price' => 250000.00,
                'image_path' => 'https://placehold.co/300x400/FF00FF/000000/png?text=Course+Design' // Placeholder
            ],
            [
                'name' => 'Audiobook Self-Improvement',
                'description' => 'Koleksi audiobook untuk pengembangan diri dan motivasi.',
                'price' => 60000.00,
                'image_path' => 'https://placehold.co/300x400/00FFFF/000000/png?text=Audiobook+Self-Improvement' // Placeholder
            ],
            [
                'name' => 'Vector Icon Pack Premium',
                'description' => 'Paket ikon vektor berkualitas tinggi untuk web dan aplikasi.',
                'price' => 90000.00,
                'image_path' => 'https://placehold.co/300x400/800000/FFFFFF/png?text=Vector+Icons' // Placeholder
            ],
            [
                'name' => 'Software Video Editing Portable',
                'description' => 'Aplikasi editing video ringan yang bisa dijalankan tanpa instalasi.',
                'price' => 180000.00,
                'image_path' => 'https://placehold.co/300x400/808000/FFFFFF/png?text=Video+Software' // Placeholder
            ],
            [
                'name' => 'Template Website HTML/CSS',
                'description' => 'Template siap pakai untuk membuat website personal atau bisnis kecil.',
                'price' => 110000.00,
                'image_path' => 'https://placehold.co/300x400/008000/FFFFFF/png?text=Web+Template' // Placeholder
            ],
            [
                'name' => 'Preset Lightroom Pack',
                'description' => 'Koleksi preset untuk editing foto profesional di Adobe Lightroom.',
                'price' => 50000.00,
                'image_path' => 'https://placehold.co/300x400/000080/FFFFFF/png?text=Lightroom+Preset' // Placeholder
            ],
            [
                'name' => 'Asset Game 2D Fantasy',
                'description' => 'Kumpulan aset grafis untuk pengembangan game 2D bergenre fantasi.',
                'price' => 200000.00,
                'image_path' => 'https://placehold.co/300x400/800080/FFFFFF/png?text=Game+Assets' // Placeholder
            ],
            [
                'name' => 'Modul Belajar Coding Python',
                'description' => 'Modul interaktif untuk belajar pemrograman Python dari dasar hingga mahir.',
                'price' => 150000.00,
                'image_path' => 'https://placehold.co/300x400/808080/FFFFFF/png?text=Python+Module' // Placeholder
            ],
            [
                'name' => 'Font Pack Kreatif',
                'description' => 'Koleksi font unik dan kreatif untuk proyek desain Anda.',
                'price' => 30000.00,
                'image_path' => 'https://placehold.co/300x400/C0C0C0/000000/png?text=Creative+Fonts' // Placeholder
            ],
            [
                'name' => 'Mockup Desain Produk 3D',
                'description' => 'Mockup 3D realistis untuk presentasi desain produk Anda.',
                'price' => 70000.00,
                'image_path' => 'https://placehold.co/300x400/E0E0E0/000000/png?text=3D+Mockup' // Placeholder
            ],
            [
                'name' => 'Kumpulan Sound Effect Cinematic',
                'description' => 'Efek suara berkualitas tinggi untuk produksi video dan film.',
                'price' => 100000.00,
                'image_path' => 'https://placehold.co/300x400/A0A0A0/000000/png?text=Sound+Effects' // Placeholder
            ],
        ];

        foreach ($productsData as $data) {
            Product::create($data);
        }
    }
}