<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/1531486bb6.js" crossorigin="anonymous"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-bg': '#23293a',
                        'dark-card': '#23293a',
                        'dark-hover': '#374151',
                        'sidebar': '#23293a',
                        'sidebar-active': '#fff',
                        'sidebar-inactive': '#23293a',
                        'sidebar-text': '#fff',
                        'sidebar-hover': '#2d3748',
                        'main-bg': '#23293a',
                        'main-card': '#23293a',
                        'main-border': '#23293a',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-[#23293a] text-white min-h-screen font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-[#23293a] flex flex-col justify-between border-r border-[#23293a] relative z-10">
            <div>
                <div class="p-6 border-b border-gray-700 flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                        <img src="img/man.jpg" alt="" class="rounded-full">
                    </div>
                    <span class="text-white font-semibold">Ini Logo Web</span>
                </div>
                <div class="p-4">
                    <p class="text-gray-400 text-xs uppercase tracking-wider mb-4">MENU</p>
                    <nav class="space-y-2">
                        <a href="/Dashboard-seller"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fa-solid fa-store"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="/My-product-seller"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fas fa-file-alt"></i>
                            <span>My Product</span>
                        </a>
                        <a href="/Chat-seller"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fa-solid fa-message"></i>
                            <span>Chat</span>
                        </a>
                        <a href="/Notification-seller"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fa-solid fa-bell"></i>
                            <span>Notification</span>
                            <div
                                class="flex items-center w-3 h-3 bg-green-600 rounded-full right-5 justify-center py-3 px-4 ml-2">
                                <div class="flex">4</div>
                            </div>
                        </a>
                        <a href="/Help-Center-seller"
                            class="flex items-center space-x-3 p-3 rounded-lg bg-gray-700 text-white font-semibold">
                            <i class="fa-solid fa-circle-question"></i>
                            <span>Help Center</span>
                        </a>
                    </nav>
                </div>
            </div>
            <div class="w-full p-4 border-t border-gray-700">
                <div
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors cursor-pointer">
                    <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center">
                        <img src="img/man.jpg" alt="" class="rounded-full">
                    </div>
                    <div class="flex-1">
                        <p class="text-white text-sm font-medium">Fuad Store</p>
                        <p class="text-gray-400 text-xs">Store settings</p>
                    </div>
                </div>
                <div class="mt-8 space-y-2">
                    <a href="/Settings-seller"
                        class="flex items-center space-x-3 p-2 text-gray-300 hover:text-white transition-colors">
                        <i class="fa-solid fa-gear"></i>
                        <span class="text-sm">Settings</span>
                    </a>
                    <a href="/Log-out-seller"
                        class="flex items-center space-x-3 p-2 text-gray-300 hover:text-white transition-colors">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="text-sm">Log Out</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <div class="border-l flex justify-between items-center border-b border-gray-700 px-8 py-6">
                <h1 class="text-2xl font-bold">Help Center</h1>
                <span class="text-lg font-light">Talk with Softably</span>
            </div>
            <div class="flex flex-1 overflow-hidden">
                <!-- Left: Topics -->
                <div class="border-l w-80 bg-transparent border-r border-gray-700 p-6 flex flex-col">
                    <div class="mb-4">
                        <div class="relative">
                            <input type="text" placeholder="Search topic"
                                class="w-full bg-gray-700 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pl-10" />
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                        </div>
                    </div>
                    <ul class="space-y-2 text-gray-200 text-base" id="topics">
                        <li onclick="loadContent('Home')"
                            class="ml-2 hover:bg-gray-700 rounded-lg p-2 cursor-pointer flex items-center gap-2">
                            <i class="fa-solid fa-house"></i> Home</li>
                        <li onclick="loadContent('Get Started')"
                            class="ml-2 hover:bg-gray-700 rounded-lg p-2 cursor-pointer flex items-center gap-2">
                            <i class="fa-solid fa-rocket"></i> Get Started</li>
                        <li onclick="loadContent('What is Softably')"
                            class="ml-2 hover:bg-gray-700 rounded-lg p-2 cursor-pointer flex items-center gap-2">
                            <i class="fa-solid fa-circle-info"></i> What is Softably</li>
                        <li onclick="loadContent('FAQ')"
                            class="ml-2 hover:bg-gray-700 rounded-lg p-2 cursor-pointer flex items-center gap-2">
                            <i class="fa-solid fa-question"></i> FAQ</li>
                    </ul>
                </div>

                <!-- Right: Chat Area -->
                <div class="flex-1 flex flex-col bg-[#23293a] p-6 relative">
                    <div class="flex justify-center mb-4">
                        <button class="bg-gray-800 text-white px-6 py-2 rounded-lg font-semibold">Hari ini</button>
                    </div>
                    <div id="chatMessages" class="space-y-4 flex-1 overflow-y-auto">
                        <div class="bg-gray-500 rounded-lg p-4 text-sm">Halo! Ada yang bisa kami bantu?</div>
                    </div>
                    <!-- Chat Input -->
                    <form class="flex items-center mt-6" onsubmit="sendMessage(event)">
                        <input id="chatInput" type="text" placeholder="Type your message..."
                            class="flex-1 bg-white text-gray-900 px-4 py-3 rounded-l-lg focus:outline-none" />
                        <button type="submit"
                            class="bg-white px-6 py-6 w-4 h-4 border-l bg-black-900 rounded-r-lg flex items-center hover:bg-green-400 justify-center">
                            <i class="fa-solid fa-paper-plane text-2xl text-[#23293a]"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Interaktif -->
    <script>
        function loadContent(topic) {
            const chatBox = document.getElementById("chatMessages");
            const content = document.createElement("div");
            content.className = "bg-gray-800 rounded-lg p-4 text-sm";
            content.textContent = "You selected: " + topic + ". Konten akan dimuat di sini.";
            chatBox.appendChild(content);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        function sendMessage(event) {
            event.preventDefault();
            const input = document.getElementById("chatInput");
            const message = input.value.trim();
            if (message === "") return;

            const chatBox = document.getElementById("chatMessages");
            const newMsg = document.createElement("div");
            newMsg.className = "bg-gray-700 rounded-lg p-4 text-sm self-end";
            newMsg.textContent = message;
            chatBox.appendChild(newMsg);

            input.value = "";
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    </script>
    <!-- Letakkan bagian ini di dalam <body> seperti sebelumnya -->
<script>
    function loadContent(topic) {
        const chatBox = document.getElementById("chatMessages");
        const content = document.createElement("div");
        content.className = "bg-gray-800 rounded-lg p-4 text-sm";
        content.textContent = "Kamu memilih topik: " + topic + ". Ini akan menampilkan detail topik dari database.";
        chatBox.appendChild(content);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function sendMessage(event) {
        event.preventDefault();
        const input = document.getElementById("chatInput");
        const message = input.value.trim();
        if (message === "") return;

        const chatBox = document.getElementById("chatMessages");

        // Tampilkan pesan user
        const userMsg = document.createElement("div");
        userMsg.className = "bg-blue-600 rounded-lg p-4 text-sm text-white self-end text-right";
        userMsg.textContent = message;
        chatBox.appendChild(userMsg);

        // Balas otomatis setelah sedikit delay
        setTimeout(() => {
            const botMsg = document.createElement("div");
            botMsg.className = "bg-gray-800 rounded-lg p-4 text-sm";

            // Balasan berdasarkan keyword
            botMsg.textContent = getBotReply(message.toLowerCase());

            chatBox.appendChild(botMsg);
            chatBox.scrollTop = chatBox.scrollHeight;
        }, 500);

        input.value = "";
    }

    function getBotReply(message) {
        if (message.includes("halo") || message.includes("hai")) {
            return "Halo! Ada yang bisa kami bantu?";
        }
        if (message.includes("produk")) {
            return "Untuk melihat produk Anda, silakan klik menu 'My Product'.";
        }
        if (message.includes("cara jual")) {
            return "Untuk menjual produk, klik 'My Product' > 'Add Product', lalu isi detailnya.";
        }
        if (message.includes("akun") || message.includes("login")) {
            return "Jika Anda mengalami masalah akun, pastikan email dan password sudah benar. Jika lupa password, gunakan fitur 'Lupa Password'.";
        }
        if (message.includes("admin")) {
            return "Anda bisa menghubungi admin melalui email: support@fuadstore.com";
        }
        return "Maaf, saya tidak mengerti pertanyaan Anda. Coba gunakan kata kunci seperti 'produk', 'akun', atau 'cara jual'.";
    }
</script>
</body>

</html>
