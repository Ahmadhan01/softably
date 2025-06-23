<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; // Pastikan ini diimpor

class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productsData = [
            ['name' => 'Novel Hujan', 'description' => 'Sebuah novel fiksi ilmiah romantis karya Tere Liye tentang kisah cinta di tengah hujan.', 'category' => 'Digital Content', 'price' => 75000.00, 'image_path' => 'https://via.placeholder.com/400x400/FF0000/FFFFFF?text=Novel+Hujan'],
            ['name' => 'Buku Resep Masakan Nusantara', 'description' => 'Kumpulan resep masakan tradisional Indonesia dari berbagai daerah.', 'category' => 'Digital Content', 'price' => 120000.00, 'image_path' => 'https://via.placeholder.com/400x400/00FF00/000000?text=Buku+Resep'],
            ['name' => 'E-Book Panduan Investasi', 'description' => 'Panduan lengkap untuk pemula di dunia investasi saham dan reksadana.', 'category' => 'Digital Content', 'price' => 45000.00, 'image_path' => 'https://via.placeholder.com/400x400/0000FF/FFFFFF?text=E-Book+Investasi'],
            ['name' => 'Template Presentasi Powerpoint Modern', 'description' => 'Kumpulan template profesional untuk presentasi bisnis dan pendidikan.', 'category' => 'Digital Assets', 'price' => 85000.00, 'image_path' => 'https://via.placeholder.com/400x400/FFFF00/000000?text=Template+PPT'],
            ['name' => 'Course Desain Grafis Pemula', 'description' => 'Video tutorial interaktif untuk mempelajari dasar-dasar desain grafis.', 'category' => 'Online Courses', 'price' => 250000.00, 'image_path' => 'https://via.placeholder.com/400x400/FF00FF/FFFFFF?text=Course+Desain'],
            ['name' => 'Audiobook Self-Improvement', 'description' => 'Koleksi audiobook untuk pengembangan diri dan motivasi.', 'category' => 'Digital Content', 'price' => 60000.00, 'image_path' => 'https://via.placeholder.com/400x400/00FFFF/000000?text=Audiobook'],
            ['name' => 'Vector Icon Pack Premium', 'description' => 'Paket ikon vektor berkualitas tinggi untuk web dan aplikasi.', 'category' => 'Digital Assets', 'price' => 90000.00, 'image_path' => 'https://via.placeholder.com/400x400/C0C0C0/000000?text=Icon+Pack'],
            ['name' => 'Software Video Editing Portable', 'description' => 'Aplikasi editing video ringan yang bisa dijalankan tanpa instalasi.', 'category' => 'Applications', 'price' => 180000.00, 'image_path' => 'https://via.placeholder.com/400x400/808000/FFFFFF?text=Video+Software'],
            ['name' => 'Template Website HTML/CSS', 'description' => 'Template siap pakai untuk membuat website personal atau bisnis kecil.', 'category' => 'Digital Assets', 'price' => 110000.00, 'image_path' => 'https://via.placeholder.com/400x400/008000/FFFFFF?text=Web+Template'],
            ['name' => 'Preset Lightroom Pack', 'description' => 'Koleksi preset untuk editing foto profesional di Adobe Lightroom.', 'category' => 'Digital Assets', 'price' => 50000.00, 'image_path' => 'https://via.placeholder.com/400x400/000080/FFFFFF?text=Lightroom+Preset'],
            ['name' => 'Asset Game 2D Fantasy', 'description' => 'Kumpulan aset grafis untuk pengembangan game 2D bergenre fantasi.', 'category' => 'Digital Assets', 'price' => 200000.00, 'image_path' => 'https://via.placeholder.com/400x400/800080/FFFFFF?text=Game+Assets'],
            ['name' => 'Modul Belajar Coding Python', 'description' => 'Modul interaktif untuk belajar pemrograman Python dari dasar hingga mahir.', 'category' => 'Online Courses', 'price' => 150000.00, 'image_path' => 'https://via.placeholder.com/400x400/808080/FFFFFF?text=Python+Module'],
            ['name' => 'Font Pack Kreatif', 'description' => 'Koleksi font unik dan kreatif untuk proyek desain Anda.', 'category' => 'Digital Assets', 'price' => 30000.00, 'image_path' => 'https://via.placeholder.com/400x400/A0A0A0/000000?text=Creative+Fonts'],
            ['name' => 'Mockup Desain Produk 3D', 'description' => 'Mockup 3D realistis untuk presentasi desain produk Anda.', 'category' => 'Digital Assets', 'price' => 70000.00, 'image_path' => 'https://via.placeholder.com/400x400/B0B0B0/000000?text=3D+Mockup'],
            ['name' => 'Kumpulan Sound Effect Cinematic', 'description' => 'Efek suara berkualitas tinggi untuk produksi video dan film.', 'category' => 'Digital Assets', 'price' => 100000.00, 'image_path' => 'https://via.placeholder.com/400x400/D0D0D0/000000?text=Sound+Effects'],
            ['name' => 'Aplikasi Manajemen Proyek', 'description' => 'Alat untuk mengelola proyek dan tim secara efisien.', 'category' => 'Applications', 'price' => 300000.00, 'image_path' => 'https://via.placeholder.com/400x400/E0E0E0/000000?text=Project+App'],
            ['name' => 'Kelas Online Pemasaran Digital', 'description' => 'Pelajari strategi pemasaran digital terbaru dari ahli.', 'category' => 'Online Courses', 'price' => 400000.00, 'image_path' => 'https://via.placeholder.com/400x400/F0F0F0/000000?text=Digital+Marketing'],
            ['name' => 'Plugin WordPress SEO', 'description' => 'Plugin untuk meningkatkan optimasi SEO website WordPress Anda.', 'category' => 'Applications', 'price' => 120000.00, 'image_path' => 'https://via.placeholder.com/400x400/101010/FFFFFF?text=WP+SEO+Plugin'],
            ['name' => 'Buku Audio Sejarah Dunia', 'description' => 'Dengarkan perjalanan sejarah dunia dalam format audio.', 'category' => 'Digital Content', 'price' => 95000.00, 'image_path' => 'https://via.placeholder.com/400x400/202020/FFFFFF?text=History+Audiobook'],
            ['name' => 'Software Akuntansi Cloud', 'description' => 'Solusi akuntansi berbasis cloud untuk bisnis kecil dan menengah.', 'category' => 'Applications', 'price' => 280000.00, 'image_path' => 'https://via.placeholder.com/400x400/303030/FFFFFF?text=Cloud+Accounting'],
        ];

        foreach ($productsData as $data) {
            Product::create($data);
        }
    }
}