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
                        <div id="unread-notification-badge"
                            class="flex items-center w-3 h-3 bg-green-600 rounded-full right-5 justify-center py-3 px-4 ml-2">
                            <div class="flex" id="unread-count"></div>
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
                <a href="/Log-out-seller" id="logout-link"
                    class="flex items-center space-x-3 p-2 text-gray-300 hover:bg-gray-700 transition-colors">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="text-sm">Log Out</span>
                </a>
            </div>
        </div>
    </div>

    <main class="flex-1 border-l border-gray-700 bg-[#23293a] px-12 py-10">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-white">Notification</h1>
            <button id="mark-as-read-button" class="text-gray-300 hover:underline text-sm cursor-pointer">Mark as read</button>
        </div>
        <div class="flex flex-col gap-6" id="notification-list">
            </div>
    </main>

    <script>
        // Konfigurasi TailwindCSS (sudah ada)
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-bg': '#2d3748',
                        'dark-card': '#2d3748',
                        'dark-hover': '#374151',
                        'gray-900': '#1a202c',
                        'gray-800': '#2d3748',
                        'gray-700': '#4a5568',
                        'gray-600': '#718096',
                        'gray-500': '#a0aec0',
                        'gray-400': '#cbd5e0',
                        'gray-300': '#e2e8f0',
                        'white': '#ffffff',
                        'green-600': '#38a169',
                        'blue-600': '#3b82f6',
                        'blue-700': '#2563eb',
                        'red-900': '#7f1d1d',
                        'blue-400': '#60a5fa',
                        'online-green': '#19C94A',
                        'dark-bg-card': '#2e3650' // Tambahkan jika belum ada di config Anda
                    }
                }
            }
        }

        // --- JavaScript untuk Interaktivitas Frontend (di dalam tag script ini) ---

        // Mock data notifikasi
        let notificationsData = [
            {
                id: 1,
                title: 'Transaction Successful',
                message_text: 'Selamat! Produk "Template Canva" Anda berhasil dibeli oleh Ahmad Temola. Periksa detail untuk informasi lebih lanjut.',
                image_url: 'https://via.placeholder.com/80x64/5000FF/FFFFFF?text=Canva',
                type: 'transaction_successful',
                reference_id: 'TRANS_12345',
                is_read: false,
                created_at: '2025-06-24T06:00:00Z' // ISO 8601 format
            },
            {
                id: 2,
                title: 'New Message Received',
                message_text: 'Anda memiliki pesan baru dari Budi Santoso mengenai produk "Custom Logo Design".',
                image_url: 'https://via.placeholder.com/80x64/FF5733/FFFFFF?text=BS',
                type: 'new_message',
                reference_id: 'chat2', // Menggunakan ID chat dari mock data chat sebelumnya
                is_read: false,
                created_at: '2025-06-23T10:15:00Z'
            },
            {
                id: 3,
                title: 'Product Update',
                message_text: 'Produk "E-book Marketing Digital" Anda telah diperbarui ke versi 2.0. Pelanggan akan diberitahu.',
                image_url: 'https://via.placeholder.com/80x64/33FF57/FFFFFF?text=E-book',
                type: 'product_update',
                reference_id: '103', // Contoh ID produk
                is_read: true, // Contoh notifikasi sudah dibaca
                created_at: '2025-06-20T09:00:00Z'
            },
            {
                id: 4,
                title: 'System Announcement',
                message_text: 'Penting: Pemeliharaan terjadwal pada 25 Juni 2025 dari 02:00 AM hingga 04:00 AM WIB.',
                image_url: 'https://via.placeholder.com/80x64/CCCCCC/FFFFFF?text=Info',
                type: 'announcement',
                reference_id: null,
                is_read: false,
                created_at: '2025-06-22T14:00:00Z'
            },
            {
                id: 5,
                title: 'Payment Reminder',
                message_text: 'Reminder: Pembayaran untuk langganan Premium Anda akan jatuh tempo pada 28 Juni 2025.',
                image_url: 'https://via.placeholder.com/80x64/FFA500/FFFFFF?text=Payment',
                type: 'payment_reminder',
                reference_id: 'SUB_9876',
                is_read: false,
                created_at: '2025-06-21T08:30:00Z'
            }
        ];

        // Dapatkan elemen-elemen DOM
        const notificationList = document.getElementById('notification-list');
        const markAsReadButton = document.getElementById('mark-as-read-button');
        const unreadCountBadge = document.getElementById('unread-count');
        const unreadNotificationBadgeContainer = document.getElementById('unread-notification-badge');

        // --- Fungsi untuk Merender Notifikasi di Halaman ---
        function renderNotifications() {
            notificationList.innerHTML = ''; // Bersihkan daftar notifikasi yang ada

            if (notificationsData.length === 0) {
                notificationList.innerHTML = '<p class="text-gray-400 text-center text-lg mt-10">Tidak ada notifikasi.</p>';
                return;
            }

            // Urutkan notifikasi agar yang belum dibaca tampil di atas
            const sortedNotifications = [...notificationsData].sort((a, b) => {
                // Notifikasi yang belum dibaca (false) akan diurutkan sebelum yang sudah dibaca (true)
                if (a.is_read === b.is_read) {
                    // Jika status sama, urutkan berdasarkan waktu terbaru
                    return new Date(b.created_at) - new Date(a.created_at);
                }
                return a.is_read ? 1 : -1; // false (belum dibaca) datang sebelum true (sudah dibaca)
            });


            sortedNotifications.forEach(notification => {
                const notificationItem = document.createElement('div');
                // Tentukan warna latar belakang dan border berdasarkan status baca
                const bgColor = notification.is_read ? 'bg-[#2e3650]' : 'bg-[#2e3650] border-l-4 border-[#19C94A]';

                notificationItem.className = `${bgColor} rounded-lg p-6 flex items-center gap-6 shadow-sm`;
                notificationItem.dataset.notificationId = notification.id; // Simpan ID notifikasi

                notificationItem.innerHTML = `
                    <div class="w-20 h-16 bg-gray-700 rounded-md flex-shrink-0 flex items-center justify-center overflow-hidden">
                        <img src="${notification.image_url || 'https://via.placeholder.com/80x64/4A5568/FFFFFF?text=No+Img'}" alt="Notification Image" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-lg text-white mb-1">${notification.title}</div>
                        <div class="text-gray-300 text-sm">${notification.message_text}</div>
                        <div class="text-gray-500 text-xs mt-2">${formatDate(notification.created_at)}</div>
                    </div>
                    <button class="bg-[#23293a] border border-[#19C94A] text-[#19C94A] px-6 py-2 rounded-lg font-semibold hover:bg-[#19C94A] hover:text-white transition check-details-button"
                            data-id="${notification.id}"
                            data-type="${notification.type}"
                            data-reference-id="${notification.reference_id || ''}">
                        Check Details
                    </button>
                `;
                notificationList.appendChild(notificationItem);
            });

            // Setelah notifikasi dirender, tambahkan event listener untuk tombol "Check Details"
            addCheckDetailsListeners();
            updateUnreadCount(); // Perbarui jumlah yang belum dibaca setelah merender
        }

        // --- Fungsi untuk Mengupdate Jumlah Notifikasi Belum Dibaca ---
        function updateUnreadCount() {
            const unreadCount = notificationsData.filter(n => !n.is_read).length;
            unreadCountBadge.textContent = unreadCount;

            if (unreadCount > 0) {
                unreadNotificationBadgeContainer.classList.remove('hidden');
                unreadNotificationBadgeContainer.classList.add('bg-green-600');
            } else {
                unreadNotificationBadgeContainer.classList.add('hidden'); // Sembunyikan badge jika 0
            }
        }

        // --- Fungsi untuk Menambahkan Event Listener ke Tombol "Check Details" ---
        function addCheckDetailsListeners() {
            document.querySelectorAll('.check-details-button').forEach(button => {
                // Pastikan event listener hanya ditambahkan sekali
                if (!button.dataset.listenerAdded) {
                    button.addEventListener('click', (event) => {
                        const notificationId = parseInt(event.target.dataset.id);
                        const notificationType = event.target.dataset.type;
                        const referenceId = event.target.dataset.referenceId;

                        markNotificationAsRead(notificationId); // Tandai sebagai dibaca di mock data
                        handleCheckDetails(notificationType, referenceId); // Lakukan aksi spesifik
                    });
                    button.dataset.listenerAdded = 'true'; // Tandai bahwa listener sudah ditambahkan
                }
            });
        }

        // --- Fungsi untuk Menangani Aksi "Check Details" ---
        function handleCheckDetails(type, referenceId) {
            // Logika pengarahan halaman. Ini hanya simulasi, Anda perlu URL yang valid.
            switch (type) {
                case 'transaction_successful':
                    alert(`Mengalihkan ke detail transaksi dengan ID: ${referenceId}`);
                    // window.location.href = `/transaction-details/${referenceId}`;
                    break;
                case 'product_update':
                    alert(`Mengalihkan ke halaman produk dengan ID: ${referenceId}`);
                    // window.location.href = `/my-product/${referenceId}`;
                    break;
                case 'new_message':
                    alert(`Mengalihkan ke chat dengan user ID: ${referenceId}`);
                    // window.location.href = `/chat-seller?userId=${referenceId}`;
                    break;
                default:
                    alert(`Melihat detail untuk tipe: ${type} (ID: ${referenceId || 'N/A'})`);
                    // window.location.href = '/Dashboard-seller'; // Arahkan ke dashboard jika tidak ada tipe spesifik
            }
        }

        // --- Fungsi untuk Menandai Notifikasi tunggal sebagai Sudah Dibaca (di mock data) ---
        function markNotificationAsRead(notificationId) {
            const notification = notificationsData.find(n => n.id === notificationId);
            if (notification && !notification.is_read) {
                notification.is_read = true;
                console.log(`Notification ${notificationId} marked as read locally.`);
                renderNotifications(); // Muat ulang tampilan notifikasi
            }
        }

        // --- Fungsi untuk Menandai SEMUA Notifikasi sebagai Sudah Dibaca (di mock data) ---
        function markAllNotificationsAsRead() {
            if (confirm("Apakah Anda yakin ingin menandai semua notifikasi sebagai sudah dibaca?")) {
                let unreadCount = 0;
                notificationsData.forEach(notification => {
                    if (!notification.is_read) {
                        notification.is_read = true;
                        unreadCount++;
                    }
                });
                if (unreadCount > 0) {
                    console.log(`Marked ${unreadCount} notifications as read locally.`);
                    renderNotifications(); // Muat ulang tampilan notifikasi
                } else {
                    alert('Tidak ada notifikasi yang belum dibaca.');
                }
            }
        }

        // --- Fungsi Helper untuk Memformat Tanggal ---
        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: false };
            // Menggunakan toLocaleString dengan timezone WIB secara eksplisit
            const formatter = new Intl.DateTimeFormat('id-ID', {
                ...options,
                timeZone: 'Asia/Jakarta' // WIB timezone
            });
            return formatter.format(date) + ' WIB';
        }

        // --- Logika untuk menyorot link sidebar yang aktif (sudah ada) ---
        document.addEventListener('DOMContentLoaded', () => {
            const currentPath = window.location.pathname;
            const sidebarLinks = document.querySelectorAll('nav a');

            sidebarLinks.forEach(link => {
                link.classList.remove('bg-gray-700', 'text-white', 'font-semibold');
                link.classList.add('text-gray-300');

                // Menangani path yang mungkin memiliki atau tidak memiliki trailing slash
                const linkPath = link.getAttribute('href').replace(/\/$/, '');
                const currentPathClean = currentPath.replace(/\/$/, '');

                if (linkPath === currentPathClean) {
                    link.classList.add('bg-gray-700', 'text-white', 'font-semibold');
                    link.classList.remove('text-gray-300');
                }
            });

            // Panggil fungsi untuk merender notifikasi saat halaman dimuat
            renderNotifications();

            // Tambahkan event listener untuk tombol "Mark as read"
            markAsReadButton.addEventListener('click', markAllNotificationsAsRead);
        });
    </script>
</body>

</html>