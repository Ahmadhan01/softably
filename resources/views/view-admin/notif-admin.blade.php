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

    @vite(['resources/js/app.js']) {{-- atau mix() jika pakai Laravel Mix --}}

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        window.Echo.channel('admin-notif')
            .listen('.new-message', (e) => {
                const notifBox = document.getElementById('adminNotifBox');
                if (notifBox) {
                    const newNotif = document.createElement('div');
                    newNotif.className = 'bg-blue-600 p-3 rounded text-white mb-2';
                    newNotif.innerHTML = `<strong>Pesan Baru:</strong> ${e.message.content}`;
                    notifBox.prepend(newNotif);
                }
            });
    </script>


</body>

</html>
