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
                Pusher.logToConsole = true;
                const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                    cluster: '{{ config('broadcasting.connections.pusher.cluster') }}',
                    encrypted: true
                });
                const adminId = {{ auth()->id() }};
                const channel = pusher.subscribe(`chat.${adminId}`); // Channel untuk admin yang sedang login
                channel.bind('MessageSent', (data) => {
                    const notifBox = document.getElementById('adminNotifBox');
                    // Jika pesan diterima oleh admin yang sedang login DAN pengirimnya BUKAN admin itu sendiri
                    // Ini berarti pesan datang dari customer
                    if (data.receiver_id === adminId && data.sender_id !== adminId) {
                        if (notifBox) {
                            const noNotifMessage = notifBox.querySelector('.text-gray-400');
                            if (noNotifMessage && noNotifMessage.textContent === 'Belum ada notifikasi.') {
                                noNotifMessage.remove();
                            }
                            const newNotif = document.createElement('div');
                            newNotif.className = 'bg-blue-600 p-3 rounded text-white mb-2';
                            newNotif.innerHTML =
                                `<strong>Pesan Baru dari Customer (ID: ${data.sender_id}):</strong> ${data.content}`;
                            notifBox.prepend(newNotif);
                        }
                    }
                });
            </script>
        </body>

        </html>
