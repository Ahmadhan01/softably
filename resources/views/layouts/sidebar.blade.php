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

    /* --- STYLE UNTUK TOAST NOTIFICATIONS (DIPINDAHKAN KE SINI) --- */
    .toast-container {
        position: fixed;
        bottom: 1rem;
        right: 1rem;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-end;
    }

    .toast {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        border-radius: 0.375rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        color: white;
        transform: translateX(100%);
        transition: transform 0.3s ease-out;
    }

    .toast.show {
        transform: translateX(0);
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
                    <a href="{{ route('customer.produk') }}" class="sidebar-link" data-path="/customer/produks">
                        <i class="fa-solid fa-box"></i><span>Product</span>
                    </a>
                    <a href="{{ route('cart-customer.index') }}" class="sidebar-link" data-path="/cart-customer">
                        <i class="fa-solid fa-cart-shopping"></i><span>Cart</span>
                    </a>
                    <a href="{{ route('order-customer') }}" class="sidebar-link" data-path="/order-customer">
                        <i class="fa-solid fa-list-ul"></i><span>My Orders</span>
                    </a>
                    <a href="{{ route('notif-customer') }}" class="sidebar-link" data-path="/notif-customer">
                        <i class="fa-solid fa-bell"></i><span>Notification</span>
                        {{-- Tampilkan badge hanya jika ada notifikasi belum dibaca --}}
                        @if ($unreadNotificationsCount > 0)
                            <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $unreadNotificationsCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('chat-customer') }}" class="sidebar-link" data-path="/chat-customer">
                        <i class="fa-solid fa-comments"></i><span>Chat</span>
                        <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">10</span>
                    </a>
                    <a href="{{ route('softpay-customer') }}" class="sidebar-link" data-path="/softpay">
                        <i class="fa-solid fa-wallet"></i><span>SoftPay</span>
                    </a>
                    <a href="{{ route('bantuan-customer') }}" class="sidebar-link" data-path="/bantuan-customer">
                        <i class="fa-solid fa-circle-question"></i><span>Help Center</span>
                    </a>
                </nav>
            </div>
            <div class="p-4 space-y-2">
                <div class="p-4 py-5 border-t border-gray-700">
                    <a href="{{ route('setting-customer') }}" class="user-profile-link" data-path="/setting-customer">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden">
                                {{-- Gunakan Auth::user() untuk gambar profil --}}
                                @php
                                $imagePath = Auth::user()->profile_picture
                                ? url('storage/profile/' . Auth::user()->profile_picture)
                                : asset('img/man.jpg');
                                @endphp
                                <img src="{{ Auth::user()->profile_picture_url }}" alt="User Profile" class="w-full h-full object-cover">
                            </div>
                            <div>
                                {{-- Gunakan Auth::user() untuk nama pengguna --}}
                                <div class="font-medium">{{ Auth::user()->name ?? 'Guest' }}</div>
                                <div class="text-sm text-gray-400">Account settings</div>
                            </div>
                        </div>
                    </a>
                </div>
                <a href="{{ route('setting-customer') }}" class="sidebar-footer-link" data-path="/setting-customer">
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
            @yield('isi')
        </div>
    </div>

    {{-- INI ADALAH BAGIAN KRUSIAL YANG MEMUNGKINKAN SCRIPT DARI CHILD VIEWS DIMUAT --}}
    {{-- PASTIKAN @stack('scripts') ADA DI SINI, SEBELUM TAG PENUTUP </body> --}}
    @stack('scripts')

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const sidebarLinks = document.querySelectorAll(
            '.sidebar-link, .user-profile-link, .sidebar-footer-link');

        sidebarLinks.forEach(link => {
            const linkPath = link.dataset.path;

            let isActive = false;
            // Periksa kecocokan persis atau awalan
            if (currentPath === linkPath) {
                isActive = true;
            } else if (linkPath !== '/' && currentPath.startsWith(linkPath)) {
                isActive = true;
            } else if (linkPath === '/' && currentPath ===
                '/') { // Khusus untuk root path
                isActive = true;
            }

            if (isActive) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }

            // Logout link tidak perlu active state
            if (link.dataset.path === '/logout') {
                link.classList.remove('active');
            }
        });
    });
    </script>
</body>

</html>