@extends('layouts.sidebar-seller')

@section('isi')
{{-- Hapus div flex min-h-screen karena sudah ditangani oleh sidebar-seller.blade.php --}}
{{-- Main tag sekarang akan diatur oleh layout parent (sidebar-seller) --}}
{{-- Class 'ml-64' di main dihapus, karena sudah diatur oleh flex-1 di parent --}}
<div class="flex w-full h-[calc(100vh-2.5rem)] bg-[#0f172a] text-white"> {{-- Gunakan h-[calc(100vh-padding)] --}}
    <div class="w-full md:w-1/4 xl:w-2/6 border-r border-gray-700 p-4 flex flex-col">
        <h1 class="text-2xl font-semibold mb-4">Chat Customer</h1>

        <div class="relative mb-4">
            <input type="text" placeholder="Search people" class="w-full bg-[#1e293b] text-white py-2 px-4 rounded focus:outline-none" id="chat-search-input" />
            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-gray-400">All</span> {{-- Posisikan "All" lebih baik --}}
        </div>

        <ul class="space-y-3 overflow-y-auto flex-1 pr-2" id="conversation-list">
            {{-- Pisahkan percakapan yang belum dibaca dan sudah dibaca untuk pengurutan --}}
            @php
                $unreadConversations = $conversations->filter(function($conversation) {
                    $latestMessage = $conversation->messages->last();
                    return $latestMessage && $latestMessage->sender_id !== Auth::id() && is_null($latestMessage->read_at);
                })->sortByDesc(function($conversation) {
                    return $conversation->messages->last() ? $conversation->messages->last()->created_at : null;
                });

                $readConversations = $conversations->filter(function($conversation) {
                    $latestMessage = $conversation->messages->last();
                    return !$latestMessage || $latestMessage->sender_id === Auth::id() || !is_null($latestMessage->read_at);
                })->sortByDesc(function($conversation) {
                    return $conversation->messages->last() ? $conversation->messages->last()->created_at : null;
                });

                $sortedConversations = $unreadConversations->merge($readConversations);
            @endphp

            {{-- Tampilkan percakapan yang belum dibaca terlebih dahulu --}}
            @foreach ($sortedConversations as $conversation)
                @php
                    $otherUser = ($conversation->user1_id === Auth::id()) ? $conversation->user2 : $conversation->user1;
                    $latestMessage = $conversation->messages->last();
                    $isActive = isset($activeConversation) && $activeConversation->id === $conversation->id;
                    $isUnread = $latestMessage && $latestMessage->sender_id !== Auth::id() && is_null($latestMessage->read_at);
                @endphp
                <li class="flex items-center gap-3 cursor-pointer hover:bg-[#1e293b] p-2 rounded chat-item {{ $isActive ? 'active' : '' }}"
                    data-conversation-id="{{ $conversation->id }}"
                    data-other-user-id="{{ $otherUser->id }}"
                    data-other-user-name="{{ $otherUser->name ?? $otherUser->username }}"
                    style="opacity: {{ $isUnread ? '1' : '0.8' }};"> {{-- Opacity berdasarkan status baca --}}
                    <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-700 flex-shrink-0">
                        <img src="{{ $otherUser->profile_picture_url }}" class="w-10 h-10 rounded-full object-cover" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-white truncate">{{ $otherUser->name ?? $otherUser->username }}</p>
                        <p class="text-sm {{ $isUnread ? 'text-blue-400 font-bold' : 'text-gray-400' }} truncate message-content">
                            {{ $latestMessage ? Str::limit($latestMessage->content, 30) : 'Mulai percakapan baru...' }}
                        </p>
                    </div>
                    <span class="text-xs text-gray-400 message-time">
                        {{ $latestMessage ? $latestMessage->created_at->format('H:i') : '' }}
                    </span>
                </li>
            @endforeach
            @foreach ($availableUsersToChat as $userToChat)
                @php
                    // Cek apakah sudah ada percakapan dengan user ini
                    $existingConversation = $conversations->first(function($conv) use ($userToChat) {
                        return ($conv->user1_id === Auth::id() && $conv->user2_id === $userToChat->id) ||
                               ($conv->user1_id === $userToChat->id && $conv->user2_id === Auth::id());
                    });
                @endphp
                @if (!$existingConversation)
                    <li class="new-chat-item p-2 rounded hover:bg-[#1e293b] cursor-pointer"
                        data-other-user-id="{{ $userToChat->id }}"
                        data-other-user-name="{{ $userToChat->name ?? $userToChat->username }}">
                        <div class="flex gap-3 items-center">
                            <img src="{{ $userToChat->profile_picture_url }}" class="w-10 h-10 rounded-full object-cover" />
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-white truncate">{{ $userToChat->name ?? $userToChat->username }}</p>
                                <p class="text-sm text-gray-500">Klik untuk chat...</p>
                            </div>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    <div class="flex-1 p-4 flex flex-col bg-[#0f172a]" id="chat-right-panel">
        <div class="flex-1 flex items-center justify-center text-gray-400 text-lg" id="chat-placeholder">
            Pilih percakapan untuk memulai chat.
        </div>
        <div class="hidden flex-col flex-1 h-full" id="chat-content">
            <div class="flex justify-between items-center border-b border-gray-700 pb-4 mb-4" id="chat-header"> {{-- Tambahkan mb-4 --}}
                <div>
                    <p class="font-bold text-lg" id="active-chat-name">User</p>
                    <p class="text-sm text-gray-400" id="active-user-status">Offline</p> {{-- Status online/offline --}}
                </div>
            </div>
            <div class="flex flex-col space-y-2 overflow-y-auto flex-1 pr-2 pb-3" id="chat-messages-container"></div> {{-- Hapus pt-3, biarkan padding dari parent --}}
            <div class="mt-auto pt-4 border-t border-gray-700"> {{-- Pastikan input pesan selalu di bawah --}}
                <div class="flex gap-2">
                    <input type="text" placeholder="Ketik pesan..." class="flex-1 px-4 py-2 bg-[#1e293b] text-white rounded focus:outline-none" id="message-input" />
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded" id="send-message-btn">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script> {{-- Tambahkan Pusher JS --}}
<script src="{{ asset('js/app.js') }}"></script> {{-- Pastikan Laravel Echo sudah di-setup di app.js --}}

