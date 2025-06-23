<x-header-admin title="Help Center" />

<body class="bg-[#0f172a] text-white font-sans">
    <div class="flex min-h-screen">
        <x-sidebar-admin />

        <main class="ml-64 min-h-screen flex flex-col bg-[#10172A] text-white font-sans">
            <div class="p-8 flex-grow">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-bold text-white">Help Center</h1>
                </div>

                <div class="flex flex-col md:flex-row gap-8">
                    <div class="w-full md:w-1/3 lg:w-1/4">
                        <div class="bg-[#1E293B] p-4 rounded-lg">
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
                        <div class="bg-[#1E293B] p-6 rounded-lg min-h-[500px]">
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
                            <div id="faq-content" class="help-content-panel" style="display: none;">
                                <h2 class="text-2xl font-bold mb-4 border-b border-gray-700 pb-2">Frequently Asked
                                    Questions
                                    (FAQ)</h2>
                                <div class="space-y-4 text-gray-300">
                                    <div class="border-b border-gray-700 pb-2 mb-2">
                                        <h3 class="font-semibold text-white">Q: Bagaimana cara melacak pesanan saya?
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-400">A: Anda dapat melacak semua pesanan Anda
                                            melalui menu "My Orders"
                                            di sidebar Anda. Status pesanan akan diperbarui secara real-time.</p>
                                    </div>
                                    <div class="border-b border-gray-700 pb-2 mb-2">
                                        <h3 class="font-semibold text-white">Q: Apakah pembayaran aman?</h3>
                                        <p class="mt-1 text-sm text-gray-400">A: Ya, kami menggunakan gateway pembayaran
                                            terenkripsi dan
                                            protokol keamanan standar industri untuk memastikan semua transaksi Anda
                                            aman dan
                                            terlindungi.</p>
                                    </div>
                                    <div class="border-b border-gray-700 pb-2 mb-2">
                                        <h3 class="font-semibold text-white">Q: Bisakah saya mengembalikan produk yang
                                            sudah dibeli?</h3>
                                        <p class="mt-1 text-sm text-gray-400">A: Kebijakan pengembalian dana kami
                                            bervariasi tergantung pada
                                            jenis produk. Silakan lihat bagian 'Kebijakan Pengembalian' di Ketentuan
                                            Layanan kami,
                                            atau hubungi dukungan pelanggan untuk bantuan lebih lanjut.</p>
                                    </div>
                                    <div class="border-b border-gray-700 pb-2 mb-2">
                                        <h3 class="font-semibold text-white">Q: Bagaimana cara menghubungi dukungan
                                            pelanggan?</h3>
                                        <p class="mt-1 text-sm text-gray-400">A: Anda dapat menghubungi dukungan
                                            pelanggan kami melalui
                                            fitur 'Chat with Softably' yang tersedia di pusat bantuan ini, atau melalui
                                            email kami di
                                            support@softably.com.</p>
                                    </div>
                                    <div class="border-b border-gray-700 pb-2 mb-2">
                                        <h3 class="font-semibold text-white">Q: Apa perbedaan antara Aplikasi, Konten
                                            Digital, Kursus Online, dan Aset Digital?</h3>
                                        <p class="mt-1 text-sm text-gray-400">A: <b>Aplikasi</b> adalah perangkat lunak
                                            yang dapat diinstal dan dijalankan. <b>Konten Digital</b> adalah media
                                            seperti e-book, musik, atau video. <b>Kursus Online</b> adalah materi
                                            pembelajaran interaktif. <b>Aset Digital</b> adalah elemen yang digunakan
                                            dalam desain atau pengembangan, seperti template, font, atau ikon.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const topicLinks = document.querySelectorAll('.help-topic-link');
                const contentPanels = document.querySelectorAll('.help-content-panel');

                function activateTab(targetId) {
                    contentPanels.forEach(panel => panel.style.display = 'none');
                    topicLinks.forEach(link => link.classList.remove('active'));
                    const targetPanel = document.getElementById(targetId);
                    if (targetPanel) targetPanel.style.display = 'block';
                    const activeLink = document.querySelector(`.help-topic-link[data-target="${targetId}"]`);
                    if (activeLink) activeLink.classList.add('active');
                }

                activateTab('home-content');

                topicLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        activateTab(this.getAttribute('data-target'));
                    });
                });
            });
        </script>
    </div>
</body>

</html>
