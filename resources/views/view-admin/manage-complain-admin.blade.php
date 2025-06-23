<x-header-admin title="Complain Chat" />

<body class="bg-[#0f172a] text-white font-sans">
    <div class="flex min-h-screen">

        <x-sidebar-admin />

        <main class="flex w-full h-screen bg-[#0f172a] text-white ml-64">
            <!-- Chat Sidebar -->
            <div class="w-full md:w-1/4 xl:w-2/6 border-r border-gray-700 p-4">
                <h1 class="text-2xl font-semibold mb-4">Chat</h1>

                <!-- Search -->
                <div class="relative mb-4">
                    <input type="text" placeholder="Search people"
                        class="w-full bg-[#1e293b] text-white py-2 px-4 rounded focus:outline-none" />
                    <span class="absolute right-4 top-2 text-sm text-gray-400">All</span>
                </div>

                <!-- Chat List -->
                <ul id="customerList" class="space-y-3 overflow-y-auto max-h-[calc(100vh-200px)] pr-2">
                    <!-- Diisi lewat JavaScript -->
                </ul>
            </div>

            <!-- Chat Content -->
            <div class="flex-1 p-4 space-y-6 flex flex-col bg-[#0f172a]">
                <!-- Chat Header -->
                <div class="flex justify-between items-center border-b border-gray-700 pb-4">
                    <div>
                        <p id="chat-customer-name" class="font-bold text-lg">Pilih Customer</p>
                        <p class="text-sm text-gray-400">Riwayat Percakapan</p>
                    </div>
                </div>

                <!-- Chat Messages -->
                <div id="chat-messages" class="flex flex-col space-y-4 overflow-y-auto max-h-[calc(100vh-300px)] pr-2">
                    <!-- Diisi lewat JavaScript -->
                </div>

                <!-- Chat Input -->
                <div class="mt-auto pt-4 border-t border-gray-700">
                    <div class="flex gap-2">
                        <input type="text" id="adminReplyInput" placeholder="Ketik pesan..."
                            class="flex-1 px-4 py-2 bg-[#1e293b] text-white rounded focus:outline-none" />
                        <button id="adminSendBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        let selectedCustomerId = null;
        const replyInput = document.getElementById('adminReplyInput');
        const sendBtn = document.getElementById('adminSendBtn');
        const chatMessages = document.getElementById('chat-messages');

        function sendMessageToCustomer() {
            const msg = replyInput.value.trim();
            if (!msg || !selectedCustomerId) return;

            fetch(`/admin/chat/send/${selectedCustomerId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ message: msg })
                })
                .then(res => {
                    if (!res.ok) throw new Error('Gagal mengirim pesan');
                    return res.json();
                })
                .then(data => {
                    replyInput.value = '';
                    loadMessagesForCustomer(selectedCustomerId);
                })
                .catch(error => {
                    alert("Gagal mengirim pesan.");
                    console.error(error);
                });
        }

        sendBtn?.addEventListener('click', sendMessageToCustomer);
        replyInput?.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendMessageToCustomer();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Ambil daftar customer
            fetch('/admin/chat/customers')
                .then(res => res.json())
                .then(data => {
                    const list = document.getElementById('customerList');
                    data.forEach(cust => {
                        const li = document.createElement('li');
                        li.textContent = cust.name;
                        li.className = "p-2 hover:bg-gray-700 cursor-pointer";
                        li.addEventListener('click', () => {
                            selectedCustomerId = cust.id;
                            document.getElementById('chat-customer-name').innerText = cust.name;
                            loadMessagesForCustomer(selectedCustomerId);
                        });
                        list.appendChild(li);
                    });
                });
        });

        function loadMessagesForCustomer(id) {
            fetch(`/admin/chat/messages/${id}`)
                .then(res => res.json())
                .then(data => {
                    chatMessages.innerHTML = '';
                    data.forEach(msg => {
                        const isMine = msg.sender_id == {{ auth()->id() }};
                        const div = document.createElement('div');
                        div.className = 'flex ' + (isMine ? 'justify-end' : 'justify-start') + ' mb-2';
                        div.innerHTML = `
                            <div class="${isMine ? 'bg-blue-600 text-white' : 'bg-gray-700'} p-2 rounded-lg max-w-xs">
                                ${msg.content}
                            </div>`;
                        chatMessages.appendChild(div);
                    });
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                });
        }
    </script>
</body>

</html>
