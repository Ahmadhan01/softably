        <x-header-admin title="Notification" />

        <body class="bg-[#0f172a] text-white font-sans">

            <div class="flex min-h-screen">

                <x-sidebar-admin />

                <main class="ml-64 min-h-screen flex flex-col bg-[#10172A] text-white font-sans">
                    <div class="p-8 flex-grow">
                        <h1 class="text-3xl font-bold text-white mb-6">Notifikasi Pesan Masuk</h1>

                        <div id="adminNotifBox" class="space-y-2">
                            <div class="text-gray-400">Belum ada notifikasi.</div>
                        </div>
                    </div>
                </main>

            </div>

            <meta name="csrf-token" content="{{ csrf_token() }}">
            <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

            <script>
                const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                    cluster: '{{ config('broadcasting.connections.pusher.cluster') }}'
                });

                const channel = pusher.subscribe('chat.{{ auth()->id() }}');

                channel.bind('MessageSent', function(data) {
                    if (data.receiver_id === {{ auth()->id() }} && data.sender_role === 'seller') {
                        // Update notifikasi
                        const notifContainer = document.getElementById('notification-container');
                        const noNotif = document.getElementById('no-notification');

                        if (noNotif) noNotif.remove();

                        const notifItem = document.createElement('div');
                        notifItem.className = 'p-3 border-b border-gray-700';
                        notifItem.innerHTML = `
                <div class="font-semibold">Pesan baru dari ${data.sender_name}</div>
                <div class="text-sm text-gray-300">${data.content}</div>
                <div class="text-xs text-gray-500 mt-1">${new Date(data.created_at).toLocaleString()}</div>
            `;
                        notifContainer.prepend(notifItem);

                        // Update badge counter di sidebar
                        updateSidebarBadge(data.unread_count);
                    }
                });

                function updateSidebarBadge(count) {
                    const badge = document.getElementById('notification-badge');
                    if (badge) {
                        badge.textContent = count;
                        badge.classList.toggle('hidden', count === 0);
                    }
                }
            </script>

        </body>

        </html>
