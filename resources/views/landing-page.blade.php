<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Softably</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Warna-warna dasar dari gambar */
        :root {
            --color-blue-dark: #000a2d;
            --color-blue-light: #0d47a1;
            --color-text-light: #f3f4f6;
            --color-text-dark: #1f2937;
        }

        /* Hero Section */
        .hero-background {
            background-color: var(--color-blue-light);
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .hero-background::after {
            content: '';
            background-image: url('img/laptop.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: bottom right;
            position: absolute;
            bottom: 0;
            right: 0;
            width: 70%;
            height: 100%;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 10;
            padding-right: 5rem;
        }

        /* Bagian gelap di bawah Hero Section */
        .dark-section {
            background-color: var(--color-blue-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Section for features (now adjusted to fit multiple features) */
        .features-section {
            background-color: white;
            padding-top: 8rem;
            /* Add some top padding for separation */
            padding-bottom: 8rem;
            /* Add some bottom padding for separation */
            display: flex;
            flex-direction: column;
            /* Stack features vertically */
            align-items: center;
            justify-content: center;
            gap: 6rem;
            /* Space between each feature block */
        }

        /* For placeholder produk */
        .product-placeholder {
            background-color: #e5e7eb;
            border-radius: 0.5rem;
            /* rounded-md */
        }

        /* Gaya dasar untuk setiap kartu produk */
        .product-card {
            background-color: #e0f2fe;
            border: 2px solid #90caf9;
            border-radius: 1rem;
            position: absolute;
            /* Penting untuk positioning */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            /* Transisi untuk animasi halus */
            transition: transform 0.8s ease-in-out, opacity 0.8s ease-in-out, width 0.8s ease-in-out, height 0.8s ease-in-out, z-index 0s 0.4s;
            /* Z-index berubah setelah setengah transisi */
        }

        /* Definisikan posisi untuk setiap kartu - DIUBAH KE PERSEGI */
        .product-position-1 {
            /* Tengah, paling depan */
            width: 250px;
            height: 250px; /* Diubah dari 300px ke 250px */
            z-index: 30;
            opacity: 1;
            transform: translateX(0) rotate(0deg) scale(1);
        }

        @media (min-width: 768px) {
            /* md breakpoint */
            .product-position-1 {
                width: 300px;
                height: 300px; /* Diubah dari 350px ke 300px */
            }
        }


        .product-position-2 {
            /* Kanan belakang */
            width: 200px;
            height: 200px; /* Diubah dari 250px ke 200px */
            z-index: 20;
            opacity: 0.7;
            transform: translateX(60%) rotate(5deg) scale(0.9);
        }

        @media (min-width: 768px) {
            /* md breakpoint */
            .product-position-2 {
                width: 250px;
                height: 250px; /* Diubah dari 300px ke 250px */
                transform: translateX(80%) rotate(5deg) scale(0.9);
            }
        }


        .product-position-3 {
            /* Kiri belakang */
            width: 200px;
            height: 200px; /* Diubah dari 250px ke 200px */
            z-index: 10;
            opacity: 0.7;
            transform: translateX(-60%) rotate(-5deg) scale(0.9);
        }

        @media (min-width: 768px) {
            /* md breakpoint */
            .product-position-3 {
                width: 250px;
                height: 250px; /* Diubah dari 300px ke 250px */
                transform: translateX(-80%) rotate(-5deg) scale(0.9);
            }
        }

        /* Teks Nama Produk dan Terjual di bawah kartu */
        .product-info-bottom {
            text-align: center;
            position: absolute;
            bottom: 1rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 40;
            width: max-content;
        }

        /* Social icons filter (dihapus karena diganti ikon hitam) */
    </style>
</head>

<body class="font-sans text-gray-800">
    <header class="bg-white py-4 px-8 flex justify-between items-center shadow-sm fixed top-0 left-0 w-full z-50">
        <div>
            <img src="img/logo-softably.png" alt="Softably Logo" class="h-8" />
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium">Masuk</a>
            <a href="{{ route('register') }}"
                class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-300 font-medium">
                Daftar
            </a>
        </div>
    </header>

    <section class="hero-background text-white px-8 lg:px-16 pt-24 pb-8 md:pt-0 md:pb-0">
        <div class="hero-content max-w-2xl text-center md:text-left mx-auto md:ml-0">
            <p class="text-sm opacity-80 mb-2">Selamat datang di Softably</p>
            <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight mb-6">
                Temukan produk digital<br />yang kamu mau disini
            </h1>
            <p class="text-base lg:text-lg opacity-90 mb-8">
                Lorem ipsum dolor sit amet consectetur. Eget nisi in fermentum amet
                aenean orci. Tristique at elit malesuada ut. Adipiscing laoreet sed
                mus magna viverra ut vulputate.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                <a href="#"
                    class="bg-white text-blue-600 px-6 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100 transition-colors duration-300 shadow-lg">
                    Saya Ingin Jadi Penjual
                </a>
                <a href="#"
                    class="border-2 border-white text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors duration-300">
                    Saya Ingin Jadi Pembeli
                </a>
            </div>
        </div>
    </section>

    <section class="features-section px-8 lg:px-16">
        <div class="flex flex-col md:flex-row items-center justify-center gap-12 max-w-7xl w-full">
            <div class="flex-shrink-0 relative w-80 h-80 flex items-center justify-center"> <img
                    src="img/prialaptop.png" alt="Person with Laptop" class="w-full h-full object-contain">
            </div>
            <div class="max-w-xl text-center md:text-left">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-6">
                    Mudah diakses oleh siapapun
                </h2>
                <p class="text-gray-600 text-lg">
                    Lorem ipsum dolor sit amet consectetur. Sollicitudin ornare in diam
                    faucibus. Ut tellus nullam convallis non lectus sit tellus id quam.
                    Nunc vel velit lacus, non felis amet non. Sed pulvinar id at nisl.
                </p>
            </div>
        </div>

        <div class="flex flex-col md:flex-row-reverse items-center justify-center gap-12 max-w-7xl w-full">
            <div class="flex-shrink-0 relative w-80 h-80 flex items-center justify-center"> <img src="img/board.png"
                    alt="Dynamic Display" class="w-full h-full object-contain">
            </div>
            <div class="max-w-xl text-center md:text-right">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-6">
                    Tampilan yang dinamis
                </h2>
                <p class="text-gray-600 text-lg">
                    Lorem ipsum dolor sit amet consectetur. Sollicitudin ornare in diam
                    faucibus. Ut tellus nullam convallis non lectus sit tellus id quam.
                </p>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-center gap-12 max-w-7xl w-full">
            <div class="flex-shrink-0 relative w-80 h-80 flex items-center justify-center"> <img
                    src="img/kategori.png" alt="Many Categories" class="w-full h-full object-contain">
            </div>
            <div class="max-w-xl text-center md:text-left">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-6">
                    Banyak pilihan kategori
                </h2>
                <p class="text-gray-600 text-lg">
                    Lorem ipsum dolor sit amet consectetur. Sollicitudin ornare in diam
                    faucibus. Ut tellus nullam convallis non lectus sit tellus id quam.
                </p>
            </div>
        </div>
    </section>
    <section class="dark-section text-white px-8 lg:px-16 flex flex-col md:flex-row items-center justify-center gap-20">
        <div class="max-w-xl text-center md:text-left mb-12 md:mb-0 relative z-10 w-full md:w-1/2">
            <h2 class="text-3xl lg:text-4xl font-bold mb-6">
                Produk Terlaris Minggu Ini
            </h2>
            <p class="text-gray-300 text-lg">
                Lorem ipsum dolor sit amet consectetur. Lorem ipsum dolor sit amet consectetur
                adipiscing elit aliquam mauris sed ma
            </p>
        </div>

        <div class="relative w-full md:w-1/2 flex justify-center items-center h-[400px] md:h-[500px]">
            {{-- Kartu Produk Dinamis --}}
            @foreach($bestSellingProducts as $product)
                <div id="product-card-{{ $loop->iteration }}" class="product-card">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-3/4 h-3/4 object-cover rounded-md">
                </div>
            @endforeach

            <div id="product-info" class="product-info-bottom text-white z-40">
                {{-- Info akan diisi oleh JavaScript --}}
                <h3 class="text-xl font-semibold"></h3>
                <p class="text-gray-300 text-sm"></p>
            </div>
        </div>
    </section>

    <footer class="bg-white text-gray-800 text-sm px-8 py-10 min-h-fit flex flex-col justify-end">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-5 gap-8">
            <div>
                <div class="flex items-center space-x-2 mb-2">
                    <img src="img/logo-softably.png" alt="Softably Logo" class="h-8" />
                </div>
                <p class="mb-4 text-gray-600 text-sm">
                    Lorem ipsum dolor sit amet consectetur adipiscing elit aliquam
                    mauris sed ma
                </p>
                <div class="flex space-x-3">
                    <a href="#"><img src="https://img.icons8.com/ios-filled/20/000000/facebook-new.png"
                                alt="Facebook" /></a>
                    <a href="#"><img src="https://img.icons8.com/ios-filled/20/000000/twitter.png"
                                alt="Twitter" /></a>
                    <a href="#"><img src="https://img.icons8.com/ios-filled/20/000000/instagram-new.png"
                                alt="Instagram" /></a>
                    <a href="#"><img src="https://img.icons8.com/ios-filled/20/000000/linkedin.png"
                                alt="LinkedIn" /></a>
                    <a href="#"><img src="https://img.icons8.com/ios-filled/20/000000/youtube-play.png"
                                alt="YouTube" /></a>
                </div>
            </div>

            <div>
                <h5 class="font-semibold mb-2 text-gray-800">About us</h5>
                <ul class="space-y-1 text-gray-600">
                    <li>Mission</li>
                    <li>Our team</li>
                    <li>Awards</li>
                    <li>Testimonials</li>
                    <li>Privacy policy</li>
                </ul>
            </div>

            <div>
                <h5 class="font-semibold mb-2 text-gray-800">Services</h5>
                <ul class="space-y-1 text-gray-600">
                    <li>Web design</li>
                    <li>Web development</li>
                    <li>Mobile design</li>
                    <li>UI/UX design</li>
                    <li>Branding design</li>
                </ul>
            </div>

            <div>
                <h5 class="font-semibold mb-2 text-gray-800">Contact us</h5>
                <ul class="space-y-1 text-gray-600">
                    <li>Information</li>
                    <li>Request a quote</li>
                    <li>Consultation</li>
                    <li>Help center</li>
                    <li>Terms and conditions</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-300 mt-10 pt-4 text-center text-gray-500">
            Copyright © 2025 Softably | All Rights Reserved |
            <a href="#" class="underline">Terms and Conditions</a> |
            <a href="#" class="underline">Privacy Policy</a>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data produk dari Laravel
            const productsData = @json($bestSellingProducts->map(function($product) {
                return [
                    'name' => $product->name,
                    'sold' => $product->sales_count . ' Terjual', // Format sesuai kebutuhan
                    'image_url' => $product->image_url // Pastikan accessor ini ada di Product model
                ];
            }));

            // Jika tidak ada produk, keluar dari fungsi atau tampilkan pesan
            if (productsData.length === 0) {
                console.warn("No best selling products found to display.");
                // Opsional: sembunyikan bagian carousel atau tampilkan pesan default
                document.querySelector('.product-info-bottom').style.display = 'none';
                return;
            }

            // Inisialisasi kartu produk
            const productCards = [
                document.getElementById('product-card-1'),
                document.getElementById('product-card-2'),
                document.getElementById('product-card-3')
            ];
            const productInfo = document.getElementById('product-info');

            // Set posisi awal untuk setiap kartu produk
            productCards[0].classList.add('product-position-1');
            productCards[1].classList.add('product-position-2');
            productCards[2].classList.add('product-position-3');


            let currentIndex = 0; // Index dari produk di `productsData` yang saat ini berada di `product-position-1`

            function updateProductDisplay() {
                // Update product info text based on the product currently in `product-position-1`
                productInfo.querySelector('h3').textContent = productsData[currentIndex].name;
                productInfo.querySelector('p').textContent = productsData[currentIndex].sold;

                // Update gambar produk
                productCards[0].querySelector('img').src = productsData[currentIndex].image_url;
                productCards[1].querySelector('img').src = productsData[(currentIndex + 1) % productsData.length].image_url;
                productCards[2].querySelector('img').src = productsData[(currentIndex + 2) % productsData.length].image_url;

            }

            function rotateCards() {
                // Hapus semua kelas posisi dari semua kartu
                productCards.forEach(card => {
                    card.classList.remove('product-position-1', 'product-position-2', 'product-position-3');
                });

                // Tentukan urutan baru untuk kartu fisik
                // Kartu di posisi 1 (index 0) pindah ke posisi 3 (index 2)
                // Kartu di posisi 2 (index 1) pindah ke posisi 1 (index 0)
                // Kartu di posisi 3 (index 2) pindah ke posisi 2 (index 1)
                const newOrder = [productCards[1], productCards[2], productCards[0]];

                // Terapkan kelas posisi baru
                newOrder[0].classList.add('product-position-1');
                newOrder[1].classList.add('product-position-2');
                newOrder[2].classList.add('product-position-3');

                // Update referensi productCards agar sesuai dengan urutan fisik baru
                productCards[0] = newOrder[0];
                productCards[1] = newOrder[1];
                productCards[2] = newOrder[2];

                // Update index produk data
                currentIndex = (currentIndex + 1) % productsData.length;

                // Update tampilan produk (nama, terjual, gambar)
                updateProductDisplay();
            }

            // Initial display update
            updateProductDisplay();

            // Rotate cards every 3 seconds (adjust as needed)
            setInterval(rotateCards, 3000);
        });
    </script>
</body>

</html>