<script>
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.addEventListener('DOMContentLoaded', function () {
        const authUserId = {{ Auth::id() }};
        let activeConversationId = null;
        let activeOtherUserId = null; // Untuk melacak ID pengguna lain yang sedang aktif chat

        // Fungsi untuk memperbarui status online/offline
        function updateOnlineStatus(userId, isOnline) {
            const statusElement = document.querySelector(`#conversation-list li[data-other-user-id="${userId}"] .online-status`);
            if (statusElement) {
                statusElement.textContent = isOnline ? 'Online' : 'Offline';
                statusElement.classList.toggle('text-green-400', isOnline);
                statusElement.classList.toggle('text-gray-400', !isOnline);
            }
            // Update status di panel chat kanan jika pengguna sedang aktif
            if (activeOtherUserId === userId) {
                document.getElementById('active-user-status').textContent = isOnline ? 'Online' : 'Offline';
                document.getElementById('active-user-status').classList.toggle('text-green-400', isOnline);
                document.getElementById('active-user-status').classList.toggle('text-gray-400', !isOnline);
            }
        }

        function initChat(conversationId, otherUserName, otherUserId) {
            activeConversationId = conversationId;
            activeOtherUserId = otherUserId; // Set ID pengguna lain yang aktif
            document.getElementById('chat-placeholder').classList.add('hidden');
            document.getElementById('chat-content').classList.remove('hidden');
            document.getElementById('active-chat-name').textContent = otherUserName;

            // Dapatkan status online pengguna lain
            axios.get(`/chat/status/${otherUserId}`)
                .then(res => {
                    updateOnlineStatus(otherUserId, res.data.is_online); // Gunakan fungsi updateOnlineStatus
                })
                .catch(error => {
                    console.error("Error fetching user status:", error);
                    updateOnlineStatus(otherUserId, false); // Default jika gagal
                });

            loadMessages(conversationId);
            markAsRead(conversationId); // Tandai pesan sebagai telah dibaca saat chat dibuka
        }

        function loadMessages(conversationId) {
            axios.get(`/chat/messages/${conversationId}`)
                .then(res => {
                    const container = document.getElementById('chat-messages-container');
                    container.innerHTML = '';
                    let lastDate = null;

                    res.data.messages.forEach(msg => {
                        const msgDate = new Date(msg.created_at).toLocaleDateString();
                        if (msgDate !== lastDate) {
                            lastDate = msgDate;
                            const dateBubble = document.createElement('div');
                            dateBubble.classList.add('text-center', 'text-sm', 'text-gray-400', 'my-2');
                            dateBubble.textContent = msgDate;
                            container.appendChild(dateBubble);
                        }

                        const bubble = document.createElement('div');
                        bubble.classList.add('p-3', 'rounded-lg', 'max-w-[70%]', 'break-words');
                        // Opacity untuk bubble chat tergantung sudah dibaca atau belum (jika pesan ini milik penerima)
                        // Karena ini chat-seller, pesan yang dikirim seller akan selalu 'terlihat', pesan dari customer bisa punya status read_at
                        if (msg.sender_id === authUserId) {
                             bubble.classList.add('bg-blue-600', 'self-end');
                             // Untuk pesan yang dikirim sendiri, tidak perlu opacity berdasarkan read_at
                        } else {
                             bubble.classList.add('bg-[#1e293b]', 'self-start');
                             bubble.style.opacity = msg.read_at ? '0.8' : '1';
                        }


                        if (msg.sender_id === authUserId) {
                            bubble.innerHTML = `<p class='text-sm text-white'>${msg.content}</p><span class='text-xs text-blue-200 block text-right mt-1'>${new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>`;
                        } else {
                            bubble.innerHTML = `<p class='font-semibold text-xs text-gray-300 mb-1'>${msg.sender.name ?? msg.sender.username}</p><p class='text-sm text-gray-200'>${msg.content}</p><span class='text-xs text-gray-400 block mt-1'>${new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>`;
                        }

                        container.appendChild(bubble);
                    });
                    container.scrollTop = container.scrollHeight; // Scroll ke bawah setelah memuat pesan
                })
                .catch(error => {
                    console.error("Error loading messages:", error);
                });
        }

        // Fungsi untuk menandai pesan sebagai sudah dibaca
        function markAsRead(conversationId) {
            axios.post(`/chat/read/${conversationId}`)
                .then(res => {
                    // console.log('Messages marked as read:', res.data);
                    // Setelah pesan ditandai dibaca, perbarui opacity di sidebar
                    const item = document.querySelector(`.chat-item[data-conversation-id="${conversationId}"]`);
                    if (item) {
                        item.style.opacity = '0.8'; // Set opacity ke 80%
                        const messageContent = item.querySelector('.message-content');
                        if (messageContent) {
                            messageContent.classList.remove('text-blue-400', 'font-bold');
                            messageContent.classList.add('text-gray-400');
                        }
                    }
                })
                .catch(error => {
                    console.error("Error marking messages as read:", error);
                });
        }

        document.querySelectorAll('.chat-item').forEach(item => {
            item.addEventListener('click', () => {
                const conversationId = item.dataset.conversationId;
                const otherUserName = item.dataset.otherUserName;
                const otherUserId = item.dataset.otherUserId;
                initChat(conversationId, otherUserName, otherUserId);

                // Hapus kelas 'active' dari semua item dan tambahkan ke item yang diklik
                document.querySelectorAll('.chat-item').forEach(li => li.classList.remove('active'));
                item.classList.add('active');
            });
        });

        document.querySelectorAll('.new-chat-item').forEach(item => {
            item.addEventListener('click', () => {
                const otherUserId = item.dataset.otherUserId;
                const otherUserName = item.dataset.otherUserName;
                axios.post('/chat/create-or-get-conversation', {
                    other_user_id: otherUserId
                }).then(res => {
                    initChat(res.data.conversation_id, otherUserName, otherUserId);
                    // Mungkin perlu menambahkan item baru ini ke daftar percakapan dan mengurutkannya
                    location.reload(); // Untuk kemudahan, refresh halaman untuk melihat percakapan baru di daftar
                }).catch(error => {
                    console.error("Error creating new conversation:", error);
                });
            });
        });

        document.getElementById('send-message-btn').addEventListener('click', () => {
            const input = document.getElementById('message-input');
            const message = input.value.trim();
            if (!message || !activeConversationId) return;

            axios.post(`/chat/send/${activeConversationId}`, {
                content: message
            }).then(() => {
                loadMessages(activeConversationId);
                input.value = '';
            }).catch(error => {
                console.error("Error sending message:", error);
            });
        });

        document.getElementById('message-input').addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                document.getElementById('send-message-btn').click();
            }
        });

        // Search functionality
        document.getElementById('chat-search-input').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            document.querySelectorAll('#conversation-list > li').forEach(item => {
                const userName = item.querySelector('.font-semibold').textContent.toLowerCase();
                const messagePreview = item.querySelector('.message-content') ? item.querySelector('.message-content').textContent.toLowerCase() : '';
                if (userName.includes(searchTerm) || messagePreview.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Laravel Echo Listener
        // Menggunakan private channel 'chat.{userId}'
        window.Echo.private(`chat.${authUserId}`)
            .listen('NewChatMessage', (e) => {
                // Periksa apakah pesan masuk ke percakapan yang sedang aktif
                if (e.message.conversation_id == activeConversationId) {
                    loadMessages(activeConversationId); // Muat ulang pesan untuk percakapan aktif
                    markAsRead(activeConversationId); // Tandai sebagai sudah dibaca secara otomatis
                } else {
                    // Jika pesan masuk ke percakapan lain, perbarui sidebar
                    const conversationItem = document.querySelector(`.chat-item[data-conversation-id="${e.message.conversation_id}"]`);
                    if (conversationItem) {
                        // Perbarui pratinjau pesan dan waktu
                        const messageContent = conversationItem.querySelector('.message-content');
                        if (messageContent) {
                            messageContent.textContent = `Pesan baru: ${e.message.content.substring(0, 30)}...`;
                            messageContent.classList.add('text-blue-400', 'font-bold'); // Tandai sebagai belum dibaca
                        }
                        const messageTime = conversationItem.querySelector('.message-time');
                        if (messageTime) {
                            messageTime.textContent = new Date(e.message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        }
                        conversationItem.style.opacity = '1'; // Set opacity ke 100%
                        // Pindahkan item ke atas
                        const parentList = document.getElementById('conversation-list');
                        parentList.prepend(conversationItem);
                    } else {
                        // Jika percakapan belum ada di sidebar (misal, baru dibuat oleh orang lain)
                        // Anda mungkin perlu membuat AJAX call untuk mendapatkan data percakapan baru
                        // Untuk saat ini, refresh halaman sederhana bisa digunakan (bukan real-time yang ideal)
                        location.reload();
                    }
                }
            });

        // Listener untuk status online/offline (Anda perlu implementasikan event ini di backend)
        window.Echo.join('presence-online-users') // Sesuaikan nama channel presence Anda
            .here((users) => {
                // console.log("Current online users:", users);
                users.forEach(user => {
                    updateOnlineStatus(user.id, true);
                });
            })
            .joining((user) => {
                // console.log(user.name + ' bergabung.');
                updateOnlineStatus(user.id, true);
            })
            .leaving((user) => {
                // console.log(user.name + ' keluar.');
                updateOnlineStatus(user.id, false);
            })
            .error((error) => {
                console.error(error);
            });
    });
</script>
@endsection