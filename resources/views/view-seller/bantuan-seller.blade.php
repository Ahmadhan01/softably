@extends('layouts.sidebar-seller')

@section('title', 'Help Center - Softably')

@section('isi')
<main class="min-h-screen flex flex-col bg-[#F8FAFC] text-gray-800 font-sans p-6 rounded-lg shadow-md"> {{-- Ubah background, teks, dan tambahkan padding, rounded, shadow --}}
    <div class="flex-grow"> {{-- Tambahkan flex-grow agar konten mengisi ruang --}}
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Help Center</h1> {{-- Ubah warna teks --}}
            <button id="talkWithSoftablyBtn"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition-transform transform hover:scale-105">
                <i class="fa-solid fa-headset"></i>
                <span>Talk with Softably</span>
            </button>
        </div>

        <div class="flex flex-col md:flex-row gap-8">
            <div class="w-full md:w-1/3 lg:w-1/4">
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200"> {{-- Ubah background, tambahkan shadow dan border --}}
                    <nav class="space-y-1">
                        {{-- Added 'active' class to the default active link --}}
                        <a href="#"
                            class="help-topic-link flex items-center gap-3 p-3 rounded-md text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-all active" {{-- Ubah warna teks, hover background, dan hover teks --}}
                            data-target="home-content">
                            <i class="fa-solid fa-house-chimney w-5 text-center text-blue-600"></i> {{-- Ubah warna ikon --}}
                            <span>Home</span>
                        </a>
                        <a href="#"
                            class="help-topic-link flex items-center gap-3 p-3 rounded-md text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-all" {{-- Ubah warna teks, hover background, dan hover teks --}}
                            data-target="get-started-content">
                            <i class="fa-solid fa-rocket w-5 text-center text-blue-600"></i> {{-- Ubah warna ikon --}}
                            <span>Get Started</span>
                        </a>
                        <a href="#"
                            class="help-topic-link flex items-center gap-3 p-3 rounded-md text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-all" {{-- Ubah warna teks, hover background, dan hover teks --}}
                            data-target="what-is-softably-content">
                            <i class="fa-solid fa-circle-info w-5 text-center text-blue-600"></i> {{-- Ubah warna ikon --}}
                            <span>What is Softably</span>
                        </a>
                        <a href="#"
                            class="help-topic-link flex items-center gap-3 p-3 rounded-md text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-all" {{-- Ubah warna teks, hover background, dan hover teks --}}
                            data-target="faq-content">
                            <i class="fa-solid fa-question-circle w-5 text-center text-blue-600"></i> {{-- Ubah warna ikon --}}
                            <span>FAQ</span>
                        </a>
                    </nav>
                </div>
            </div>

                <div class="w-full md:w-2/3 lg:w-3/4">
                    <div class="bg-white p-6 rounded-lg min-h-[500px] shadow-md border border-gray-200"> {{-- Ubah background, tambahkan shadow dan border --}}

                        <div id="home-content" class="help-content-panel active">
                            <h2 class="text-2xl font-bold mb-4 border-b border-gray-300 pb-2 text-gray-800">Selamat Datang di
                                Pusat
                                Bantuan Softably!</h2> {{-- Ubah border dan warna teks --}}
                            <div class="space-y-4 text-gray-700"> {{-- Ubah warna teks --}}
                                <p>Halo! Di sini Anda dapat menemukan jawaban atas pertanyaan umum, panduan langkah
                                    demi
                                    langkah, dan informasi mendetail tentang semua fitur yang ditawarkan Softably.
                                    Kami
                                    berkomitmen untuk memberikan Anda pengalaman terbaik.</p>
                                <p>Gunakan menu di sebelah kiri untuk menavigasi topik bantuan. Jika Anda tidak
                                    menemukan
                                    apa yang Anda cari, jangan ragu untuk memulai percakapan dengan tim dukungan
                                    kami
                                    melalui tombol "Talk with Softably" di atas.</p>
                            </div>
                        </div>

                        <div id="get-started-content" class="help-content-panel">
                            <h2 class="text-2xl font-bold mb-4 border-b border-gray-300 pb-2 text-gray-800">Memulai dengan
                                Softably</h2> {{-- Ubah border dan warna teks --}}
                            <div class="space-y-4 text-gray-700"> {{-- Ubah warna teks --}}
                                <p>Langkah 1: Selesaikan pendaftaran akun Anda.</p>
                                <p>Langkah 2: Jelajahi katalog produk kami.</p>
                                <p>Langkah 3: Lakukan pesanan pertama Anda dan nikmati kemudahannya.</p>
                            </div>
                        </div>

                        <div id="what-is-softably-content" class="help-content-panel">
                            <h2 class="text-2xl font-bold mb-4 border-b border-gray-300 pb-2 text-gray-800">Apa itu Softably?</h2> {{-- Ubah border dan warna teks --}}
                            <div class="space-y-4 text-gray-700"> {{-- Ubah warna teks --}}
                                <p>Softably adalah platform revolusioner yang dirancang untuk menyederhanakan proses
                                    akuisisi dan manajemen perangkat lunak untuk bisnis dan individu. Kami
                                    menyediakan pasar
                                    terpusat di mana pengguna dapat dengan mudah menemukan, membeli, dan mengelola
                                    berbagai
                                    lisensi perangkat lunak dari berbagai vendor.</p>
                                <p>Misi kami adalah menghilangkan kerumitan dalam pengadaan software, memberikan
                                    harga yang
                                    transparan, dan menawarkan dukungan pelanggan yang handal. Dengan Softably, Anda
                                    mendapatkan solusi perangkat lunak yang Anda butuhkan, kapan pun Anda
                                    membutuhkannya.
                                </p>
                            </div>
                        </div>

                        <div id="faq-content" class="help-content-panel">
                            <h2 class="text-2xl font-bold mb-4 border-b border-gray-300 pb-2 text-gray-800">Frequently Asked
                                Questions
                                (FAQ)</h2> {{-- Ubah border dan warna teks --}}
                            <div class="space-y-4 text-gray-700"> {{-- Ubah warna teks --}}
                                <div class="border-b border-gray-300 pb-2 mb-2"> {{-- Ubah border --}}
                                    <h3 class="font-semibold text-gray-800">Q: Bagaimana cara melacak pesanan saya?
                                    </h3> {{-- Ubah warna teks --}}
                                    <p class="mt-1 text-sm text-gray-600">A: Anda dapat melacak semua pesanan Anda
                                        melalui
                                        menu "My Orders"
                                        di sidebar Anda. Status pesanan akan diperbarui secara real-time.</p>
                                </div>
                                <div class="border-b border-gray-300 pb-2 mb-2"> {{-- Ubah border --}}
                                    <h3 class="font-semibold text-gray-800">Q: Apakah pembayaran aman?</h3> {{-- Ubah warna teks --}}
                                    <p class="mt-1 text-sm text-gray-600">A: Ya, kami menggunakan gateway pembayaran
                                        terenkripsi dan
                                        protokol keamanan standar industri untuk memastikan semua transaksi Anda
                                        aman dan
                                        terlindungi.</p>
                                </div>
                                <div class="border-b border-gray-300 pb-2 mb-2"> {{-- Ubah border --}}
                                    <h3 class="font-semibold text-gray-800">Q: Bisakah saya mengembalikan produk yang
                                        sudah
                                        dibeli?</h3> {{-- Ubah warna teks --}}
                                    <p class="mt-1 text-sm text-gray-600">A: Kebijakan pengembalian dana kami
                                        bervariasi
                                        tergantung pada
                                        jenis produk. Silakan lihat bagian 'Kebijakan Pengembalian' di Ketentuan
                                        Layanan
                                        kami,
                                        atau hubungi dukungan pelanggan untuk bantuan lebih lanjut.</p>
                                </div>
                                <div class="border-b border-gray-300 pb-2 mb-2"> {{-- Ubah border --}}
                                    <h3 class="font-semibold text-gray-800">Q: Bagaimana cara menghubungi dukungan
                                        pelanggan?
                                    </h3> {{-- Ubah warna teks --}}
                                    <p class="mt-1 text-sm text-gray-600">A: Anda dapat menghubungi dukungan
                                        pelanggan kami
                                        melalui
                                        fitur 'Chat with Softably' yang tersedia di pusat bantuan ini, atau melalui
                                        email
                                        kami di
                                        support@softably.com.</p>
                                </div>
                                <div class="border-b border-gray-300 pb-2 mb-2"> {{-- Ubah border --}}
                                    <h3 class="font-semibold text-gray-800">Q: Apa perbedaan antara Aplikasi, Konten
                                        Digital,
                                        Kursus Online, dan Aset Digital?</h3> {{-- Ubah warna teks --}}
                                    <p class="mt-1 text-sm text-gray-600">A: <b>Aplikasi</b> adalah perangkat lunak
                                        yang
                                        dapat diinstal dan dijalankan. <b>Konten Digital</b> adalah media seperti
                                        e-book,
                                        musik, atau video. <b>Kursus Online</b> adalah materi pembelajaran
                                        interaktif.
                                        <b>Aset Digital</b> adalah elemen yang digunakan dalam desain atau
                                        pengembangan,
                                        seperti template, font, atau ikon.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div id="chat-softably-content" class="help-content-panel">
                            <h2 class="text-2xl font-bold mb-4 border-b border-gray-300 pb-2 text-gray-800">Chat with Softably Support
                            </h2> {{-- Ubah border dan warna teks --}}
                            <div id="chat-messages" class="h-96 overflow-y-auto mb-4 space-y-4 pr-2">
                                <div class="text-center text-gray-600 py-10">Mulai percakapan dengan tim support kami</div> {{-- Ubah warna teks --}}
                            </div>
                            <div class="mt-auto border-t border-gray-300 pt-4"> {{-- Ubah border --}}
                                <div class="flex gap-2 items-center">
                                    <input type="text" id="chatInput" placeholder="Ketik pesan..."
                                        class="flex-1 bg-gray-100 border border-gray-300 rounded-lg py-3 px-4 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm"> {{-- Ubah background, border, teks, tambahkan shadow-sm --}}
                                    <button id="sendMessageBtn"
                                        class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-lg">
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</main>

    <style>
        .help-content-panel {
            display: none;
        }

        .help-content-panel.active {
            display: block;
        }

        .help-topic-link.active {
            background-color: #2563EB; /* Warna biru aktif */
            color: white;
            font-weight: 600;
        }
        .help-topic-link.active i.fa-solid { /* Ikon aktif */
            color: white;
        }

        /* Scrollbar untuk chat messages container */
        #chat-messages::-webkit-scrollbar {
            width: 8px; /* Lebih lebar dari 6px agar lebih terlihat */
        }

        #chat-messages::-webkit-scrollbar-track {
            background: #F8FAFC; /* Track cerah */
            border-radius: 10px;
        }

        #chat-messages::-webkit-scrollbar-thumb {
            background: #60A5FA; /* Thumb biru terang */
            border-radius: 10px;
            border: 2px solid #F8FAFC; /* Border sesuai background track */
        }
        #chat-messages::-webkit-scrollbar-thumb:hover {
            background: #3B82F6; /* Hover thumb biru */
        }

        /* Gaya untuk pesan chat di dalam panel chat */
        #chat-softably-content .bg-blue-600 { /* Pesan saya (terkirim) */
            background-color: #2563EB; /* Biru terang */
        }
        #chat-softably-content .bg-gray-700 { /* Pesan lawan bicara (diterima) */
            background-color: #E5E7EB; /* Abu-abu terang */
            color: #374151; /* Teks abu-abu gelap */
        }
        #chat-softably-content .bg-blue-600 .text-xs.opacity-70 { /* Waktu pesan saya */
            color: rgba(255,255,255,0.8); /* Waktu pesan terkirim */
        }
        #chat-softably-content .bg-gray-700 .text-xs.opacity-70 { /* Waktu pesan lawan bicara */
            color: rgba(55,65,81,0.7); /* Waktu pesan diterima */
        }
    </style>
