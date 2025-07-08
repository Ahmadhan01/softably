@extends('layouts.sidebar')

@section('isi')
<div class="flex min-h-screen">
    <main class="flex w-full h-screen bg-[#0f172a] text-white ml-64">
        <div class="w-full md:w-1/4 xl:w-2/6 border-r border-gray-700 p-4 flex flex-col">
            <h1 class="text-2xl font-semibold mb-4">Chat Seller</h1>

            <div class="relative mb-4">
                <input type="text" placeholder="Search people" class="w-full bg-[#1e293b] text-white py-2 px-4 rounded focus:outline-none" id="chat-search-input" />
                <span class="absolute right-4 top-2 text-sm text-gray-400">All</span>
            </div>

            <ul class="space-y-3 overflow-y-auto flex-1 pr-2" id="conversation-list">
                {{-- Pisahkan percakapan yang belum dibaca dan sudah dibaca untuk pengurutan --}}
                @php
                    // Pastikan koleksi messages dimuat untuk filtering ini
                    $sortedConversations = $conversations->sortByDesc(function($conversation) {
                        return $conversation->messages->last() ? $conversation->messages->last()->created_at : null;
                    });
                @endphp

                @foreach ($sortedConversations as $conversation)
                    @php
                        $otherUser = ($conversation->user1_id === Auth::id()) ? $conversation->user2 : $conversation->user1;
                        $latestMessage = $conversation->messages->last();
                        // Pesan dianggap belum dibaca jika sender_id BUKAN user yang login DAN read_at is NULL
                        $isUnread = $latestMessage && $latestMessage->receiver_id === Auth::id() && is_null($latestMessage->read_at);
                        $isActive = isset($activeConversation) && $activeConversation->id === $conversation->id;
                    @endphp
                    <li class="flex items-center gap-3 cursor-pointer hover:bg-[#1e293b] p-2 rounded chat-item {{ $isActive ? 'active' : '' }}"
                        data-conversation-id="{{ $conversation->id }}"
                        data-other-user-id="{{ $otherUser->id }}"
                        data-other-user-name="{{ $otherUser->name ?? $otherUser->username }}"
                        data-is-unread="{{ $isUnread ? 'true' : 'false' }}"> {{-- Tambahkan data-is-unread --}}
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
                        {{-- Indikator pesan belum dibaca di item daftar chat --}}
                        @if ($isUnread)
                            <span class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 unread-dot"></span>
                        @endif
                    </li>
                @endforeach
                @if($availableUsersToChat->isNotEmpty())
                    <li class="text-center text-gray-500 mt-4 pt-4 border-t border-gray-700">Mulai Chat Baru</li>
                    @foreach($availableUsersToChat as $userToChat)
                        @php
                            $existingConversation = $conversations->first(function($conv) use ($userToChat) {
                                return ($conv->user1_id === Auth::id() && $conv->user2_id === $userToChat->id) ||
                                       ($conv->user1_id === $userToChat->id && $conv->user2_id === Auth::id());
                            });
                        @endphp
                        @if (!$existingConversation)
                            <li class="flex items-center gap-3 cursor-pointer hover:bg-[#1e293b] p-2 rounded new-chat-item"
                                data-other-user-id="{{ $userToChat->id }}"
                                data-other-user-name="{{ $userToChat->name ?? $userToChat->username }}">
                                <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-700 flex-shrink-0">
                                    <img src="{{ $userToChat->profile_picture_url }}" class="w-10 h-10 rounded-full object-cover" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-white truncate">
                                        {{ $userToChat->name ?? $userToChat->username }}</p>
                                    <p class="text-sm text-gray-500">Klik untuk chat...</p>
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>

        </div>

        <div class="flex-1 p-4 flex flex-col bg-[#0f172a]" id="chat-right-panel">
            <div class="flex-1 flex items-center justify-center text-gray-400 text-lg" id="chat-placeholder">
                Pilih percakapan untuk memulai chat.
            </div>
            <div class="hidden flex-col flex-1 h-full" id="chat-content">
                <div class="flex justify-between items-center border-b border-gray-700 pb-4" id="chat-header">
                    <div>
                        <p class="font-bold text-lg" id="active-chat-name">User</p>
                        <p class="text-sm text-gray-400" id="active-user-status">Offline</p> {{-- Status online/offline --}}
                    </div>
                </div>
                <div class="flex flex-col space-y-2 overflow-y-auto flex-1 pr-2 pt-3 pb-3" id="chat-messages-container"></div>
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
    </main>
