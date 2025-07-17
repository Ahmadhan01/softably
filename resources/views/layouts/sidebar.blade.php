<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Softably</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>
        /* CSS untuk Sidebar */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            color: white;
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out, transform 0.2s ease-in-out;
            transform: scale(1);
            text-decoration: none;
        }
        .sidebar-link i.fa-solid {
            color: white;
            transition: color 0.2s ease-in-out, transform 0.2s ease-in-out;
        }
        .sidebar-link:hover {
            background-color: white;
            color: #2563EB;
            transform: scale(1.02);
        }
        .sidebar-link:hover i.fa-solid {
            color: #2563EB;
            transform: scale(1.05);
        }
        .sidebar-link.active {
            background-color: #ffffff;
            color: #2563EB;
            transform: scale(1.02);
            font-weight: 600;
        }
        .sidebar-link.active i.fa-solid {
            color: #2563EB;
            transform: scale(1.05);
        }

        .sidebar-footer-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            color: white;
            transition: color 0.2s ease-in-out, transform 0.2s ease-in-out;
            transform: scale(1);
            text-decoration: none;
        }
        .sidebar-footer-link i.fa-solid {
            color: white;
            transition: color 0.2s ease-in-out, transform 0.2s ease-in-out;
        }
        .sidebar-footer-link:hover {
            background-color: white;
            color: #2563EB;
            transform: scale(1.02);
        }
        .sidebar-footer-link:hover i.fa-solid {
            color: #2563EB;
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
            color: #2563EB;
        }
        .user-profile-link:hover .text-gray-400 {
            color: #2563EB;
        }

        .softably-logo {
            width: 50%;
            height: auto;
        }

        /* PERUBAHAN KRITIS DI SINI: */
        html, body { /* Pastikan html dan body mengambil tinggi penuh */
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden; /* Sembunyikan scrollbar default dari body */
        }
        body {
            /* Hapus background-color dari body di sini agar tidak mempengaruhi halaman lain */
            color: #333333;
            font-family: "Poppins", sans-serif;
            display: flex; /* Jadikan body flex container */
            /* Hapus min-height: 100vh; karena sudah ada height: 100% di html, body */
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
        .toast.success { background-color: #22C55E; }
        .toast.error { background-color: #EF4444; }
        .toast.show { transform: translateX(0); }

        /* --- Gaya Scrollbar yang Diperbarui --- */
        /* Scrollbar untuk elemen yang overflow-y-auto */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb {
            background-color: #60A5FA;
            border-radius: 10px;
            border: 2px solid #F8FAFC;
        }
        ::-webkit-scrollbar-thumb:hover { background-color: #3B82F6; }
        ::-webkit-scrollbar-track { background-color: #F8FAFC; }
    </style>
</head>

<body>
    {{-- Aside harus fixed dan full height --}}
    <aside class="w-64 flex-shrink-0 flex flex-col justify-between fixed top-0 left-0 h-full "
           style="background: linear-gradient(to top, #2D3A4F, #2563EB);">
        <div class="flex flex-col flex-1">
            <div class="flex justify-center p-4 text-xl font-bold flex-shrink-0">
                <img src="{{ asset('img/softably-baru.png') }}" alt="Softably Logo" class="softably-logo">
            </div>
            <nav class="p-4 space-y-2 text-sm overflow-y-auto flex-1">
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
                    @if ($unreadNotificationsCount > 0)
                        <span class="ml-auto bg-[#ff483bff] text-white text-xs px-2 py-0.5 rounded-full">{{ $unreadNotificationsCount }}</span>
                    @endif
                </a>
                <a href="{{ route('chat-customer') }}" class="sidebar-link" data-path="/chat-customer">
                    <i class="fa-solid fa-comments"></i><span>Chat</span>
                    <span id="chat-unread-badge" class="ml-auto bg-[#2563EB] text-white text-xs px-2 py-0.5 rounded-full hidden"></span>
                </a>
                <a href="{{ route('softpay-customer') }}" class="sidebar-link" data-path="/softpay">
                    <i class="fa-solid fa-wallet"></i><span>SoftPay</span>
                </a>
                <a href="{{ route('bantuan-customer') }}" class="sidebar-link" data-path="/bantuan-customer">
                    <i class="fa-solid fa-circle-question"></i><span>Help Center</span>
                </a>
            </nav>
        </div>
        <div class="p-4 space-y-2 flex-shrink-0">
            <div class="p-4 py-5">
                <a href="{{ route('setting-customer') }}" class="user-profile-link" data-path="/setting-customer">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full overflow-hidden">
                            @php
                            $imagePath = Auth::user()->profile_picture
                            ? url('storage/profile/' . Auth::user()->profile_picture)
                            : asset('img/man.jpg');
                            @endphp
                            <img src="{{ Auth::user()->profile_picture_url }}" alt="User Profile" class="w-full h-full object-cover">
                        </div>
                        <div>
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

    {{-- Kontainer untuk konten utama halaman --}}
    <div class="flex-1 overflow-y-auto"> @yield('isi')
    </div>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const sidebarLinks = document.querySelectorAll(
                '.sidebar-link, .user-profile-link, .sidebar-footer-link');

            sidebarLinks.forEach(link => {
                const linkPath = link.dataset.path;

                let isActive = false;
                if (currentPath === linkPath) {
                    isActive = true;
                } else if (linkPath !== '/' && currentPath.startsWith(linkPath)) {
                    isActive = true;
                } else if (linkPath === '/' && currentPath === '/') {
                    isActive = true;
                }

                if (isActive) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
                if (link.dataset.path === '/logout') {
                    link.classList.remove('active');
                }
            });

            const chatUnreadBadge = document.getElementById('chat-unread-badge');
            function updateChatUnreadCount() {
                fetch('{{ route('api.chat.unreadCount') }}', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.count > 0) {
                        chatUnreadBadge.textContent = data.count;
                        chatUnreadBadge.classList.remove('hidden');
                    } else {
                        chatUnreadBadge.classList.add('hidden');
                    }
                })
                .catch(error => { console.error('Error fetching unread chat count:', error); });
            }
            updateChatUnreadCount();
            setInterval(updateChatUnreadCount, 5000);
        });

        window.updateChatBadge = function() {
            const chatUnreadBadge = document.getElementById('chat-unread-badge');
            fetch('{{ route('api.chat.unreadCount') }}', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.count > 0) {
                    chatUnreadBadge.textContent = data.count;
                    chatUnreadBadge.classList.remove('hidden');
                } else {
                    chatUnreadBadge.classList.add('hidden');
                }
            })
            .catch(error => { console.error('Error fetching unread chat count:', error); });
        }
    </script>
</body>

</html>