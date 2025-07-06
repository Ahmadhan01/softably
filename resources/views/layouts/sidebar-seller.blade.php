<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Softably</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    /* CSS untuk Sidebar */
    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.75rem;
        border-radius: 0.25rem;
        color: #9ca3af;
        transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out, transform 0.2s ease-in-out;
        transform: scale(1);
        text-decoration: none;
    }

    .sidebar-link i.fa-solid {
        color: #9ca3af;
        transition: color 0.2s ease-in-out, transform 0.2s ease-in-out;
    }

    .sidebar-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        transform: scale(1.02);
    }

    .sidebar-link:hover i.fa-solid {
        color: white;
        transform: scale(1.05);
    }

    .sidebar-link.active {
        background-color: #2D3A4F;
        /* Ganti dengan warna background aktif yang sesuai, contoh: #3b82f6 atau #1f2a3c */
        color: white;
        transform: scale(1.02);
        font-weight: 600;
    }

    .sidebar-link.active i.fa-solid {
        color: white;
        transform: scale(1.05);
    }


    .sidebar-footer-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.75rem;
        border-radius: 0.25rem;
        color: #9ca3af;
        transition: color 0.2s ease-in-out, transform 0.2s ease-in-out;
        transform: scale(1);
        text-decoration: none;
    }

    .sidebar-footer-link i.fa-solid {
        color: #9ca3af;
        transition: color 0.2s ease-in-out, transform 0.2s ease-in-out;
    }

    .sidebar-footer-link:hover {
        color: white;
        transform: scale(1.02);
    }

    .sidebar-footer-link:hover i.fa-solid {
        color: white;
        transform: scale(1.05);
    }

    .user-profile-link {
        color: white;
        text-decoration: none;
        transition: transform 0.2s ease-in-out;
    }

    .user-profile-link:hover {
        transform: scale(1.02);
    }

    .user-profile-link:hover .font-medium {
        color: white;
    }

    .user-profile-link:hover .text-gray-400 {
        color: #d1d5db;
    }

    .softably-logo {
        width: 50%;
        height: auto;
    }

    body {
        background-color: #0f172a;
        color: white;
        font-family: sans-serif;
    }
    </style>
</head>

<body class="bg-[#0f172a] text-white font-sans">
    <div class="">

        <aside class="w-64 bg-[#1e293b] flex flex-col justify-between fixed top-0 left-0 h-full">
            <div>
                <div class="flex justify-center p-4 text-xl font-bold border-b border-gray-700">
                    <img src="{{ asset('img/logo-softably.png') }}" alt="Softably Logo" class="softably-logo">
                </div>
                <nav class="p-4 space-y-2 text-sm">

                    {{-- Dashboard --}}
                    <a href="{{ route('seller.dashboard') }}" class="sidebar-link" data-path="/seller/dashboard">
                        <i class="fa-solid fa-house-chimney"></i><span>Dashboard</span>
                    </a>

                    {{-- My Product (Asumsi ada rute untuk produk seller, jika belum ada perlu ditambahkan di web.php) --}}
                    <a href="{{ route('seller.products.index') }}" class="sidebar-link" data-path="/seller/products">
                        <i class="fa-solid fa-box"></i><span>My Product</span>
                    </a>

                    {{-- Chat --}}
                    <a href="{{ route('chat.seller') }}" class="sidebar-link" data-path="/chat-seller">
                        <i class="fa-solid fa-comments"></i><span>Chat</span>
                        <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">10</span>
                        {{-- Ganti dengan jumlah notifikasi dinamis --}}
                    </a>

                    {{-- Notifikasi untuk Seller --}}
                    <a href="{{ route('notif-seller') }}" class="sidebar-link" data-path="/notif-seller">
                        <i class="fa-solid fa-bell"></i><span>Notification</span>
                        {{-- Anda bisa menambahkan badge notifikasi dinamis di sini --}}
                    </a>

                    <a href="{{ route('seller.softpay.dashboard') }}" class="sidebar-link" data-path="/softpay-seller">
                        <i class="fas fa-wallet"></i><span>SoftPay</span>    
                        {{-- Anda bisa menambahkan badge notifikasi dinamis di sini --}}
                    </a>

                    {{-- Help Center --}}
                    <a href="{{ route('bantuan-seller') }}" class="sidebar-link" data-path="/bantuan-seller">
                        <i class="fa-solid fa-circle-question"></i><span>Help Center</span>
                    </a>
                </nav>
            </div>
            <div class="p-4 space-y-2">
                <div class="p-4 py-5 border-t border-gray-700">
                    <a href="{{ route('setting-customer') }}" class="user-profile-link" data-path="/setting-customer">
                        {{-- Asumsi seller juga menggunakan rute setting-customer --}}
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden">
                                {{-- Gunakan $loggedInUser untuk gambar profil --}}
                                {{-- Pastikan $loggedInUser didefinisikan di controller yang memuat layout ini atau di setiap controller yang menggunakan sidebar --}}
                                @php
                                $loggedInUser = Auth::user();
                                @endphp
                                <img src="{{ $loggedInUser->profile_picture_url ?? asset('img/man.jpg') }}"
                                    alt="Profile" class="w-full h-full object-cover">
                            </div>
                            <div>
                                {{-- Gunakan $loggedInUser untuk nama pengguna --}}
                                <div class="font-medium">{{ $loggedInUser->name ?? 'Guest' }}</div>
                                <div class="text-sm text-gray-400">Account settings</div>
                            </div>
                        </div>
                    </a>
                </div>
                <a href="{{ route('setting-customer') }}" class="sidebar-footer-link" data-path="/setting-customer">
                    {{-- Asumsi seller juga menggunakan rute setting-customer --}}
                    <i class="fa-solid fa-gear"></i><span>Settings</span>
                </a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="sidebar-footer-link" data-path="/logout">
                    <i class="fa-sharp fa-solid fa-right-from-bracket"></i> <span>Log Out</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>
        <div>
            @yield('isi') {{-- Ini adalah tempat child view (chat-customer.blade.php) akan dimasukkan --}}
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const sidebarLinks = document.querySelectorAll(
            '.sidebar-link, .user-profile-link, .sidebar-footer-link');

        sidebarLinks.forEach(link => {
            const linkPath = link.dataset.path;

            // Logika untuk menandai sidebar link sebagai 'active'
            // Hapus 'active' dari semua link terlebih dahulu untuk menghindari duplikasi
            link.classList.remove('active');

            // Periksa apakah path saat ini cocok dengan data-path link
            if (linkPath && currentPath.startsWith(linkPath)) {
                // Kecualikan /logout agar tidak pernah aktif
                if (linkPath !== '/logout') {
                    link.classList.add('active');
                }
            }
        });

        // Khusus untuk 'Notification' dan 'Help Center',
        // Jika Anda memiliki sub-halaman di dalamnya yang tidak mengubah URL utama
        // (misal dengan JavaScript seperti tab), maka logika di atas sudah cukup.
        // Jika ada kasus khusus di mana path tidak langsung cocok
        // tetapi Anda ingin sidebar tetap aktif, Anda bisa menambahkan logika tambahan di sini.
        // Contoh: jika Anda ingin /notif-seller/detail/123 tetap mengaktifkan /notif-seller
        // maka currentPath.startsWith(linkPath) sudah menanganinya.
    });
    </script>
    @stack('scripts') {{-- Pastikan ini ada untuk menyertakan script dari child view --}}
</body>

</html>