<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/1531486bb6.js" crossorigin="anonymous"></script>
    <script>
        // Tailwind CSS configuration for consistent dark theme colors
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Brand/Application specific colors
                        'primary-bg': '#0f172a', // Overall background
                        'sidebar-bg': '#1e293b', // Sidebar background
                        'card-bg': '#1e293b',    // Card/section background
                        'border-dark': '#334155', // Darker border
                        'text-light': '#f8fafc', // White text
                        'text-dark-gray': '#94a3b8', // Gray text
                        'accent-green': '#22c55e', // Green for notifications, etc.
                        'accent-blue': '#3b82f6',  // Blue for actions
                        'accent-yellow': '#facc15', // Yellow for highlights
                        // Adjusted from previous contexts for consistency
                        'gray-700': '#4a5568',
                        'gray-600': '#718096',
                        'gray-400': '#cbd5e0',
                        'green-500': '#22c55e',
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar for better appearance in dark theme if needed */
        .scrollbar-thin::-webkit-scrollbar {
            width: 8px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #1e293b; /* sidebar-bg */
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: #334155; /* border-dark */
            border-radius: 20px;
            border: 2px solid #1e293b; /* sidebar-bg */
        }
    </style>
</head>
<body class="bg-primary-bg text-text-light font-sans flex">
    <aside class="w-64 bg-sidebar-bg flex flex-col justify-between fixed top-0 left-0 h-full z-20">
        <div>
            <div class="flex justify-center p-4 text-xl font-bold border-b border-gray-700">
                <img src="img/logo-softably.png" alt="Softably Logo" class="max-h-10">
            </div>
            <nav class="p-4 space-y-2 text-sm text-text-dark-gray">
                <a href="/produk-customer" id="produk-link" class="nav-link flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded transition-colors duration-200">
                    <i class="fa-solid fa-box w-5"></i><span>Produk</span>
                </a>
                <a href="/cart-customer" id="cart-link" class="nav-link flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded transition-colors duration-200">
                    <i class="fa-solid fa-cart-shopping w-5"></i><span>Keranjang</span>
                </a>
                <a href="/order-customer" id="orders-link" class="nav-link flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded transition-colors duration-200">
                    <i class="fa-solid fa-list-ul w-5"></i><span>Pesanan Saya</span>
                </a>
                <a href="/notification-customer" id="notification-link" class="nav-link flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded transition-colors duration-200">
                    <i class="fa-solid fa-bell w-5"></i><span>Notifikasi</span>
                    <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">4</span>
                </a>
                <a href="/chat-customer" id="chat-link" class="nav-link flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded transition-colors duration-200">
                    <i class="fa-solid fa-comments w-5"></i><span>Chat</span>
                    <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">10</span>
                </a>
                <a href="/bantuan-customer" id="help-center-link" class="nav-link flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded transition-colors duration-200">
                    <i class="fa-solid fa-circle-question w-5"></i><span>Pusat Bantuan</span>
                </a>
            </nav>
        </div>
        <div class="p-4 space-y-2 border-t border-gray-700">
            <a href="/setting-customer" class="nav-link group">
                <div class="flex items-center space-x-3 p-2 rounded transition-colors duration-200 group-hover:bg-white/10">
                    <div class="w-10 h-10 rounded-full overflow-hidden">
                        <img src="img/man.jpg" alt="User Avatar" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <div class="font-medium text-text-light">Fuad Pharaoh</div>
                        <div class="text-sm text-gray-400">Pengaturan Akun</div>
                    </div>
                </div>
            </a>
            <a href="/setting-customer" id="settings-link" class="nav-link flex items-center space-x-2 text-gray-400 hover:text-white px-3 py-2 rounded transition-colors duration-200">
                <i class="fa-solid fa-gear w-5"></i><span>Pengaturan</span>
            </a>
            <a href="login.html" id="logout-link" class="nav-link flex items-center space-x-2 text-gray-400 hover:text-white px-3 py-2 rounded transition-colors duration-200">
                <i class="fa-sharp fa-solid fa-right-from-bracket w-5"></i> <span>Keluar</span>
            </a>
        </div>
    </aside>

    <div class="flex-1 ml-64"> 
        @yield('isi')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const currentPath = window.location.pathname.replace(/\/$/, '').replace(/\.html$/, ''); // Clean path
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                const linkHref = link.getAttribute('href').replace(/\/$/, '').replace(/\.html$/, '');

                // Reset all links to default state
                link.classList.remove('bg-white/10', 'text-text-light', 'font-semibold');
                link.classList.add('text-text-dark-gray');

                // For the user profile link, only apply active style if it's the specific setting page
                if (link.closest('.group') && linkHref === '/setting-customer') {
                    if (currentPath === linkHref) {
                         link.classList.add('bg-white/10', 'text-text-light');
                    }
                    return; // Skip further processing for this specific link
                }

                // Check for direct match
                if (currentPath === linkHref) {
                    link.classList.add('bg-white/10', 'text-text-light', 'font-semibold');
                    link.classList.remove('text-text-dark-gray');
                }
                // Handle nested routes, e.g., /produk-customer/detail -> /produk-customer
                else if (currentPath.startsWith(linkHref) && linkHref !== '/') {
                    // Special handling for "Product" link to highlight it for its sub-pages
                    if (linkHref === '/produk-customer' && currentPath.includes('/produk-customer')) {
                         link.classList.add('bg-white/10', 'text-text-light', 'font-semibold');
                         link.classList.remove('text-text-dark-gray');
                    }
                    // Add similar conditions for other parent links with nested pages if needed
                }
            });
        });
    </script>
</body>
</html>