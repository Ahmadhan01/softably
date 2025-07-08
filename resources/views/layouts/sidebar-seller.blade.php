<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Softably - Seller Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    /* CSS untuk Sidebar */
    .sidebar-link {
        display: flex;
        align-items: center;
        /* Mengisi lebar penuh kontainer */
        width: 100%; /* Pastikan link mengisi lebar penuh */
        text-align: left; /* Teks rata kiri */
        gap: 0.5rem;
        padding: 0.5rem 0.75rem; /* Padding sudah cukup */
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
        /* Mengisi lebar penuh kontainer */
        width: 100%; /* Pastikan link mengisi lebar penuh */
        text-align: left; /* Teks rata kiri */
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
        display: block; /* Pastikan link adalah block untuk mengisi lebar */
        width: 100%; /* Memastikan link mengisi lebar container */
        padding: 0.5rem 0.75rem; /* Tambahkan padding di sini agar sama dengan link lain */
        border-radius: 0.25rem;
    }

    .user-profile-link:hover {
        transform: scale(1.02);
        background-color: rgba(255, 255, 255, 0.1); /* Tambahkan hover background */
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

    /* --- Gaya Scrollbar yang Diperbarui --- */
    /* Untuk WebKit (Chrome, Safari, Edge, Opera) */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #1a202c; /* Biru tua, sedikit lebih gelap dari background */
        border-radius: 10px;
        border: 2px solid #0f172a; /* Border yang menyatu dengan background utama */
    }

    ::-webkit-scrollbar-thumb:hover {
        background-color: #2d3748; /* Sedikit lebih terang saat hover */
    }

    ::-webkit-scrollbar-track {
        background-color: #0f172a; /* Warna background utama */
        border-radius: 10px;
    }

    body {
        background-color: #0f172a;
        color: white;
        font-family: sa
        ns-serif;
    }
    </style>
</head>

<body class="bg-[#0f172a] text-white font-sans">
    <div class="flex h-screen">
        <aside class="w-64 bg-[#1e293b] flex flex-col justify-between flex-shrink-0">
            <div>
                <div class="flex justify-center p-4 text-xl font-bold border-b border-gray-700">
                    <img src="{{ asset('img/logo-softably.png') }}" alt="Softably Logo" class="softably-logo">
                </div>
                {{-- Padding di nav sudah cukup, pastikan linknya mengisi width 100% --}}
                <nav class="p-4 space-y-2 text-sm">

                    {{-- Dashboard --}}
                    <a href="{{ route('seller.dashboard') }}" class="sidebar-link" data-path="/seller/dashboard">
                        <i class="fa-solid fa-house-chimney"></i><span>Dashboard</span>
                    </a>

                    {{-- My Product --}}
                    <a href="{{ route('seller.products.index') }}" class="sidebar-link" data-path="/seller/products">
                        <i class="fa-solid fa-box"></i><span>My Product</span>
                    </a>

                    {{-- Chat --}}
                    <a href="{{ route('seller.chat') }}" class="sidebar-link" data-path="/seller/chat">
                        <i class="fa-solid fa-comments"></i><span>Chat</span>
                        <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">10</span>
                    </a>

                    {{-- Notification untuk Seller --}}
                    <a href="{{ route('seller.notif-seller') }}" class="sidebar-link" data-path="/seller/notifications">
                        <i class="fa-solid fa-bell"></i><span>Notification</span>
                    </a>

                    {{-- SoftPay --}}
                    <a href="{{ route('seller.softpay.dashboard') }}" class="sidebar-link" data-path="/seller/softpay">
                        <i class="fas fa-wallet"></i><span>SoftPay</span>
                    </a>

                    {{-- Help Center --}}
                    <a href="{{ route('seller.bantuan-seller') }}" class="sidebar-link" data-path="/seller/help">
                        <i class="fa-solid fa-circle-question"></i><span>Help Center</span>
                    </a>
                </nav>
            </div>
            <div class="p-4 space-y-2">
                {{-- Hapus padding di div ini dan pindahkan ke user-profile-link --}}
                <div class="py-2 border-t border-gray-700"> {{-- Kurangi padding vertikal --}}
                    {{-- Profil Pengguna di Sidebar --}}
                    <a href="{{ route('seller.settings') }}" class="user-profile-link" data-path="/seller/settings">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden">
                                @php
                                $loggedInUser = Auth::user();
                                @endphp
                                <img src="{{ $loggedInUser->profile_picture_url ?? asset('img/man.jpg') }}"
                                    alt="Profile" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <div class="font-medium">{{ $loggedInUser->name ?? 'Guest' }}</div>
                                <div class="text-sm text-gray-400">Account settings</div>
                            </div>
                        </div>
                    </a>
                </div>
                {{-- Link Settings utama (di bagian footer sidebar) --}}
                <a href="{{ route('seller.settings') }}" class="sidebar-footer-link" data-path="/seller/settings">
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

        <main class="flex-1 overflow-y-auto p-5">
            @yield('isi')
        </main>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const sidebarLinks = document.querySelectorAll(
            '.sidebar-link, .user-profile-link, .sidebar-footer-link');

        sidebarLinks.forEach(link => {
            const linkPath = link.dataset.path;

            link.classList.remove('active');

            if (linkPath && currentPath.startsWith(linkPath)) {
                if (linkPath === '/seller/settings') {
                    link.classList.add('active');
                } else if (linkPath !== '/logout') {
                    link.classList.add('active');
                }
            }
        });
    });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    @stack('scripts')
</body>

</html>