</div>

@if(session('success_modal_data'))
<script>
    const modalData = @json(session('success_modal_data'));
    alert("Pembayaran berhasil! Order ID: " + modalData.order_id);
</script>
@endif


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

        // Fungsi untuk memperbarui status online/offline (Anda perlu API backend untuk ini)
        function updateOnlineStatus(userId, isOnline) {
            // Ini untuk status di header chat aktif
            if (activeOtherUserId === userId) {
                const statusElement = document.getElementById('active-user-status');
                statusElement.textContent = isOnline ? 'Online' : 'Offline';
                statusElement.classList.toggle('text-green-400', isOnline);
                statusElement.classList.toggle('text-gray-400', !isOnline);
            }
            // Ini untuk indikator online di daftar percakapan (jika ada)
            const listItem = document.querySelector(`#conversation-list li[data-other-user-id="${userId}"]`);
            if (listItem) {
                // Anda bisa menambahkan elemen status kecil di sini jika diinginkan
                // Contoh:
                // let onlineDot = listItem.querySelector('.online-dot');
                // if (!onlineDot) {
                //     onlineDot = document.createElement('span');
                //     onlineDot.classList.add('w-2', 'h-2', 'rounded-full', 'ml-auto', 'flex-shrink-0', 'online-dot');
                //     listItem.appendChild(onlineDot); // Atau masukkan di tempat yang lebih baik
                // }
                // onlineDot.classList.toggle('bg-green-500', isOnline);
                // onlineDot.classList.toggle('bg-gray-500', !isOnline);
            }
        }

        // Fungsi untuk menginisialisasi atau mengganti tampilan chat
        function initChat(conversationId, otherUserName, otherUserId) {
            activeConversationId = conversationId;
            activeOtherUserId = otherUserId;
            document.getElementById('chat-placeholder').classList.add('hidden');
            document.getElementById('chat-content').style.display = 'flex';
            document.getElementById('active-chat-name').textContent = otherUserName;

            // Dapatkan status online pengguna lain
            // Asumsi ada endpoint /api/user-status/{id}
            axios.get(`/api/user-status/${otherUserId}`) // Anda perlu membuat rute ini di backend
                .then(res => {
                    updateOnlineStatus(otherUserId, res.data.is_online);
                })
                .catch(error => {
                    console.error("Error fetching user status:", error);
                    updateOnlineStatus(otherUserId, false); // Default jika gagal
                });

            loadMessages(conversationId);
            markConversationAsRead(conversationId); // Tandai pesan sebagai telah dibaca saat chat dibuka
        }

        // Fungsi untuk memuat pesan
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
                        
                        // Periksa apakah pesan ini adalah pesan yang DITERIMA oleh pengguna yang sedang login
                        // dan apakah pesan tersebut sudah dibaca.
                        const isMessageReceivedAndUnread = (msg.receiver_id === authUserId && msg.read_at === null);

                        if (msg.sender_id === authUserId) {
                             bubble.classList.add('bg-blue-600', 'self-end');
                             // Untuk pesan yang dikirim sendiri, tidak perlu opacity berdasarkan read_at
                             // Anda bisa menambahkan indikator "terbaca" jika diinginkan
                             bubble.innerHTML = `<p class='text-sm text-white'>${msg.content}</p><span class='text-xs text-blue-200 block text-right mt-1'>${new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>`;
                        } else {
                             bubble.classList.add('bg-[#1e293b]', 'self-start');
                             // Opacity 1 untuk belum dibaca, 0.8 untuk sudah dibaca
                             bubble.style.opacity = isMessageReceivedAndUnread ? '1' : '0.8';
                             bubble.innerHTML = `<p class='font-semibold text-xs text-gray-300 mb-1'>${msg.sender.name ?? msg.sender.username}</p><p class='text-sm text-gray-200'>${msg.content}</p><span class='text-xs text-gray-400 block mt-1'>${new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>`;
                        }
                        container.appendChild(bubble);
                    });
                    container.scrollTop = container.scrollHeight;
                })
                .catch(error => {
                    console.error("Error loading messages:", error);
                });
        }

        // Fungsi untuk menandai SEMUA pesan dalam percakapan sebagai sudah dibaca
        function markConversationAsRead(conversationId) {
            axios.post(`/api/chat/mark-as-read/${conversationId}`) // Rute API baru
                .then(res => {
                    // console.log('Conversation marked as read:', res.data);
                    // Setelah pesan ditandai dibaca, perbarui tampilan di sidebar
                    const item = document.querySelector(`.chat-item[data-conversation-id="${conversationId}"]`);
                    if (item) {
                        // Hapus indikator belum dibaca
                        item.dataset.isUnread = 'false'; // Update data attribute
                        const unreadDot = item.querySelector('.unread-dot');
                        if (unreadDot) {
                            unreadDot.remove();
                        }
                        const messageContent = item.querySelector('.message-content');
                        if (messageContent) {
                            messageContent.classList.remove('text-blue-400', 'font-bold');
                            messageContent.classList.add('text-gray-400');
                        }
                        // Jika Anda punya opacity di daftar chat, set kembali ke normal atau 0.8
                        // item.style.opacity = '0.8';
                    }
                    // Perbarui badge notifikasi di sidebar utama
                    if (window.updateChatBadge) {
                        window.updateChatBadge();
                    }
                })
                .catch(error => {
                    console.error("Error marking conversation as read:", error);
                });
        }

        // Event listener untuk item chat yang sudah ada
        document.querySelectorAll('.chat-item').forEach(item => {
            item.addEventListener('click', function() { // Gunakan function biasa agar 'this' merujuk ke elemen
                const conversationId = this.dataset.conversationId;
                const otherUserName = this.dataset.otherUserName;
                const otherUserId = this.dataset.otherUserId;
                initChat(conversationId, otherUserName, otherUserId);

                // Hapus kelas 'active' dari semua item dan tambahkan ke item yang diklik
                document.querySelectorAll('.chat-item').forEach(li => li.classList.remove('active'));
                this.classList.add('active'); // Gunakan 'this'
            });
        });

        // Event listener untuk memulai chat baru
        document.querySelectorAll('.new-chat-item').forEach(item => {
            item.addEventListener('click', function() {
                const otherUserId = this.dataset.otherUserId;
                const otherUserName = this.dataset.otherUserName;
                axios.post('/chat/create-or-get-conversation', {
                    other_user_id: otherUserId
                }).then(res => {
                    initChat(res.data.conversation_id, otherUserName, otherUserId);
                    // Untuk kemudahan, refresh halaman untuk melihat percakapan baru di daftar
                    // Di produksi, Anda mungkin ingin menambahkannya secara dinamis ke conversation-list
                    location.reload();
                }).catch(error => {
                    console.error("Error creating new conversation:", error);
                    alert('Gagal memulai chat baru: ' + (error.response.data.message || error.message));
                });
            });
        });

        // Event listener untuk tombol kirim pesan
        document.getElementById('send-message-btn').addEventListener('click', () => {
            const input = document.getElementById('message-input');
            const message = input.value.trim();
            if (!message || !activeConversationId) return;

            axios.post(`/chat/send/${activeConversationId}`, {
                content: message
            }).then(() => {
                input.value = '';
                loadMessages(activeConversationId); // Muat ulang pesan setelah mengirim
                // Opsional: Jika Anda ingin langsung melihat pesan Anda di daftar chat
                // Anda bisa mengupdate pratinjau pesan terakhir di elemen sidebar tanpa refresh
                // Namun, untuk kesederhanaan, reload halaman untuk update daftar percakapan adalah cara termudah saat ini.
            }).catch(error => {
                console.error("Error sending message:", error);
                alert('Gagal mengirim pesan.');
            });
        });

        // Event listener untuk mengirim pesan dengan Enter
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
                // Pastikan item bukan "Mulai Chat Baru" divider
                if (item.classList.contains('text-center')) {
                    return;
                }
                const userName = item.querySelector('.font-semibold').textContent.toLowerCase();
                const messagePreview = item.querySelector('.message-content') ? item.querySelector('.message-content').textContent.toLowerCase() : '';
                if (userName.includes(searchTerm) || messagePreview.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Laravel Echo Listener untuk pesan baru
        window.Echo.private(`chat.${authUserId}`)
            .listen('NewChatMessage', (e) => {
                // Periksa apakah pesan masuk ke percakapan yang sedang aktif
                if (e.message.conversation_id == activeConversationId) {
                    loadMessages(activeConversationId); // Muat ulang pesan untuk percakapan aktif
                    // Tidak perlu markAsRead di sini karena akan dipanggil saat initChat atau ketika user mengklik.
                    // Namun, jika ingin pesan segera ditandai begitu diterima di chat aktif:
                    // markConversationAsRead(activeConversationId);
                } else {
                    // Jika pesan masuk ke percakapan lain, perbarui tampilan di sidebar
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
                        // Tambahkan/tampilkan unread dot
                        let unreadDot = conversationItem.querySelector('.unread-dot');
                        if (!unreadDot) {
                            unreadDot = document.createElement('span');
                            unreadDot.classList.add('w-2', 'h-2', 'bg-blue-500', 'rounded-full', 'flex-shrink-0', 'unread-dot');
                            conversationItem.appendChild(unreadDot); // Tambahkan di akhir item
                        }
                        conversationItem.dataset.isUnread = 'true'; // Set data attribute
                        // Pindahkan item ke paling atas jika ini adalah pesan yang diterima
                        // Dan jika pengirim pesan bukan user yang sedang login
                        if (e.message.sender_id !== authUserId) {
                            const parentList = document.getElementById('conversation-list');
                            parentList.prepend(conversationItem);
                        }
                    } else {
                        // Jika percakapan belum ada di sidebar (misal, baru dibuat oleh orang lain)
                        // Untuk kasus ini, refresh halaman adalah cara termudah untuk memuat percakapan baru.
                        location.reload();
                    }
                }
                // Selalu perbarui badge notifikasi di sidebar utama
                if (window.updateChatBadge) {
                    window.updateChatBadge();
                }
            });

        // Listener untuk status online/offline
        // Pastikan Anda telah mengonfigurasi Laravel Echo untuk join channel 'presence-online-users'
        // dan server Anda me-broadcast event PresenceChannel (join/leaving)
        window.Echo.join('presence-online-users')
            .here((users) => {
                users.forEach(user => {
                    updateOnlineStatus(user.id, true);
                });
            })
            .joining((user) => {
                updateOnlineStatus(user.id, true);
            })
            .leaving((user) => {
                updateOnlineStatus(user.id, false);
            })
            .error((error) => {
                console.error("Presence Channel Error:", error);
            });

        // Panggil initChat jika ada conversation yang sudah aktif dari blade (misal setelah reload dengan error)
        @if(isset($activeConversation) && $activeConversation)
            const initialConversationId = {{ $activeConversation->id }};
            const initialOtherUserName = "{{ ($activeConversation->user1_id === Auth::id() ? $activeConversation->user2 : $activeConversation->user1)->name ?? ($activeConversation->user1_id === Auth::id() ? $activeConversation->user2 : $activeConversation->user1)->username }}";
            const initialOtherUserId = {{ ($activeConversation->user1_id === Auth::id() ? $activeConversation->user2 : $activeConversation->user1)->id }};
            initChat(initialConversationId, initialOtherUserName, initialOtherUserId);
        @endif
    });
</script>
@endsection