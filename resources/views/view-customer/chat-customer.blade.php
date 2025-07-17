@extends('layouts.sidebar')

@section('isi')
<div class="flex h-screen w-full"> {{-- Tambahkan w-full di sini --}}
    {{-- Main akan mengisi sisa lebar setelah sidebar (ml-64) dan mengambil sisa tinggi dari h-screen --}}
    <main class="flex flex-grow bg-[#F8FAFC] text-[#333333] ml-64"> 
        {{-- Panel kiri chat (daftar percakapan) --}}
        {{-- Kelas ini menentukan lebar panel kiri pada berbagai breakpoint --}}
        <div class="w-full md:w-1/4 xl:w-2/6 border-r border-gray-200 p-4 flex flex-col bg-white shadow-md">
            <h1 class="text-2xl font-semibold text-gray-800 mb-4">Chat Seller</h1>

            <div class="relative mb-4">
                <input type="text" placeholder="Search people" class="w-full bg-gray-100 text-gray-800 py-2 px-4 rounded focus:outline-none border border-gray-300" id="chat-search-input" />
                <span class="absolute right-4 top-2 text-sm text-gray-500">All</span>
            </div>

            <ul class="space-y-3 overflow-y-auto flex-1 pr-2" id="conversation-list">
                @php
                    // Pastikan conversations sudah diurutkan berdasarkan is_pinned di controller
                    // Jika belum, Anda bisa tambahkan orderBy('is_pinned', 'desc') di query controller
                    // atau lakukan pengurutan di sini (kurang efisien untuk data besar)
                    // Gunakan optional() untuk menghindari error jika messages kosong
                    $sortedConversations = $conversations->sortByDesc(function($conversation) {
                        return $conversation->is_pinned ? 2 : (optional($conversation->messages->last())->created_at ? optional($conversation->messages->last())->created_at->timestamp : 1);
                    });
                @endphp

                @foreach ($sortedConversations as $conversation)
                    @php
                        $otherUser = ($conversation->user1_id === Auth::id()) ? $conversation->user2 : $conversation->user1;
                        $latestMessage = optional($conversation->messages->last()); // Gunakan optional() di sini juga
                        $isUnread = $latestMessage && $latestMessage->receiver_id === Auth::id() && is_null($latestMessage->read_at);
                        $isActive = isset($activeConversation) && $activeConversation->id === $conversation->id;
                    @endphp
                    <li class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 p-2 rounded chat-item {{ $isActive ? 'active' : '' }} {{ $conversation->is_pinned ? 'pinned-chat' : '' }}"
                        data-conversation-id="{{ $conversation->id }}"
                        data-other-user-id="{{ $otherUser->id }}"
                        data-other-user-name="{{ $otherUser->name ?? $otherUser->username }}"
                        data-is-unread="{{ $isUnread ? 'true' : 'false' }}">
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200 flex-shrink-0">
                            <img src="{{ $otherUser->profile_picture_url }}" class="w-10 h-10 rounded-full object-cover" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 truncate">
                                {{ $otherUser->name ?? $otherUser->username }}
                                @if ($conversation->is_pinned) {{-- TAMBAHKAN KONDISI INI --}}
                                    <i class="fa-solid fa-thumbtack text-gray-500 text-xs ml-1"></i> {{-- ICON PIN --}}
                                @endif
                            </p>
                            <p class="text-sm {{ $isUnread ? 'text-[#2563EB] font-bold' : 'text-gray-500' }} truncate message-content">
                                {{ $latestMessage->content ? Str::limit($latestMessage->content, 30) : 'Mulai percakapan baru...' }}
                            </p>
                        </div>
                        <span class="text-xs text-gray-400 message-time">
                            {{ $latestMessage->created_at ? $latestMessage->created_at->format('H:i') : '' }}
                        </span>
                        @if ($isUnread)
                            <span class="w-2 h-2 bg-[#2563EB] rounded-full flex-shrink-0 unread-dot"></span>
                        @endif
                        {{-- Icon Tiga Titik untuk Context Menu --}}
                        <div class="relative flex-shrink-0 ml-auto context-menu-trigger p-1 rounded-full hover:bg-gray-200">
                            <i class="fas fa-ellipsis-v text-gray-500 text-sm"></i>
                        </div>
                    </li>
                @endforeach
                @if($availableUsersToChat->isNotEmpty())
                    <li class="text-center text-gray-600 mt-4 pt-4 border-t border-gray-300">Mulai Chat Baru</li>
                    @foreach($availableUsersToChat as $userToChat)
                        @php
                            $existingConversation = $conversations->first(function($conv) use ($userToChat) {
                                return ($conv->user1_id === Auth::id() && $conv->user2_id === $userToChat->id) ||
                                       ($conv->user1_id === $userToChat->id && $conv->user2_id === $userToChat->id);
                            });
                        @endphp
                        @if (!$existingConversation)
                            <li class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 p-2 rounded new-chat-item"
                                data-other-user-id="{{ $userToChat->id }}"
                                data-other-user-name="{{ $userToChat->name ?? $userToChat->username }}">
                                <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200 flex-shrink-0">
                                    <img src="{{ $userToChat->profile_picture_url }}" class="w-10 h-10 rounded-full object-cover" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-800 truncate">
                                        {{ $userToChat->name ?? $userToChat->username }}</p>
                                    <p class="text-sm text-gray-500">Klik untuk chat...</p>
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>

        </div>

        {{-- Ini div panel kanan chat --}}
        {{-- Pastikan ini mengisi sisa lebar secara penuh --}}
        <div class="flex-1 p-4 flex flex-col bg-[#F8FAFC]" id="chat-right-panel">
            <div class="flex-1 flex items-center justify-center text-gray-600 text-lg" id="chat-placeholder">
                Pilih percakapan untuk memulai chat.
            </div>
            {{-- Tambahkan flex-1 pada div ini agar konten chatnya mengisi ruang yang tersedia --}}
            <div class="hidden flex-col flex-1 h-full" id="chat-content">
                <div class="flex justify-between items-center pb-4" id="chat-header">
                    <div>
                        <p class="font-bold text-lg text-gray-800" id="active-chat-name">User</p>
                        <p class="text-sm text-gray-500" id="active-user-status">Offline</p>
                    </div>
                </div>
                {{-- Pastikan container pesan juga flex-1 agar pesan bisa discroll dan mengisi ruang --}}
                <div class="flex flex-col space-y-2 overflow-y-auto flex-1 pr-2 pt-3 pb-3" id="chat-messages-container"></div>
                <div class="mt-auto pt-4 border-t border-gray-300">
                    <div class="flex gap-2">
                        <input type="text" placeholder="Ketik pesan..." class="flex-1 px-4 py-2 bg-gray-100 text-gray-800 rounded focus:outline-none border border-gray-300" id="message-input" />
                        <button class="bg-[#2563EB] hover:bg-[#3B82F6] text-white px-4 rounded" id="send-message-btn">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

