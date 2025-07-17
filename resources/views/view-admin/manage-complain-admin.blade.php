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
                        <ul id="userList" class="space-y-3 overflow-y-auto max-h-[calc(100vh-200px)] pr-2">
                            <!-- Diisi lewat JavaScript -->
                            <li class="p-2 text-gray-400">Loading users...</li>
                        </ul>
                    </div>

                    <!-- Chat Content -->
                    <div class="flex-1 p-4 space-y-6 flex flex-col bg-[#0f172a]">
                        <!-- Chat Header -->
                        <div class="flex justify-between items-center border-b border-gray-700 pb-4">
                            <div>
                                <p id="chat-user-name" class="font-bold text-lg">Pilih User</p>
                                <p class="text-sm text-gray-400">Riwayat Percakapan</p>
                            </div>
                        </div>

                        <!-- Chat Messages -->
                        <div id="chat-messages"
                            class="flex flex-col space-y-4 overflow-y-auto max-h-[calc(100vh-300px)] pr-2">
                            <!-- Diisi lewat JavaScript -->
                            <div class="text-center text-gray-500 mt-10">Pilih user dari daftar untuk memulai chat.
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
                let selectedUserId = null;
                const replyInput = document.getElementById('adminReplyInput');
                const sendBtn = document.getElementById('adminSendBtn');
                const chatMessages = document.getElementById('chat-messages');
                const chatUserName = document.getElementById('chat-user-name');

                // Variabel untuk menyimpan channel Pusher yang sedang aktif
                let currentPusherChannel = null;

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

                function sendMessageToUser() {
                    const msg = replyInput.value.trim();
                    if (!msg || !selectedUserId) return;

                    fetch(`/admin/chat/send/${selectedUserId}`, {
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
                            // Tambahkan pesan yang baru dikirim ke tampilan chat
                            addMessageToChat(data, true); // true karena ini pesan yang dikirim admin
                            replyInput.value = '';
                        })
                        .catch(error => {
                            alert("Gagal mengirim pesan: " + error.message);
                            console.error(error);
                        });
                }

                sendBtn?.addEventListener('click', sendMessageToUser);
                replyInput?.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        sendMessageToUser();
                    }
                });

                document.addEventListener('DOMContentLoaded', function() {
                    // Subscribe ke channel admin untuk menerima pesan dari semua user
                    const adminChannel = pusher.subscribe(`chat.{{ auth()->id() }}`);
                    adminChannel.bind('MessageSent', function(data) {
                        // Jika pesan diterima oleh admin yang sedang login DAN pengirimnya BUKAN admin itu sendiri
                        // Ini berarti pesan datang dari customer atau seller
                        if (data.receiver_id === {{ auth()->id() }} && data.sender_id !== {{ auth()->id() }}) {
                            // Jika pesan datang dari user yang sedang dipilih, tampilkan langsung di chat
                            if (selectedUserId === data.sender_id) {
                                addMessageToChat(data, false); // false karena ini pesan dari user lain
                            }
                            // Selalu update notifikasi di sidebar atau badge
                            updateChatNotification(data);
                        }
                    });

                    fetch('/admin/chat/users')
                        .then(res => res.json())
                        .then(data => {
                            const list = document.getElementById('userList');
                            list.innerHTML = '';
                            if (data.length === 0) {
                                list.innerHTML =
                                    '<li class="p-2 text-gray-400">Tidak ada user yang pernah chat.</li>';
                            }
                            data.forEach(user => {
                                const li = document.createElement('li');
                                li.textContent = `${user.name} (${user.role})`;
                                li.className =
                                    "p-2 hover:bg-gray-700 cursor-pointer rounded-md transition-colors";
                                li.dataset.userId = user.id;
                                li.dataset.userName = user.name; // Simpan nama user
                                li.dataset.userRole = user.role; // Simpan role user

                                // Tambahkan badge notifikasi untuk setiap user
                                const notificationBadge = document.createElement('span');
                                notificationBadge.className =
                                    'ml-2 px-2 py-1 text-xs font-bold text-red-100 bg-red-600 rounded-full hidden';
                                notificationBadge.id = `badge-${user.id}`;
                                li.appendChild(notificationBadge);

                                li.addEventListener('click', () => {
                                    document.querySelectorAll('#userList li').forEach(
                                        item => {
                                            item.classList.remove('bg-blue-700');
                                        });
                                    li.classList.add('bg-blue-700');

                                    selectedUserId = user.id;
                                    chatUserName.innerText =
                                        `${user.name} (${user.role})`;
                                    replyInput.disabled = false;
                                    sendBtn.disabled = false;
                                    loadMessagesForUser(selectedUserId);

                                    // Sembunyikan badge notifikasi saat chat dibuka
                                    const currentBadge = document.getElementById(
                                        `badge-${selectedUserId}`);
                                    if (currentBadge) {
                                        currentBadge.classList.add('hidden');
                                        currentBadge.textContent = '';
                                    }
                                });
                                list.appendChild(li);
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching user list:', error);
                            document.getElementById('userList').innerHTML =
                                '<li class="p-2 text-red-400">Gagal memuat daftar user.</li>';
                        });
                });


                function loadMessagesForUser(id) {
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
                                    '<div class="text-center text-gray-500 mt-10">Belum ada percakapan dengan user ini.</div>';
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

                // Fungsi untuk mengupdate notifikasi chat di sidebar
                function updateChatNotification(messageData) {
                    const senderId = messageData.sender_id;
                    const senderName = messageData.sender_name || `User ID ${senderId}`; // Ambil nama jika tersedia
                    const senderRole = messageData.sender_role || 'Unknown Role'; // Ambil role jika tersedia

                    const userListItem = document.querySelector(`#userList li[data-user-id="${senderId}"]`);
                    if (userListItem) {
                        const notificationBadge = document.getElementById(`badge-${senderId}`);
                        if (notificationBadge) {
                            let currentCount = parseInt(notificationBadge.textContent) || 0;
                            notificationBadge.textContent = currentCount + 1;
                            notificationBadge.classList.remove('hidden');
                        }
                        // Pindahkan user ke paling atas daftar
                        userListItem.parentNode.prepend(userListItem);
                    } else {
                        // Jika user belum ada di daftar (misal, chat pertama kali)
                        // Anda bisa menambahkan user baru ke daftar di sini
                        console.log(`Pesan baru dari user ${senderName} (${senderRole}) yang belum ada di daftar.`);
                        // Opsional: fetch ulang daftar user atau tambahkan secara dinamis
                        // Untuk saat ini, kita hanya log
                    }
                }

                // Tambahkan di dalam script admin chat
                function updateChatBadge(count) {
                    const badge = document.getElementById('chatNotificationBadge');
                    if (badge) {
                        if (count > 0) {
                            badge.textContent = count;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    }
                }

                channel.bind('MessageSent', function(data) {
                    // Update badge counter
                    updateSidebarBadge(data.unread_count);

                    // Update unread count di chat list
                    const userBadge = document.getElementById(`user-badge-${data.sender_id}`);
                    if (userBadge) {
                        const currentCount = parseInt(userBadge.textContent) || 0;
                        userBadge.textContent = currentCount + 1;
                        userBadge.classList.remove('hidden');
                    }
                });
            </script>
        </body>

        </html>
