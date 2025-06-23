<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Softably</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative text-white font-sans">
    <!-- Background image -->
    <div class="absolute inset-0 bg-[url('img/digiproduct.jpg')] bg-cover bg-center z-0"></div>

    <!-- Dark overlay -->
    <div class="absolute inset-0 bg-black opacity-60 z-10"></div>

    <!-- Main content -->
    <div class="relative z-20">
        <!-- Header -->
        <header class="flex justify-between items-center px-8 py-6">
            <div class="text-lg font-bold">
                <img src="img/softably-baru.png" alt="" width="120" />
            </div>
            <div class="space-x-4">
                <a href="{{ route('register') }}"
                    class="bg-white text-black px-4 py-1 rounded-full text-sm font-semibold">
                    Daftar
                </a>
                <a href="{{ route('login') }}" class="border border-white px-4 py-1 rounded-full text-sm font-semibold">
                    Masuk
                </a>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="text-center px-4 py-16 max-w-2xl mx-auto">
            <p class="text-sm mb-2">Selamat datang di Softably</p>
            <h1 class="text-3xl sm:text-4xl font-extrabold leading-tight mb-4">
                Temukan produk digital<br />yang kamu mau disini
            </h1>
            <p class="text-sm text-gray-200">
                Lorem ipsum dolor sit amet consectetur. Eget nisi in fermentum amet
                aenean orci. Tristique at elit malesuada ut. Adipiscing laoreet sed
                mus magna viverra ut vulputate.
            </p>
        </section>

        <!-- Role Selection -->
        <section class="text-center px-4 py-12">
            <h2 class="text-2xl font-semibold mb-2">Mau jadi apa nih ?</h2>
            <p class="max-w-md mx-auto text-sm text-gray-200">
                Lorem ipsum dolor sit amet consectetur. Sollicitudin ornare in diam
                faucibus. Ut tellus nullam convallis non lectus sit tellus id quam.
            </p>

            <div class="flex flex-col md:flex-row justify-center items-center gap-8 mt-10 px-4">
                <!-- Seller Card -->
                <!-- Seller Card -->
                <div class="bg-[#222831] p-6 rounded-xl max-w-sm w-full">
                    <div class="relative h-48 rounded mb-4 overflow-hidden">
                        <img src="img/seller.jpg" alt="" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-white">Seller</h3>
                    <p class="text-sm text-gray-200 mb-4">
                        Lorem ipsum dolor sit amet consectetur. Sollicitudin ornare in
                        diam faucibus. Ut tellus nullam convallis non lectus sit tellus id
                        quam.
                    </p>
                </div>

                <!-- Customer Card -->
                <div class="bg-[#222831] p-6 rounded-xl max-w-sm w-full">
                    <div class="relative h-48 rounded mb-4 overflow-hidden">
                        <img src="img/customer.jpeg" alt="" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-white">Customer</h3>
                    <p class="text-sm text-gray-200 mb-4">
                        Lorem ipsum dolor sit amet consectetur. Sollicitudin ornare in
                        diam faucibus. Ut tellus nullam convallis non lectus sit tellus id
                        quam.
                    </p>
                </div>

            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-[#222831] text-white text-sm px-8 py-10">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-5 gap-8">
                <div>
                    <h4 class="font-bold mb-2">Softably</h4>
                    <p class="mb-4 text-gray-300 text-sm">
                        Lorem ipsum dolor sit amet consectetur adipiscing elit aliquam
                        mauris sed ma
                    </p>
                    <div class="flex space-x-3">
                        <a href="#"><img src="https://img.icons8.com/ios-filled/20/ffffff/facebook-new.png" /></a>
                        <a href="#"><img src="https://img.icons8.com/ios-filled/20/ffffff/twitter.png" /></a>
                        <a href="#"><img
                                src="https://img.icons8.com/ios-filled/20/ffffff/instagram-new.png" /></a>
                        <a href="#"><img src="https://img.icons8.com/ios-filled/20/ffffff/linkedin.png" /></a>
                        <a href="#"><img src="https://img.icons8.com/ios-filled/20/ffffff/youtube-play.png" /></a>
                    </div>
                </div>

                <div>
                    <h5 class="font-semibold mb-2">About us</h5>
                    <ul class="space-y-1 text-gray-300">
                        <li>Mission</li>
                        <li>Our team</li>
                        <li>Awards</li>
                        <li>Testimonials</li>
                        <li>Privacy policy</li>
                    </ul>
                </div>

                <div>
                    <h5 class="font-semibold mb-2">Services</h5>
                    <ul class="space-y-1 text-gray-300">
                        <li>Web design</li>
                        <li>Web development</li>
                        <li>Mobile design</li>
                        <li>UI/UX design</li>
                        <li>Branding design</li>
                    </ul>
                </div>

                <div>
                    <h5 class="font-semibold mb-2">Contact us</h5>
                    <ul class="space-y-1 text-gray-300">
                        <li>Information</li>
                        <li>Request a quote</li>
                        <li>Consultation</li>
                        <li>Help center</li>
                        <li>Terms and conditions</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-600 mt-10 pt-4 text-center text-gray-400">
                Copyright © 2025 Softably | All Rights Reserved |
                <a href="#" class="underline">Terms and Conditions</a> |
                <a href="#" class="underline">Privacy Policy</a>
            </div>
        </footer>
    </div>
</body>

</html>
