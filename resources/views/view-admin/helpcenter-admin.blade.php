<x-header-admin title="Help Center" />

<body class="bg-[#0f172a] text-white font-sans">

    <div class="flex min-h-screen">

       <x-sidebar-admin />

        {{-- Class ml-64 (margin-left: 16rem) memberikan ruang untuk sidebar fixed selebar w-64 (width: 16rem) --}}
        <main class="ml-64 min-h-screen flex flex-col">
            <div class="p-8 flex-grow">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-bold text-white">Help Center</h1>
                    <button id="talkWithSoftablyBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition-transform transform hover:scale-105">
                        <i class="fa-solid fa-headset"></i>
                        <span>Talk with Softably</span>
                    </button>
                </div>

                <div class="flex flex-col md:flex-row gap-8">
                    <div class="w-full md:w-1/3 lg:w-1/4">
                        <div class="bg-[#1E293B] p-4 rounded-lg">
                            <div class="relative mb-4">
                                <i
                                    class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" placeholder="Search topic"
                                    class="w-full bg-[#2D3A4F] border border-gray-600 rounded-md py-2 pl-10 pr-4 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <nav class="space-y-1">
                                <a href="#"
                                    class="help-topic-link flex items-center gap-3 p-3 rounded-md text-gray-300 hover:bg-[#2D3A4F] hover:text-white transition-all"
                                    data-target="home-content">
                                    <i class="fa-solid fa-house-chimney w-5 text-center"></i>
                                    <span>Home</span>
                                </a>
                                <a href="#"
                                    class="help-topic-link flex items-center gap-3 p-3 rounded-md text-gray-300 hover:bg-[#2D3A4F] hover:text-white transition-all"
                                    data-target="get-started-content">
                                    <i class="fa-solid fa-rocket w-5 text-center"></i>
                                    <span>Get Started</span>
                                </a>
                                <a href="#"
                                    class="help-topic-link flex items-center gap-3 p-3 rounded-md text-gray-300 hover:bg-[#2D3A4F] hover:text-white transition-all"
                                    data-target="what-is-softably-content">
                                    <i class="fa-solid fa-circle-info w-5 text-center"></i>
                                    <span>What is Softably</span>
                                </a>
                                <a href="#"
                                    class="help-topic-link flex items-center gap-3 p-3 rounded-md text-gray-300 hover:bg-[#2D3A4F] hover:text-white transition-all"
                                    data-target="faq-content">
                                    <i class="fa-solid fa-question-circle w-5 text-center"></i>
                                    <span>FAQ</span>
                                </a>
                            </nav>
                        </div>
                    </div>

                    <div class="w-full md:w-2/3 lg:w-3/4">
                        <div class="bg-[#1E293B] p-6 rounded-lg min-h-[300px]">

                            <div id="home-content" class="help-content-panel">
                                <h2 class="text-2xl font-bold mb-4 border-b border-gray-700 pb-2">Selamat Datang di
                                    Pusat
                                    Bantuan Softably!</h2>
                                <div class="space-y-4 text-gray-300">
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

                            <div id="get-started-content" class="help-content-panel" style="display: none;">
                                <h2 class="text-2xl font-bold mb-4 border-b border-gray-700 pb-2">Memulai dengan
                                    Softably</h2>
                                <div class="space-y-4 text-gray-300">
                                    <p>Langkah 1: Selesaikan pendaftaran akun Anda.</p>
                                    <p>Langkah 2: Jelajahi katalog produk kami.</p>
                                    <p>Langkah 3: Lakukan pesanan pertama Anda dan nikmati kemudahannya.</p>
                                </div>
                            </div>

                            <div id="what-is-softably-content" class="help-content-panel" style="display: none;">
                                <h2 class="text-2xl font-bold mb-4 border-b border-gray-700 pb-2">Apa itu Softably?</h2>
                                <div class="space-y-4 text-gray-300">
                                    <p>*Softably* adalah platform revolusioner yang dirancang untuk menyederhanakan
                                        proses
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

                            <div id="faq-content" class="help-content-panel" style="display: none;">
                                <h2 class="text-2xl font-bold mb-4 border-b border-gray-700 pb-2">Frequently Asked
                                    Questions
                                    (FAQ)</h2>
                                <div class="space-y-4 text-gray-300">
                                    <div class="border-b border-gray-700 pb-2 mb-2">
                                        <h3 class="font-semibold">Bagaimana cara melacak pesanan saya?</h3>
                                        <p class="mt-1 text-sm">Anda dapat melacak semua pesanan Anda melalui menu "My
                                            Orders"
                                            di sidebar.</p>
                                    </div>
                                    <div class="border-b border-gray-700 pb-2 mb-2">
                                        <h3 class="font-semibold">Apakah pembayaran aman?</h3>
                                        <p class="mt-1 text-sm">Ya, kami menggunakan gateway pembayaran terenkripsi
                                            untuk
                                            memastikan semua transaksi Anda aman.</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Chat Panel --}}
                            <div id="chat-softably-content" class="help-content-panel" style="display: none;">
                                <h2 class="text-2xl font-bold mb-4 border-b border-gray-700 pb-2">Chat with Softably
                                    Support
                                </h2>
                                <div class="space-y-4 text-gray-300 h-64 overflow-y-auto" id="chat-messages">
                                    {{-- Contoh pesan (bisa diisi dari database atau AJAX) --}}
                                    <div class="flex justify-start mb-2">
                                        <div class="bg-gray-700 p-2 rounded-lg max-w-xs">
                                            Halo! Ada yang bisa kami bantu?
                                        </div>
                                    </div>
                                    {{-- Pesan baru akan ditambahkan di sini --}}
                                </div>
                                <div class="relative mt-4">
                                    <input type="text" id="chatInput" placeholder="Type your message..."
                                        class="w-full bg-[#2D3A4F] border border-gray-600 rounded-lg py-3 pl-4 pr-12 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <button id="sendMessageBtn"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white">
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
            .help-topic-link.active {
                background-color: #3b82f6;
                color: white;
                font-weight: 600;
            }
        </style>
    

   
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const topicLinks = document.querySelectorAll('.help-topic-link');
                const contentPanels = document.querySelectorAll('.help-content-panel');
                const talkWithSoftablyBtn = document.getElementById('talkWithSoftablyBtn');
                const chatInput = document.getElementById('chatInput');
                const sendMessageBtn = document.getElementById('sendMessageBtn');
                const chatMessages = document.getElementById('chat-messages');

                function activateTab(targetId) {
                    contentPanels.forEach(panel => {
                        panel.style.display = 'none';
                    });
                    topicLinks.forEach(link => {
                        link.classList.remove('active');
                    });

                    const targetPanel = document.getElementById(targetId);
                    if (targetPanel) {
                        targetPanel.style.display = 'block';
                    }

                    const activeLink = document.querySelector(.help - topic - link[data - target = "${targetId}"]);
                    if (activeLink) {
                        activeLink.classList.add('active');
                    }
                }

                // Tampilkan 'home-content' secara default
                activateTab('home-content');

                // Event listener untuk menu topik
                topicLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetId = this.getAttribute('data-target');
                        activateTab(targetId);
                    });
                });

                // Event listener untuk tombol "Talk with Softably"
                talkWithSoftablyBtn.addEventListener('click', function() {
                    activateTab('chat-softably-content');
                });

                // Fungsi untuk mengirim pesan (placeholder, Anda akan mengintegrasikannya dengan backend)
                function sendMessage() {
                    const messageText = chatInput.value.trim();
                    if (messageText !== '') {
                        const messageDiv = document.createElement('div');
                        messageDiv.classList.add('flex', 'justify-end', 'mb-2'); // Agar pesan kita di kanan
                        messageDiv.innerHTML = `
                    <div class="bg-blue-600 p-2 rounded-lg max-w-xs text-white">
                        ${messageText}
                    </div>
                `;
                        chatMessages.appendChild(messageDiv);
                        chatInput.value = ''; // Bersihkan input
                        chatMessages.scrollTop = chatMessages.scrollHeight; // Gulir ke bawah
                    }
                }

                // Event listener untuk tombol kirim pesan
                sendMessageBtn.addEventListener('click', sendMessage);

                // Event listener untuk tombol Enter di input chat
                chatInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        sendMessage();
                    }
                });
            });
        </script>
   
</div>

</body>

</html>
