@extends('layouts.sidebar')

@section('title', 'Help Center - Softably')

@section('isi')
    <main class="min-h-screen flex flex-col ml-64 bg-[#F8FAFC] text-[#333333] font-sans ">
        <div class="p-6 flex-grow">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Help Center</h1>
                <button id="talkWithSoftablyBtn"
                    class="bg-[#2563EB] hover:bg-[#3B82F6] text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition-transform transform hover:scale-105">
                    <i class="fa-solid fa-headset"></i>
                    <span>Talk with Softably</span>
                </button>
            </div>

            <div class="flex flex-col md:flex-row gap-8">
                <div class="w-full md:w-1/3 lg:w-1/4"> {{-- Hapus z-10 di sini (biarkan default) --}}
                    <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
                        {{-- PERUBAHAN KRITIS DI SINI: Tambahkan position-relative dan z-[99] --}}
                        <nav class="space-y-1">
                            <a href="#"
                                class="help-topic-link flex items-center gap-3 p-3 rounded-md text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-all active" data-target="home-content"> {{-- Tambahkan relative z-10 --}}
                                <i class="fa-solid fa-house-chimney w-5 text-center"></i>
                                <span>Home</span>
                            </a>
                            <a href="#"
                                class="help-topic-link flex items-center gap-3 p-3 rounded-md text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-all"
                                data-target="get-started-content"> {{-- Tambahkan relative z-10 --}}
                                <i class="fa-solid fa-rocket w-5 text-center"></i>
                                <span>Get Started</span>
                            </a>
                            <a href="#"
                                class="help-topic-link flex items-center gap-3 p-3 rounded-md text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-all"
                                data-target="what-is-softably-content"> {{-- Tambahkan relative z-10 --}}
                                <i class="fa-solid fa-circle-info w-5 text-center"></i>
                                <span>What is Softably</span>
                            </a>
                            <a href="#"
                                class="help-topic-link flex items-center gap-3 p-3 rounded-md text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-all"
                                data-target="faq-content"> {{-- Tambahkan relative z-10 --}}
                                <i class="fa-solid fa-question-circle w-5 text-center"></i>
                                <span>FAQ</span>
                            </a>
                        </nav>
                    </div>
                </div>

                <div class="w-full md:w-2/3 lg:w-3/4">
                    <div class="bg-white p-6 rounded-lg min-h-[500px] shadow-md border border-gray-200">
                        <div id="home-content" class="help-content-panel" style="display: block;">
                            <h2 class="text-2xl font-bold mb-4 border-b border-gray-300 pb-2 text-gray-900">Selamat Datang di Pusat
                                Bantuan Softably!</h2>
                            <div class="space-y-4 text-gray-700">
                                <p>Halo! Di sini Anda dapat menemukan jawaban atas pertanyaan umum, panduan langkah demi
                                    langkah, dan informasi mendetail tentang semua fitur yang ditawarkan Softably. Kami
                                    berkomitmen untuk memberikan Anda pengalaman terbaik.</p>
                                <p>Gunakan menu di sebelah kiri untuk menavigasi topik bantuan. Jika Anda tidak menemukan
                                    apa yang Anda cari, jangan ragu untuk memulai percakapan dengan tim dukungan kami
                                    melalui tombol "Talk with Softably" di atas.</p>
                            </div>
                        </div>

                        <div id="get-started-content" class="help-content-panel" style="display: none;">
                            <h2 class="text-2xl font-bold mb-4 border-b border-gray-300 pb-2 text-gray-900">Memulai dengan Softably</h2>
                            <div class="space-y-4 text-gray-700">
                                <p>Langkah 1: Selesaikan pendaftaran akun Anda.</p>
                                <p>Langkah 2: Jelajahi katalog produk kami.</p>
                                <p>Langkah 3: Lakukan pesanan pertama Anda dan nikmati kemudahannya.</p>
                            </div>
                        </div>

                        <div id="what-is-softably-content" class="help-content-panel" style="display: none;">
                            <h2 class="text-2xl font-bold mb-4 border-b border-gray-300 pb-2 text-gray-900">Apa itu Softably?</h2>
                            <div class="space-y-4 text-gray-700">
                                <p>Softably adalah platform revolusioner yang dirancang untuk menyederhanakan proses
                                    akuisisi dan manajemen perangkat lunak untuk bisnis dan individu. Kami menyediakan pasar
                                    terpusat di mana pengguna dapat dengan mudah menemukan, membeli, dan mengelola berbagai
                                    lisensi perangkat lunak dari berbagai vendor.</p>
                                <p>Misi kami adalah menghilangkan kerumitan dalam pengadaan software, memberikan harga yang
                                    transparan, dan menawarkan dukungan pelanggan yang handal. Dengan Softably, Anda
                                    mendapatkan solusi perangkat lunak yang Anda butuhkan, kapan pun Anda membutuhkannya.
                                </p>
                            </div>
                        </div>

                        <div id="faq-content" class="help-content-panel" style="display: none;">
                            <h2 class="text-2xl font-bold mb-4 border-b border-gray-300 pb-2 text-gray-900">Frequently Asked Questions
                                (FAQ)</h2>
                            <div class="space-y-4 text-gray-700">
                                <div class="border-b border-gray-300 pb-2 mb-2">
                                    <h3 class="font-semibold text-gray-900">Q: Bagaimana cara melacak pesanan saya?</h3>
                                    <p class="mt-1 text-sm text-gray-600">A: Anda dapat melacak semua pesanan Anda melalui
                                        menu "My Orders"
                                        di sidebar Anda. Status pesanan akan diperbarui secara real-time.</p>
                                </div>
                                <div class="border-b border-gray-300 pb-2 mb-2">
                                    <h3 class="font-semibold text-gray-900">Q: Apakah pembayaran aman?</h3>
                                    <p class="mt-1 text-sm text-gray-600">A: Ya, kami menggunakan gateway pembayaran
                                        terenkripsi dan
                                        protokol keamanan standar industri untuk memastikan semua transaksi Anda aman dan
                                        terlindungi.</p>
                                </div>
                                <div class="border-b border-gray-300 pb-2 mb-2">
                                    <h3 class="font-semibold text-gray-900">Q: Bisakah saya mengembalikan produk yang sudah
                                        dibeli?</h3>
                                    <p class="mt-1 text-sm text-gray-600">A: Kebijakan pengembalian dana kami bervariasi
                                        tergantung pada
                                        jenis produk. Silakan lihat bagian 'Kebijakan Pengembalian' di Ketentuan Layanan
                                        kami,
                                        atau hubungi dukungan pelanggan untuk bantuan lebih lanjut.</p>
                                </div>
                                <div class="border-b border-gray-300 pb-2 mb-2">
                                    <h3 class="font-semibold text-gray-900">Q: Bagaimana cara menghubungi dukungan pelanggan?
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-600">A: Anda dapat menghubungi dukungan pelanggan kami
                                        melalui
                                        fitur 'Chat with Softably' yang tersedia di pusat bantuan ini, atau melalui email
                                        kami di
                                        support@softably.com.</p>
                                </div>
                                <div class="border-b border-gray-300 pb-2 mb-2">
                                    <h3 class="font-semibold text-gray-900">Q: Apa perbedaan antara Aplikasi, Konten Digital,
                                        Kursus Online, dan Aset Digital?</h3>
                                    <p class="mt-1 text-sm text-gray-600">A: <b>Aplikasi</b> adalah perangkat lunak yang
                                        dapat diinstal dan dijalankan. <b>Konten Digital</b> adalah media seperti e-book,
                                        musik, atau video. <b>Kursus Online</b> adalah materi pembelajaran interaktif.
                                        <b>Aset Digital</b> adalah elemen yang digunakan dalam desain atau pengembangan,
                                        seperti template, font, atau ikon.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div id="chat-softably-content" class="help-content-panel" style="display: none;">
                            <h2 class="text-2xl font-bold mb-4 border-b border-gray-300 pb-2 text-gray-900">Chat with Softably Support
                            </h2>
                            <div class="space-y-4 text-gray-700 h-64 overflow-y-auto bg-gray-100 p-4 rounded-lg border border-gray-300"
                                id="chat-messages" style="display: flex; flex-direction: column;"></div>
                            <div class="relative mt-4">
                                <input type="text" id="chatInput" placeholder="Type your message..."
                                    class="w-full bg-gray-100 border border-gray-300 rounded-lg py-3 pl-4 pr-12 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button id="sendMessageBtn"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-blue-600 hover:text-blue-700">
                                    <i class="fa-solid fa-paper-plane text-xl"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        /* ... (CSS yang sudah ada di head) ... */
        #faq-content h3 {
            color: #333333;
        }

        #faq-content p {
            color: #6B7280;
        }

        .help-topic-link.active {
            background-color: #2563EB;
            color: white;
            font-weight: 600;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
        Pusher.logToConsole = true;
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.cluster') }}',
            encrypted: true
        });
        const userId = {{ auth()->id() }};
        const channelName = `chat.${userId}`; // Channel untuk customer yang sedang login
        const channel = pusher.subscribe(channelName);
        channel.bind('MessageSent', function(data) {
            // Jika pesan diterima oleh customer yang sedang login DAN pengirimnya BUKAN customer itu sendiri
            // Ini berarti pesan datang dari admin
            if (data.receiver_id === userId && data.sender_id !== userId) {
                addMessageToChat(data, false); // false karena ini pesan dari orang lain (admin)
            }
            // Jika pesan dikirim oleh customer itu sendiri (untuk konfirmasi pengiriman)
            // Ini akan muncul di UI chat customer
            else if (data.sender_id === userId && data.receiver_id !== userId) {
                addMessageToChat(data, true); // true karena ini pesan dari diri sendiri
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const topicLinks = document.querySelectorAll('.help-topic-link');
            const contentPanels = document.querySelectorAll('.help-content-panel');
            const talkWithSoftablyBtn = document.getElementById('talkWithSoftablyBtn');
            const chatInput = document.getElementById('chatInput');
            const sendMessageBtn = document.getElementById('sendMessageBtn');
            const chatMessages = document.getElementById('chat-messages');

            function activateTab(targetId) {
                contentPanels.forEach(panel => panel.style.display = 'none');
                topicLinks.forEach(link => link.classList.remove('active'));

                const targetPanel = document.getElementById(targetId);
                if (targetPanel) targetPanel.style.display = 'block';

                const activeLink = document.querySelector(`.help-topic-link[data-target="${targetId}"]`);
                if (activeLink) activeLink.classList.add('active');
            }

            function addMessageToChat(msg, isMine) {
                const div = document.createElement('div');
                div.className = 'flex ' + (isMine ? 'justify-end' : 'justify-start') + ' mb-2';
                div.innerHTML = `
                    <div class="${isMine ? 'bg-blue-600 text-white' : 'bg-gray-700'} p-2 rounded-lg max-w-xs">
                        ${msg.content}
                    </div>`;
                chatMessages.appendChild(div);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            function loadAdminMessages() {
                fetch(`/chat/admin/messages`)
                    .then(res => {
                        if (!res.ok) {
                            throw new Error('Gagal memuat pesan: ' + res.statusText);
                        }
                        return res.json();
                    })
                    .then(data => {
                        chatMessages.innerHTML = '';
                        if (data.length === 0) {
                            chatMessages.innerHTML =
                                '<div class="text-center text-gray-500 mt-10">Belum ada percakapan dengan admin.</div>';
                        }
                        data.forEach(msg => {
                            const isMine = msg.sender_id == userId;
                            addMessageToChat(msg, isMine);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading messages:', error);
                        chatMessages.innerHTML =
                            '<div class="text-center text-red-400 mt-10">Gagal memuat riwayat pesan.</div>';
                    });
            }

            function sendMessageToAdmin() {
                const messageText = chatInput.value.trim();
                if (!messageText) return;

                fetch('/chat/admin/send', {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            message: messageText
                        })
                    })
                    .then(res => {
                        if (!res.ok) {
                            throw new Error('Gagal mengirim pesan: ' + res.statusText);
                        }
                        return res.json();
                    })
                    .then(data => {
                        chatInput.value = '';
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                        alert('Gagal mengirim pesan. Periksa koneksi dan pastikan login. Error: ' + error
                            .message);
                    });
            }

            sendMessageBtn?.addEventListener('click', sendMessageToAdmin);
            chatInput?.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    sendMessageToAdmin();
                }
            });

            talkWithSoftablyBtn.addEventListener('click', function() {
                activateTab('chat-softably-content');
                loadAdminMessages();
            });

            // Aktifkan tab Home secara default saat halaman dimuat
            activateTab('home-content');
        });
    </script>
@endpush    