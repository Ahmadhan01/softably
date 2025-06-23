<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/1531486bb6.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        /* The sidebar-active class is no longer strictly necessary if using Tailwind classes dynamically */
        /* .sidebar-active {
            background: #23293a;
            border-radius: 8px;
        } */

        .sidebar-icon {
            width: 22px;
            height: 22px;
        }

        .notif-badge {
            background: #19C94A;
            color: #fff;
            font-size: 12px;
            border-radius: 9999px;
            padding: 2px 8px;
            margin-left: 8px;
        }
    </style>
</head>

<body class="bg-[#23293a] min-h-screen flex">
    <div class="w-64 bg-[#23293a] flex flex-col justify-between border-r border-[#23293a] relative z-10">
        <div>
            <div class="p-6 border-b border-gray-700 flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                    <img src="img/icon-soft.png" alt="" class="rounded-full">
                </div>
                <span class="text-white font-semibold">Ini Logo Web</span>
            </div>
            <div class="p-4">
                <p class="text-gray-400 text-xs uppercase tracking-wider mb-4">MENU</p>
                <nav class="space-y-2">
                    <a href="/Dashboard-seller" id="dashboard-link"
                        class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                        <i class="fa-solid fa-store"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="/My-product-seller" id="my-product-link"
                        class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                        <i class="fas fa-file-alt text-gray-300"></i>
                        <span>My Product</span>
                    </a>
                    <a href="/Chat-seller" id="chat-link"
                        class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                        <i class="fa-solid fa-message"></i>
                        <span>Chat</span>
                    </a>
                    <a href="/Notification-seller" id="notification-link"
                        class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                        <i class="fa-solid fa-bell"></i>
                        <span>Notification</span>
                        <div
                            class="flex items-center w-3 h-3 bg-green-600 rounded-full right-5 justify-center py-3 px-4 ml-2">
                            <div class="flex">4</div>
                        </div>
                    </a>
                    <a href="/Help-Center-seller" id="help-center-link"
                        class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                        <i class="fa-solid fa-circle-question"></i>
                        <span>Help Center</span>
                    </a>
                </nav>
            </div>
        </div>
        <div class="w-full p-4 border-t border-gray-700">
            <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors cursor-pointer">
                <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center">
                    <img src="img/icon-soft.png" alt="" class="rounded-full">
                </div>
                <div class="flex-1">
                    <p class="text-white text-sm font-medium">Fuad Store</p>
                    <p class="text-gray-400 text-xs">Store settings</p>
                </div>
            </div>
            <div class="mt-8 space-y-2">
                <a href="/Settings-seller" id="settings-link"
                    class="flex items-center space-x-3 p-2 text-gray-300 hover:bg-gray-700 rounded-lg font-semibold">
                    <i class="fa-solid fa-gear"></i>
                    <span class="text-sm">Settings</span>
                </a>
                <a href="/Log-out-seller" id="logout-link" class="flex items-center space-x-3 p-2 text-gray-300 hover:bg-gray-700 transition-colors">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="text-sm">Log Out</span>
                </a>
            </div>
        </div>
    </div>

    <main class="flex-1 border-l border-gray-700 bg-[#23293a] px-12 py-10">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-white">Notification</h1>
            <a href="/Mark as read" class="text-gray-300 hover:underline text-sm">Mark as read</a>
        </div>
        <div class="flex flex-col gap-6">
            <div class="bg-[#2e3650] rounded-lg p-6 flex items-center gap-6 shadow-sm">
                <div class="w-20 h-16 bg-gray-500 rounded-md">
                    <img src="" alt="">
                </div>
                <div class="flex-1">
                    <div class="font-bold text-lg text-white mb-1">Transaction Successful</div>
                    <div class="text-gray-300 text-sm">Lorem ipsum dolor sit amet consectetur. Interdum quis urna orci
                        mollis lacus. Ac id id nullam interdum. Adipiscing ligula et gravida ipsum nunc at consequat
                        quis. Lorem risus sed in amet lorem lobortis habitant quam.</div>
                </div>
                <button
                    class="bg-[#23293a] border border-[#19C94A] text-[#19C94A] px-6 py-2 rounded-lg font-semibold hover:bg-[#19C94A] hover:text-white transition">Check
                    Details</button>
            </div>
            <div class="bg-[#2e3650] rounded-lg p-6 flex items-center gap-6 shadow-sm">
                <div class="w-20 h-16 bg-gray-500 rounded-md">
                    <img src="" alt="">
                </div>
                <div class="flex-1">
                    <div class="font-bold text-lg text-white mb-1">Transaction Successful</div>
                    <div class="text-gray-300 text-sm">Lorem ipsum dolor sit amet consectetur. Interdum quis urna orci
                        mollis lacus. Ac id id nullam interdum. Adipiscing ligula et gravida ipsum nunc at consequat
                        quis. Lorem risus sed in amet lorem lobortis habitant quam.</div>
                </div>
                <button
                    class="bg-[#23293a] border border-[#19C94A] text-[#19C94A] px-6 py-2 rounded-lg font-semibold hover:bg-[#19C94A] hover:text-white transition">Check
                    Details</button>
            </div>
            <div class="bg-[#2e3650] rounded-lg p-6 flex items-center gap-6 shadow-sm">
                <div class="w-20 h-16 bg-gray-500 rounded-md">
                    <img src="" alt="">
                </div>
                <div class="flex-1">
                    <div class="font-bold text-lg text-white mb-1">Transaction Successful</div>
                    <div class="text-gray-300 text-sm">Lorem ipsum dolor sit amet consectetur. Interdum quis urna orci
                        mollis lacus. Ac id id nullam interdum. Adipiscing ligula et gravida ipsum nunc at consequat
                        quis. Lorem risus sed in amet lorem lobortis habitant quam.</div>
                </div>
                <button
                    class="bg-[#23293a] border border-[#19C94A] text-[#19C94A] px-6 py-2 rounded-lg font-semibold hover:bg-[#19C94A] hover:text-white transition">Check
                    Details</button>
            </div>
            <div class="bg-[#2e3650] rounded-lg p-6 flex items-center gap-6 shadow-sm">
                <div class="w-20 h-16 bg-gray-500 rounded-md">
                    <img src="" alt="">
                </div>
                <div class="flex-1">
                    <div class="font-bold text-lg text-white mb-1">Transaction Successful</div>
                    <div class="text-gray-300 text-sm">Lorem ipsum dolor sit amet consectetur. Interdum quis urna orci
                        mollis lacus. Ac id id nullam interdum. Adipiscing ligula et gravida ipsum nunc at consequat
                        quis. Lorem risus sed in amet lorem lobortis habitant quam.</div>
                </div>
                <button
                    class="bg-[#23293a] border border-[#19C94A] text-[#19C94A] px-6 py-2 rounded-lg font-semibold hover:bg-[#19C94A] hover:text-white transition">Check
                    Details</button>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const currentPath = window.location.pathname;
            const sidebarLinks = document.querySelectorAll('nav a');

            sidebarLinks.forEach(link => {
                // Remove existing active classes first to ensure only one is active
                link.classList.remove('bg-gray-700', 'text-white', 'font-semibold');
                link.classList.add('text-gray-300'); // Ensure default color is gray-300

                // Check if the link's href matches the current path
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('bg-gray-700', 'text-white', 'font-semibold');
                    link.classList.remove('text-gray-300'); // Remove default color if active
                }
            });
        });
    </script>
</body>

</html>