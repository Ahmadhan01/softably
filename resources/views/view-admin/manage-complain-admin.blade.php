        <x-header-admin title="Complain Chat" />

        <body class="bg-[#0f172a] text-white font-sans">
            <div class="flex min-h-screen">

                <x-sidebar-admin />

                <main class="flex w-full h-screen bg-[#0f172a] text-white ml-64">
                    <!-- Chat Sidebar -->
                    <div class="w-full md:w-1/4 xl:w-2/6 border-r border-gray-700 p-4">
                        <h1 class="text-2xl font-semibold mb-4">Chat</h1>

                        <!-- Search (Optional, can be implemented later) -->
                        <div class="relative mb-4">
                            <input type="text" placeholder="Search people"
                                class="w-full bg-[#1e293b] text-white py-2 px-4 rounded focus:outline-none" />
                            <span class="absolute right-4 top-2 text-sm text-gray-400">All</span>
                        </div>

                        <!-- Chat List -->
                        <ul id="customerList" class="space-y-3 overflow-y-auto max-h-[calc(100vh-200px)] pr-2">
                            <!-- Diisi lewat JavaScript -->
                            <li class="p-2 text-gray-400">Loading customers...</li>
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
                        <div id="chat-messages"
                            class="flex flex-col space-y-4 overflow-y-auto max-h-[calc(100vh-300px)] pr-2">
                            <!-- Diisi lewat JavaScript -->
                            <div class="text-center text-gray-500 mt-10">Pilih customer dari daftar untuk memulai chat.
                            </div>
                        </div>

                        <!-- Chat Input -->
                        <div class="mt-auto pt-4 border-t border-gray-700">
                            <div class="flex gap-2">
                                <input type="text" id="adminReplyInput" placeholder="Ketik pesan..."
                                    class="flex-1 px-4 py-2 bg-[#1e293b] text-white rounded focus:outline-none"
                                    disabled />
                                <button id="adminSendBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded"
                                    disabled>
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </div>
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
                let selectedCustomerId = null;
                const replyInput = document.getElementById('adminReplyInput');
                const sendBtn = document.getElementById('adminSendBtn');
                const chatMessages = document.getElementById('chat-messages');
                const chatCustomerName = document.getElementById('chat-customer-name');

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

                function sendMessageToCustomer() {
                    const msg = replyInput.value.trim();
                    if (!msg || !selectedCustomerId) return;

                    fetch(`/admin/chat/send/${selectedCustomerId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                message: msg
                            })
                        })
                        .then(res => {
                            if (!res.ok) {
                                throw new Error('Gagal mengirim pesan: ' + res.statusText);
                            }
                            return res.json();
                        })
                        .then(data => {
                            replyInput.value = '';
                        })
                        .catch(error => {
                            alert("Gagal mengirim pesan: " + error.message);
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
                    fetch('/admin/chat/customers')
                        .then(res => res.json())
                        .then(data => {
                            const list = document.getElementById('customerList');
                            list.innerHTML = '';
                            if (data.length === 0) {
                                list.innerHTML =
                                    '<li class="p-2 text-gray-400">Tidak ada customer yang pernah chat.</li>';
                            }
                            data.forEach(cust => {
                                const li = document.createElement('li');
                                li.textContent = cust.name;
                                li.className =
                                    "p-2 hover:bg-gray-700 cursor-pointer rounded-md transition-colors";
                                li.dataset.customerId = cust.id;
                                li.addEventListener('click', () => {
                                    document.querySelectorAll('#customerList li').forEach(item => {
                                        item.classList.remove('bg-blue-700');
                                    });
                                    li.classList.add('bg-blue-700');

                                    selectedCustomerId = cust.id;
                                    chatCustomerName.innerText = cust.name;
                                    replyInput.disabled = false;
                                    sendBtn.disabled = false;
                                    loadMessagesForCustomer(selectedCustomerId);

                                    // Unsubscribe dari channel sebelumnya jika ada
                                    if (typeof channel !== 'undefined') {
                                        pusher.unsubscribe(`chat.${selectedCustomerId}`);
                                    }

                                    // Subscribe ke channel customer yang dipilih
                                    const channel = pusher.subscribe(`chat.${selectedCustomerId}`);

                                    channel.bind('MessageSent', function(data) {
                                        // Pastikan hanya menambahkan pesan jika pengirim adalah customer yang dipilih
                                        if (data.receiver_id === {{ auth()->id() }} && data
                                            .sender_id === selectedCustomerId) {
                                            addMessageToChat(data, false);
                                        }
                                    });
                                });
                                list.appendChild(li);
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching customer list:', error);
                            document.getElementById('customerList').innerHTML =
                                '<li class="p-2 text-red-400">Gagal memuat daftar customer.</li>';
                        });
                });


                function loadMessagesForCustomer(id) {
                    fetch(`/admin/chat/messages/${id}`)
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
                                    '<div class="text-center text-gray-500 mt-10">Belum ada percakapan dengan customer ini.</div>';
                            }
                            data.forEach(msg => {
                                const isMine = msg.sender_id == {{ auth()->id() }};
                                addMessageToChat(msg, isMine);
                            });
                        })
                        .catch(error => {
                            console.error('Error loading messages:', error);
                            chatMessages.innerHTML =
                                '<div class="text-center text-red-400 mt-10">Gagal memuat riwayat pesan.</div>';
                        });
                }
            </script>
        </body>

        </html>