{{-- HTML for Context Menu --}}
<div id="chat-context-menu" class="absolute bg-white border border-gray-200 rounded shadow-lg py-1 z-50 hidden">
    <a href="#" id="pin-chat-option" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        <i class="fa-solid fa-thumbtack mr-2"></i> Pin Chat
    </a>
    <a href="#" id="delete-chat-option" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
        <i class="fa-solid fa-trash mr-2"></i> Hapus Chat
    </a>
</div>

@if(session('success_modal_data'))
<script>
    const modalData = @json(session('success_modal_data'));
    alert("Pembayaran berhasil! Order ID: " + modalData.order_id);
</script>
@endif


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>

@push('scripts')
<script>
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.addEventListener('DOMContentLoaded', function () {
        const authUserId = {{ Auth::id() ?? 'null' }};
        let activeConversationId = null;
        let activeOtherUserId = null;
        let clickedChatItem = null; // Untuk menyimpan referensi item chat yang diklik kanan

        // Context Menu Elements
        const contextMenu = document.getElementById('chat-context-menu');
        const pinChatOption = document.getElementById('pin-chat-option');
        const deleteChatOption = document.getElementById('delete-chat-option');

        // Fungsi untuk menampilkan context menu
        function showContextMenu(x, y, chatItem) {
            clickedChatItem = chatItem; // Simpan referensi
            contextMenu.style.left = `${x}px`;
            contextMenu.style.top = `${y}px`;
            contextMenu.classList.remove('hidden');

            // Perbarui teks "Pin" berdasarkan status item
            const isPinned = chatItem.classList.contains('pinned-chat');
            pinChatOption.innerHTML = `<i class="fa-solid fa-thumbtack mr-2"></i> ${isPinned ? 'Unpin Chat' : 'Pin Chat'}`;
        }

        // Fungsi untuk menyembunyikan context menu
        function hideContextMenu() {
            contextMenu.classList.add('hidden');
            clickedChatItem = null;
        }

        // Event listener untuk klik pada ikon tiga titik
        document.querySelectorAll('.context-menu-trigger').forEach(trigger => {
            trigger.addEventListener('click', function(e) {
                e.stopPropagation(); // Mencegah event klik menyebar ke item chat utama
                const chatItem = this.closest('.chat-item'); // Dapatkan parent .chat-item
                showContextMenu(e.clientX, e.clientY, chatItem);
            });
        });

        // Event listener untuk klik di mana saja selain context menu untuk menyembunyikannya
        document.addEventListener('click', function(e) {
            if (!contextMenu.contains(e.target) && !e.target.closest('.context-menu-trigger')) {
                hideContextMenu();
            }
        });

        // Event listener untuk opsi "Pin Chat"
        pinChatOption.addEventListener('click', function(e) {
            e.preventDefault();
            if (clickedChatItem) {
                const conversationId = clickedChatItem.dataset.conversationId;
                const isPinned = !clickedChatItem.classList.contains('pinned-chat'); // Status baru

                axios.post(`/api/chat/pin/${conversationId}`, { is_pinned: isPinned })
                    .then(response => {
                        if (response.data.success) {
                            showToast(response.data.message, 'success');
                            // Update UI
                            if (isPinned) {
                                clickedChatItem.classList.add('pinned-chat');
                                // Pindahkan ke paling atas
                                document.getElementById('conversation-list').prepend(clickedChatItem);
                            } else {
                                clickedChatItem.classList.remove('pinned-chat');
                                // Untuk unpin, Anda mungkin perlu memuat ulang daftar atau mengurutkan ulang secara dinamis
                                // Cara paling sederhana adalah reload sebagian atau seluruh daftar (jika tidak banyak item)
                                // Atau implementasikan logika pengurutan yang lebih kompleks di frontend
                                location.reload(); // Solusi cepat untuk mengurutkan ulang setelah unpin
                            }
                            // Perbarui teks opsi pin di menu konteks
                            pinChatOption.innerHTML = `<i class="fa-solid fa-thumbtack mr-2"></i> ${isPinned ? 'Unpin Chat' : 'Pin Chat'}`;
                        } else {
                            showToast(response.data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error pinning/unpinning chat:', error);
                        showToast('Terjadi kesalahan saat mengubah status pin chat.', 'error');
                    });
            }
            hideContextMenu();
        });

        // Event listener untuk opsi "Hapus Chat"
        deleteChatOption.addEventListener('click', function(e) {
            e.preventDefault();
            if (clickedChatItem) {
                const conversationId = clickedChatItem.dataset.conversationId;
                const otherUserName = clickedChatItem.dataset.otherUserName;

                if (confirm(`Apakah Anda yakin ingin menghapus chat dengan ${otherUserName} beserta semua riwayatnya?`)) {
                    axios.delete(`/api/chat/conversations/${conversationId}`)
                        .then(response => {
                            if (response.data.success) {
                                showToast(response.data.message, 'success');
                                // Hapus dari UI
                                clickedChatItem.remove();

                                // Jika chat yang dihapus sedang aktif, reset tampilan chat panel
                                if (activeConversationId == conversationId) {
                                    activeConversationId = null;
                                    activeOtherUserId = null;
                                    document.getElementById('chat-placeholder').classList.remove('hidden');
                                    document.getElementById('chat-content').style.display = 'none'; // Gunakan 'none' untuk menyembunyikan
                                }
                                // Perbarui badge notifikasi jika diperlukan
                                if (window.updateChatBadge) {
                                    window.updateChatBadge();
                                }
                            } else {
                                showToast(response.data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting chat:', error);
                            showToast('Terjadi kesalahan saat menghapus chat.', 'error');
                        });
                }
            }
            hideContextMenu();
        });


        // ... (Fungsi updateOnlineStatus, initChat, loadMessages, markConversationAsRead) ...
        function updateOnlineStatus(userId, isOnline) {
            if (activeOtherUserId === userId) {
                const statusElement = document.getElementById('active-user-status');
                statusElement.textContent = isOnline ? 'Online' : 'Offline';
                statusElement.classList.toggle('text-green-400', isOnline);
                statusElement.classList.toggle('text-gray-500', !isOnline);
            }
            const listItem = document.querySelector(`#conversation-list li[data-other-user-id="${userId}"]`);
            if (listItem) {
            }
        }

        function initChat(conversationId, otherUserName, otherUserId) {
            activeConversationId = conversationId;
            activeOtherUserId = otherUserId;
            document.getElementById('chat-placeholder').classList.add('hidden');
            document.getElementById('chat-content').style.display = 'flex';
            document.getElementById('active-chat-name').textContent = otherUserName;

            axios.get(`/api/user-status/${otherUserId}`)
                .then(res => {
                    updateOnlineStatus(otherUserId, res.data.is_online);
                })
                .catch(error => {
                    console.error("Error fetching user status:", error);
                    updateOnlineStatus(otherUserId, false);
                });

            loadMessages(conversationId);
            markConversationAsRead(conversationId);
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
                            dateBubble.classList.add('text-center', 'text-sm', 'text-gray-500', 'my-2');
                            dateBubble.textContent = msgDate;
                            container.appendChild(dateBubble);
                        }

                        const bubble = document.createElement('div');
                        bubble.classList.add('p-3', 'rounded-lg', 'max-w-[70%]', 'break-words');
                        
                        const isMessageReceivedAndUnread = (msg.receiver_id === authUserId && msg.read_at === null);

                        if (msg.sender_id === authUserId) {
                             bubble.classList.add('bg-[#2563EB]', 'self-end');
                             bubble.innerHTML = `<p class='text-sm text-white'>${msg.content}</p><span class='text-xs text-blue-200 block text-right mt-1'>${new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>`;
                        } else {
                             bubble.classList.add('bg-gray-200', 'self-start');
                             bubble.style.opacity = isMessageReceivedAndUnread ? '1' : '0.8';
                             bubble.innerHTML = `<p class='font-semibold text-xs text-gray-700 mb-1'>${msg.sender.name ?? msg.sender.username}</p><p class='text-sm text-gray-800'>${msg.content}</p><span class='text-xs text-gray-500 block mt-1'>${new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>`;
                        }
                        container.appendChild(bubble);
                    });
                    container.scrollTop = container.scrollHeight;
                })
                .catch(error => {
                    console.error("Error loading messages:", error);
                });
        }

        function markConversationAsRead(conversationId) {
            axios.post(`/api/chat/mark-as-read/${conversationId}`)
                .then(res => {
                    const item = document.querySelector(`.chat-item[data-conversation-id="${conversationId}"]`);
                    if (item) {
                        item.dataset.isUnread = 'false';
                        const unreadDot = item.querySelector('.unread-dot');
                        if (unreadDot) {
                            unreadDot.remove();
                        }
                        const messageContent = item.querySelector('.message-content');
                        if (messageContent) {
                            messageContent.classList.remove('text-[#2563EB]', 'font-bold');
                            messageContent.classList.add('text-gray-500');
                        }
                    }
                    if (window.updateChatBadge) {
                        window.updateChatBadge();
                    }
                })
                .catch(error => {
                    console.error("Error marking conversation as read:", error);
                });
        }

        document.querySelectorAll('.chat-item').forEach(item => {
            item.addEventListener('click', function(e) {
                // Pastikan klik bukan pada trigger context menu
                if (!e.target.closest('.context-menu-trigger')) {
                    const conversationId = this.dataset.conversationId;
                    const otherUserName = this.dataset.otherUserName;
                    const otherUserId = this.dataset.otherUserId;
                    initChat(conversationId, otherUserName, otherUserId);

                    document.querySelectorAll('.chat-item').forEach(li => li.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });

        document.querySelectorAll('.new-chat-item').forEach(item => {
            item.addEventListener('click', function() {
                const otherUserId = this.dataset.otherUserId;
                const otherUserName = this.dataset.otherUserName;
                axios.post('/chat/create-or-get-conversation', {
                    other_user_id: otherUserId
                }).then(res => {
                    initChat(res.data.conversation_id, otherUserName, otherUserId);
                    location.reload();
                }).catch(error => {
                    console.error("Error creating new conversation:", error);
                    alert('Gagal memulai chat baru: ' + (error.response.data.message || error.message));
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
                input.value = '';
                loadMessages(activeConversationId);
            }).catch(error => {
                console.error("Error sending message:", error);
                alert('Gagal mengirim pesan.');
            });
        });

        document.getElementById('message-input').addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                document.getElementById('send-message-btn').click();
            }
        });

        document.getElementById('chat-search-input').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            document.querySelectorAll('#conversation-list > li').forEach(item => {
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

        // Pastikan authUserId sudah ada sebelum mencoba berlangganan Echo
        if (authUserId) {
            window.Echo.private(`chat.${authUserId}`)
                .listen('new-message', (e) => { // Perhatikan: listen 'new-message' bukan 'NewChatMessage'
                    console.log('Pesan baru diterima:', e); // Tambahkan log ini untuk debugging
                    // e.message sekarang adalah data dari broadcastWith()
                    // Anda perlu memeriksa apakah pesan ini milik percakapan yang aktif

                    if (e.conversation_id == activeConversationId) {
                        // Jika pesan dari percakapan yang aktif, muat ulang pesan
                        loadMessages(activeConversationId);
                    } else {
                        // Jika bukan dari percakapan aktif, update daftar chat (misal: tampilkan badge unread)
                        const conversationItem = document.querySelector(`.chat-item[data-conversation-id="${e.conversation_id}"]`);
                        if (conversationItem) {
                            const messageContent = conversationItem.querySelector('.message-content');
                            if (messageContent) {
                                messageContent.textContent = `Pesan baru: ${e.content.substring(0, 30)}...`;
                                messageContent.classList.remove('text-gray-500');
                                messageContent.classList.add('text-[#2563EB]', 'font-bold');
                            }
                            const messageTime = conversationItem.querySelector('.message-time');
                            if (messageTime) {
                                messageTime.textContent = new Date(e.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                            }
                            let unreadDot = conversationItem.querySelector('.unread-dot');
                            if (!unreadDot) {
                                unreadDot = document.createElement('span');
                                unreadDot.classList.add('w-2', 'h-2', 'bg-[#2563EB]', 'rounded-full', 'flex-shrink-0', 'unread-dot');
                                conversationItem.appendChild(unreadDot);
                            }
                            conversationItem.dataset.isUnread = 'true';
                            // Pindahkan ke paling atas jika pengirim bukan kita (pesan baru dari lawan bicara)
                            if (e.sender_id !== authUserId) {
                                const parentList = document.getElementById('conversation-list');
                                parentList.prepend(conversationItem);
                            }
                        } else {
                            // Jika percakapan belum ada di daftar, reload halaman atau tambahkan secara dinamis
                            location.reload();
                        }
                    }
                    if (window.updateChatBadge) {
                        window.updateChatBadge();
                    }
                });

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
        }

        @if(isset($activeConversation) && $activeConversation)
            const initialConversationId = {{ $activeConversation->id }};
            const initialOtherUserName = "{{ ($activeConversation->user1_id === Auth::id() ? $activeConversation->user2 : $activeConversation->user1)->name ?? ($activeConversation->user1_id === Auth::id() ? $activeConversation->user2 : $activeConversation->user1)->username }}";
            const initialOtherUserId = {{ ($activeConversation->user1_id === Auth::id() ? $activeConversation->user2 : $activeConversation->user1)->id }};
            initChat(initialConversationId, initialOtherUserName, initialOtherUserId);
        @endif
    });
</script>
@endpush