@endsection

@push('scripts')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const chatInput = document.getElementById('chatInput');
            const sendMessageBtn = document.getElementById('sendMessageBtn');
            const chatMessages = document.getElementById('chat-messages');
            const talkWithSoftablyBtn = document.getElementById('talkWithSoftablyBtn');
            const helpTopicLinks = document.querySelectorAll('.help-topic-link');
            const helpContentPanels = document.querySelectorAll('.help-content-panel');

            // Pusher Configuration - Sesuaikan dengan config sebelumnya
            const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                cluster: '{{ config('broadcasting.connections.pusher.cluster') }}',
                encrypted: true,
                authEndpoint: '/broadcasting/auth',
                auth: {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            });

            // Subscribe to private channel sesuai dengan sistem sebelumnya
            const channel = pusher.subscribe('chat.{{ auth()->id() }}');

            // Fungsi untuk menambahkan pesan ke chat
            function addMessageToChat(msg, isMine) {
                const div = document.createElement('div');
                div.className = `flex ${isMine ? 'justify-end' : 'justify-start'}`;
                div.innerHTML = `
        <div class="${isMine ? 'bg-blue-600' : 'bg-gray-700'} text-white p-3 rounded-lg max-w-[80%]">
            ${msg.content}
            <div class="text-xs opacity-70 mt-1 text-right">
                ${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
            </div>
        </div>
    `;
                chatMessages.appendChild(div);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }


            // Fungsi untuk mengirim pesan - Sesuaikan dengan endpoint di controller
            function sendMessage() {
                const messageContent = chatInput.value.trim();
                if (!messageContent) return;

                // Tampilkan pesan langsung di UI (optimistic update)
                addMessageToChat({
                    content: messageContent,
                    created_at: new Date().toISOString(),
                    sender_id: {{ auth()->id() }}
                }, true);

                // Kosongkan input
                chatInput.value = '';

                // Kirim ke server
                fetch('/seller/chat/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message: messageContent
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to send message');
                        return response.json();
                    })
                    .then(data => {
                        console.log('Message sent successfully:', data);
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                        alert('Gagal mengirim pesan. Silakan coba lagi.');
                    });
            }

            // Fungsi untuk memuat riwayat chat - Sesuaikan dengan endpoint di controller
            function loadChatHistory() {
                fetch('/seller/chat/history')
                    .then(response => response.json())
                    .then(messages => {
                        chatMessages.innerHTML = '';
                        if (messages.length === 0) {
                            chatMessages.innerHTML =
                                '<div class="text-center text-gray-600 py-10">Belum ada percakapan</div>'; /* Ubah warna teks */
                            return;
                        }
                        messages.forEach(msg => {
                            addMessageToChat(msg, msg.sender_id === {{ auth()->id() }});
                        });
                    });
            }

            // Event listener untuk pesan masuk dari Pusher
            channel.bind('MessageSent', function(data) {
                // Hanya tampilkan jika pesan untuk seller ini dan dari admin
                if (data.receiver_id === {{ auth()->id() }} && data.sender_id !== {{ auth()->id() }}) {
                    addMessageToChat(data, false);
                }
            });

            loadChatHistory();

            // Event listeners
            sendMessageBtn.addEventListener('click', sendMessage);
            chatInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });

            // Navigation system
            function showPanel(targetId) {
                helpContentPanels.forEach(panel => {
                    panel.classList.remove('active');
                });
                helpTopicLinks.forEach(link => {
                    link.classList.remove('active');
                    // Mengembalikan warna ikon dan teks normal jika tidak aktif
                    link.querySelector('i').style.color = '#2563EB'; // Warna ikon default
                    link.style.color = '#4A5568'; // text-gray-700
                });

                document.getElementById(targetId).classList.add('active');
                const activeLink = document.querySelector(`.help-topic-link[data-target="${targetId}"]`);
                if (activeLink) {
                    activeLink.classList.add('active');
                    // Mengubah warna ikon dan teks untuk link aktif
                    activeLink.querySelector('i').style.color = 'white';
                    activeLink.style.color = 'white';
                }
            }

            helpTopicLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    showPanel(this.dataset.target);
                });
            });

            talkWithSoftablyBtn.addEventListener('click', function(e) {
                e.preventDefault();
                showPanel('chat-softably-content');
                loadChatHistory();
            });

            // Set panel awal
            showPanel('home-content');
        });
    </script>
@endpush