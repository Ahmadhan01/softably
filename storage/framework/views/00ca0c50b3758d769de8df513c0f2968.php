<?php $__env->startSection('isi'); ?>

<div class="flex flex-col md:flex-row w-full h-full text-gray-800">
    
    <div class="w-full md:w-1/4 xl:w-2/6 border-r border-gray-200 pr-4 flex flex-col bg-white rounded-l-lg p-6 ml-64">
        <h1 class="text-2xl font-semibold mb-4 text-gray-800">Chat Customer</h1>

        <div class="relative mb-4">
            <input type="text" placeholder="Search people" class="w-full bg-gray-100 text-gray-800 py-2 px-4 rounded focus:outline-none border border-gray-300 shadow-sm" id="chat-search-input" />
            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-gray-500">All</span>
        </div>

        <ul class="space-y-3 overflow-y-auto flex-1 pr-2" id="conversation-list">
            
            
            <?php
                $sortedConversations = $conversations->sortByDesc(function($conversation) {
                    return $conversation->is_pinned ? 2 : (optional($conversation->messages->last())->created_at ? optional($conversation->messages->last())->created_at->timestamp : 1);
                });
            ?>

            <?php $__currentLoopData = $sortedConversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $otherUser = ($conversation->user1_id === Auth::id()) ? $conversation->user2 : $conversation->user1;
                    $latestMessage = optional($conversation->messages->last());
                    $isUnread = $latestMessage && $latestMessage->receiver_id === Auth::id() && is_null($latestMessage->read_at);
                    $isActive = isset($activeConversation) && $activeConversation->id === $conversation->id;
                ?>
                <li class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 p-2 rounded chat-item <?php echo e($isActive ? 'active bg-gray-100' : ''); ?> <?php echo e($conversation->is_pinned ? 'pinned-chat' : ''); ?>"
                    data-conversation-id="<?php echo e($conversation->id); ?>"
                    data-other-user-id="<?php echo e($otherUser->id); ?>"
                    data-other-user-name="<?php echo e($otherUser->name ?? $otherUser->username); ?>"
                    data-is-unread="<?php echo e($isUnread ? 'true' : 'false'); ?>">
                    <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200 flex-shrink-0">
                        <img src="<?php echo e($otherUser->profile_picture_url ?? asset('path/to/default/profile_picture.jpg')); ?>" class="w-10 h-10 rounded-full object-cover" /> 
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 truncate">
                            <?php echo e($otherUser->name ?? $otherUser->username); ?>

                            <?php if($conversation->is_pinned): ?>
                                <i class="fa-solid fa-thumbtack text-gray-500 text-xs ml-1"></i>
                            <?php endif; ?>
                        </p>
                        <p class="text-sm <?php echo e($isUnread ? 'text-[#2563EB] font-bold' : 'text-gray-500'); ?> truncate message-content">
                            <?php echo e($latestMessage->content ? Str::limit($latestMessage->content, 30) : 'Mulai percakapan baru...'); ?>

                        </p>
                    </div>
                    <span class="text-xs text-gray-400 message-time">
                        <?php echo e($latestMessage->created_at ? $latestMessage->created_at->format('H:i') : ''); ?>

                    </span>
                    <?php if($isUnread): ?>
                        <span class="w-2 h-2 bg-[#2563EB] rounded-full flex-shrink-0 unread-dot"></span>
                    <?php endif; ?>
                    <div class="relative flex-shrink-0 ml-auto context-menu-trigger p-1 rounded-full hover:bg-gray-200">
                        <i class="fas fa-ellipsis-v text-gray-500 text-sm"></i>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <?php if($availableUsersToChat->isNotEmpty()): ?>
                <li class="text-center text-gray-600 mt-4 pt-4 border-t border-gray-300">Mulai Chat Baru</li>
                <?php $__currentLoopData = $availableUsersToChat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userToChat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $existingConversation = $conversations->first(function($conv) use ($userToChat) {
                            return ($conv->user1_id === Auth::id() && $conv->user2_id === $userToChat->id) ||
                                ($conv->user1_id === $userToChat->id && $conv->user2_id === Auth::id());
                        });
                    ?>
                    <?php if(!$existingConversation): ?>
                        <li class="flex items-center gap-3 cursor-pointer hover:bg-gray-100 p-2 rounded new-chat-item"
                            data-other-user-id="<?php echo e($userToChat->id); ?>"
                            data-other-user-name="<?php echo e($userToChat->name ?? $userToChat->username); ?>">
                            <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200 flex-shrink-0">
                                <img src="<?php echo e($userToChat->profile_picture_url ?? asset('path/to/default/profile_picture.jpg')); ?>" class="w-10 h-10 rounded-full object-cover" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800 truncate">
                                    <?php echo e($userToChat->name ?? $userToChat->username); ?></p>
                                <p class="text-sm text-gray-500">Klik untuk chat...</p>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </ul>
    </div>

    
    <div class="flex-1 pl-4 flex flex-col bg-[#F8FAFC] rounded-r-lg p-6">
        <div class="flex-1 flex items-center justify-center text-gray-600 text-lg" id="chat-placeholder">
            Pilih percakapan untuk memulai chat.
        </div>
        <div class="hidden flex-col flex-1 h-full" id="chat-content">
            <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-4">
                <div>
                    <p class="font-bold text-lg text-gray-800" id="active-chat-name">User</p>
                    <p class="text-sm text-gray-500" id="active-user-status">Offline</p>
                </div>
            </div>
            <div class="flex flex-col space-y-2 overflow-y-auto flex-1 pr-2 pb-3" id="chat-messages-container"></div>
            <div class="mt-auto pt-4 border-t border-gray-200">
                <div class="flex gap-2">
                    <input type="text" placeholder="Ketik pesan..." class="flex-1 px-4 py-2 bg-gray-100 text-gray-800 rounded focus:outline-none border border-gray-300 shadow-sm" id="message-input" />
                    <button class="bg-[#2563EB] hover:bg-[#3B82F6] text-white px-4 rounded" id="send-message-btn">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="chat-context-menu" class="absolute bg-white border border-gray-200 rounded shadow-lg py-1 z-50 hidden">
    <a href="#" id="pin-chat-option" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        <i class="fa-solid fa-thumbtack mr-2"></i> Pin Chat
    </a>
    <a href="#" id="delete-chat-option" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
        <i class="fa-solid fa-trash mr-2"></i> Hapus Chat
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    axios.defaults.withCredentials = true; // Penting untuk mengirim cookie (termasuk session dan XSRF-TOKEN)

    document.addEventListener('DOMContentLoaded', function () {
        const authUserId = <?php echo e(Auth::id() ?? 'null'); ?>;
        let activeConversationId = null;
        let activeOtherUserId = null;
        let clickedChatItem = null;

        const contextMenu = document.getElementById('chat-context-menu');
        const pinChatOption = document.getElementById('pin-chat-option');
        const deleteChatOption = document.getElementById('delete-chat-option');

        function showToast(message, type = 'info') {
            const toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                const div = document.createElement('div');
                div.id = 'toast-container';
                div.style.position = 'fixed';
                div.style.top = '20px';
                div.style.right = '20px';
                div.style.zIndex = '9999';
                document.body.appendChild(div);
            }

            const toast = document.createElement('div');
            toast.className = `p-3 rounded-md shadow-md text-white mb-3 flex items-center gap-2`;
            if (type === 'success') {
                toast.classList.add('bg-green-500');
                toast.innerHTML = `<i class="fas fa-check-circle"></i> <span>${message}</span>`;
            } else if (type === 'error') {
                toast.classList.add('bg-red-500');
                toast.innerHTML = `<i class="fas fa-times-circle"></i> <span>${message}</span>`;
            } else {
                toast.classList.add('bg-blue-500');
                toast.innerHTML = `<i class="fas fa-info-circle"></i> <span>${message}</span>`;
            }

            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.5s ease-in-out';
            requestAnimationFrame(() => {
                toast.style.opacity = '1';
            });

            document.getElementById('toast-container').prepend(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.addEventListener('transitionend', () => toast.remove());
            }, 3000);
        }

        function showContextMenu(x, y, chatItem) {
            clickedChatItem = chatItem;
            contextMenu.style.left = `${x}px`;
            contextMenu.style.top = `${y}px`;
            contextMenu.classList.remove('hidden');

            const isPinned = chatItem.classList.contains('pinned-chat');
            pinChatOption.innerHTML = `<i class="fa-solid fa-thumbtack mr-2"></i> ${isPinned ? 'Unpin Chat' : 'Pin Chat'}`;
        }

        function hideContextMenu() {
            contextMenu.classList.add('hidden');
            clickedChatItem = null;
        }

        document.querySelectorAll('.context-menu-trigger').forEach(trigger => {
            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                const chatItem = this.closest('.chat-item');
                showContextMenu(e.clientX, e.clientY, chatItem);
            });
        });

        document.addEventListener('click', function(e) {
            if (!contextMenu.contains(e.target) && !e.target.closest('.context-menu-trigger')) {
                hideContextMenu();
            }
        });

        pinChatOption.addEventListener('click', function(e) {
            e.preventDefault();
            if (clickedChatItem) {
                const conversationId = clickedChatItem.dataset.conversationId;
                const isPinned = !clickedChatItem.classList.contains('pinned-chat');

                axios.post(`<?php echo e(url('/api/chat/pin')); ?>/${conversationId}`, { is_pinned: isPinned })
                    .then(response => {
                        if (response.data.success) {
                            showToast(response.data.message, 'success');
                            if (isPinned) {
                                clickedChatItem.classList.add('pinned-chat');
                                const conversationList = document.getElementById('conversation-list');
                                if (conversationList) {
                                    conversationList.prepend(clickedChatItem);
                                }
                            } else {
                                clickedChatItem.classList.remove('pinned-chat');
                                fetchConversationsAndRender();
                            }
                            pinChatOption.innerHTML = `<i class="fa-solid fa-thumbtack mr-2"></i> ${isPinned ? 'Unpin Chat' : 'Pin Chat'}`;
                        } else {
                            showToast(response.data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error pinning/unpinning chat:', error);
                        const errorMessage = error.response && error.response.data && error.response.data.message
                                           ? error.response.data.message
                                           : 'Terjadi kesalahan saat mengubah status pin chat.';
                        showToast(errorMessage, 'error');
                    });
            }
            hideContextMenu();
        });

        deleteChatOption.addEventListener('click', function(e) {
            e.preventDefault();
            if (clickedChatItem) {
                const conversationId = clickedChatItem.dataset.conversationId;
                const otherUserName = clickedChatItem.dataset.otherUserName;

                if (confirm(`Apakah Anda yakin ingin menghapus chat dengan ${otherUserName} beserta semua riwayatnya?`)) {
                    axios.delete(`<?php echo e(url('/api/chat/conversations')); ?>/${conversationId}`)
                        .then(response => {
                            if (response.data.success) {
                                showToast(response.data.message, 'success');
                                clickedChatItem.remove();

                                if (activeConversationId == conversationId) {
                                    activeConversationId = null;
                                    activeOtherUserId = null;
                                    document.getElementById('chat-placeholder').classList.remove('hidden');
                                    document.getElementById('chat-content').style.display = 'none';
                                }
                                if (window.updateChatBadge) {
                                    window.updateChatBadge();
                                }
                            } else {
                                showToast(response.data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting chat:', error);
                            const errorMessage = error.response && error.response.data && error.response.data.message
                                               ? error.response.data.message
                                               : 'Terjadi kesalahan saat menghapus chat.';
                            showToast(errorMessage, 'error');
                        });
                }
            }
            hideContextMenu();
        });

        function updateOnlineStatus(userId, isOnline) {
            if (activeOtherUserId === userId) {
                const statusElement = document.getElementById('active-user-status');
                statusElement.textContent = isOnline ? 'Online' : 'Offline';
                statusElement.classList.toggle('text-green-400', isOnline);
                statusElement.classList.toggle('text-gray-500', !isOnline);
            }
            const listItem = document.querySelector(`#conversation-list li[data-other-user-id="${userId}"]`);
            if (listItem) {
                let statusSpan = listItem.querySelector('.online-status');
                if (!statusSpan) {
                    statusSpan = document.createElement('span');
                    statusSpan.classList.add('text-xs', 'ml-1', 'online-status');
                    const nameElement = listItem.querySelector('.font-semibold');
                    if (nameElement) {
                        nameElement.appendChild(statusSpan);
                    }
                }
                statusSpan.textContent = isOnline ? 'Online' : 'Offline';
                statusSpan.classList.toggle('text-green-400', isOnline);
                statusSpan.classList.toggle('text-gray-500', !isOnline);
            }
        }

        function initChat(conversationId, otherUserName, otherUserId) {
            activeConversationId = conversationId;
            activeOtherUserId = otherUserId;
            document.getElementById('chat-placeholder').classList.add('hidden');
            document.getElementById('chat-content').classList.remove('hidden');
            document.getElementById('chat-content').style.display = 'flex';
            document.getElementById('active-chat-name').textContent = otherUserName;

            // Menggunakan URL helper Laravel
            axios.get(`<?php echo e(url('/api/user-status')); ?>/${otherUserId}`)
                .then(res => {
                    updateOnlineStatus(otherUserId, res.data.is_online);
                })
                .catch(error => {
                    console.error("Error fetching user status:", error);
                    showToast('Gagal mengambil status online.', 'error');
                    updateOnlineStatus(otherUserId, false);
                });

            loadMessages(conversationId);
            markConversationAsRead(conversationId);
        }

        function loadMessages(conversationId) {
            // Menggunakan URL helper Laravel
            axios.get(`<?php echo e(url('/api/chat/messages')); ?>/${conversationId}`)
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
                             bubble.classList.add('bg-[#2563EB]', 'self-end', 'text-white');
                        } else {
                             bubble.classList.add('bg-gray-200', 'self-start');
                             bubble.style.opacity = isMessageReceivedAndUnread ? '1' : '0.8';
                        }

                        if (msg.sender_id === authUserId) {
                            bubble.innerHTML = `<p class='text-sm'>${msg.content}</p><span class='text-xs text-blue-200 block text-right mt-1'>${new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>`;
                        } else {
                            bubble.innerHTML = `<p class='font-semibold text-xs text-gray-700 mb-1'>${msg.sender.name ?? msg.sender.username}</p><p class='text-sm text-gray-800'>${msg.content}</p><span class='text-xs text-gray-500 block mt-1'>${new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>`;
                        }

                        container.appendChild(bubble);
                    });
                    container.scrollTop = container.scrollHeight;
                })
                .catch(error => {
                    console.error("Error loading messages:", error);
                    showToast('Gagal memuat pesan.', 'error');
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
                    showToast('Gagal menandai pesan sebagai sudah dibaca.', 'error');
                });
        }

        async function fetchConversationsAndRender() {
            try {
                // Menggunakan URL helper Laravel
                const response = await axios.get(`<?php echo e(url('/api/seller/chat/conversations')); ?>`);
                const conversations = response.data.conversations;
                const conversationList = document.getElementById('conversation-list');
                conversationList.innerHTML = '';

                conversations.forEach(conversation => {
                    const otherUser = (conversation.user1_id === authUserId) ? conversation.user2 : conversation.user1;
                    const latestMessage = conversation.messages.length > 0 ? conversation.messages[0] : null;
                    const isUnread = latestMessage && latestMessage.receiver_id === authUserId && latestMessage.read_at === null;
                    const isActive = activeConversationId && activeConversationId === conversation.id;

                    const li = document.createElement('li');
                    li.className = `flex items-center gap-3 cursor-pointer hover:bg-gray-100 p-2 rounded chat-item ${isActive ? 'active bg-gray-100' : ''} ${conversation.is_pinned ? 'pinned-chat' : ''}`;
                    li.dataset.conversationId = conversation.id;
                    li.dataset.otherUserId = otherUser.id;
                    li.dataset.otherUserName = otherUser.name || otherUser.username;
                    li.dataset.isUnread = isUnread ? 'true' : 'false';

                    const profilePicUrl = otherUser.profile_picture_url || '<?php echo e(asset('path/to/default/profile_picture.jpg')); ?>';

                    li.innerHTML = `
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200 flex-shrink-0">
                            <img src="${profilePicUrl}" class="w-10 h-10 rounded-full object-cover" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 truncate">
                                ${otherUser.name || otherUser.username}
                                ${conversation.is_pinned ? '<i class="fa-solid fa-thumbtack text-gray-500 text-xs ml-1"></i>' : ''}
                            </p>
                            <p class="text-sm ${isUnread ? 'text-[#2563EB] font-bold' : 'text-gray-500'} truncate message-content">
                                ${latestMessage && latestMessage.content ? latestMessage.content.substring(0, 30) + (latestMessage.content.length > 30 ? '...' : '') : 'Mulai percakapan baru...'}
                            </p>
                        </div>
                        <span class="text-xs text-gray-400 message-time">
                            ${latestMessage && latestMessage.created_at ? new Date(latestMessage.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : ''}
                        </span>
                        ${isUnread ? '<span class="w-2 h-2 bg-[#2563EB] rounded-full flex-shrink-0 unread-dot"></span>' : ''}
                        <div class="relative flex-shrink-0 ml-auto context-menu-trigger p-1 rounded-full hover:bg-gray-200">
                            <i class="fas fa-ellipsis-v text-gray-500 text-sm"></i>
                        </div>
                    `;

                    li.querySelector('.context-menu-trigger').addEventListener('click', function(e) {
                        e.stopPropagation();
                        const chatItem = this.closest('.chat-item');
                        showContextMenu(e.clientX, e.clientY, chatItem);
                    });
                    li.addEventListener('click', function(e) {
                        if (!e.target.closest('.context-menu-trigger')) {
                            const conversationId = this.dataset.conversationId;
                            const otherUserName = this.dataset.otherUserName;
                            const otherUserId = this.dataset.otherUserId;
                            initChat(conversationId, otherUserName, otherUserId);

                            document.querySelectorAll('.chat-item').forEach(li => li.classList.remove('active', 'bg-gray-100'));
                            this.classList.add('active', 'bg-gray-100');
                        }
                    });

                    conversationList.appendChild(li);
                });
            } catch (error) {
                console.error("Error fetching and rendering conversations:", error);
                showToast('Gagal memuat ulang daftar chat. Silakan coba refresh halaman.', 'error');
            }
        }

        document.querySelectorAll('.chat-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (!e.target.closest('.context-menu-trigger')) {
                    const conversationId = this.dataset.conversationId;
                    const otherUserName = this.dataset.otherUserName;
                    const otherUserId = this.dataset.otherUserId;
                    initChat(conversationId, otherUserName, otherUserId);

                    document.querySelectorAll('.chat-item').forEach(li => li.classList.remove('active', 'bg-gray-100'));
                    this.classList.add('active', 'bg-gray-100');
                }
            });
        });

        document.querySelectorAll('.new-chat-item').forEach(item => {
            item.addEventListener('click', function() {
                const otherUserId = this.dataset.otherUserId;
                const otherUserName = this.dataset.otherUserName;
                // Menggunakan URL helper Laravel
                axios.post(`<?php echo e(url('/api/chat/create-or-get-conversation')); ?>`, {
                    other_user_id: otherUserId
                }).then(res => {
                    initChat(res.data.conversation_id, otherUserName, otherUserId);
                    fetchConversationsAndRender();
                }).catch(error => {
                    console.error("Error creating new conversation:", error);
                    showToast('Gagal memulai chat baru: ' + (error.response.data.message || error.message), 'error');
                });
            });
        });

        document.getElementById('send-message-btn').addEventListener('click', () => {
            const input = document.getElementById('message-input');
            const message = input.value.trim();
            if (!message || !activeConversationId) return;

            // Menggunakan URL helper Laravel
            axios.post(`<?php echo e(url('/api/chat/send')); ?>/${activeConversationId}`, {
                content: message
            }).then(() => {
                input.value = '';
                loadMessages(activeConversationId);
                fetchConversationsAndRender();
            }).catch(error => {
                console.error("Error sending message:", error);
                showToast('Gagal mengirim pesan.', 'error');
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

        if (authUserId) {
            window.Echo.private(`chat.${authUserId}`)
                .listen('new-message', (e) => {
                    console.log('Pesan baru diterima:', e);

                    if (e.conversation_id == activeConversationId) {
                        loadMessages(activeConversationId);
                    } else {
                        fetchConversationsAndRender();
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
                    showToast('Kesalahan koneksi status online.', 'error');
                });
        }

        fetchConversationsAndRender();

        <?php if(isset($activeConversation) && $activeConversation): ?>
            const initialConversationId = <?php echo e($activeConversation->id); ?>;
            const initialOtherUserName = "<?php echo e(($activeConversation->user1_id === Auth::id() ? $activeConversation->user2 : $activeConversation->user1)->name ?? ($activeConversation->user1_id === Auth::id() ? $activeConversation->user2 : $activeConversation->user1)->username); ?>";
            const initialOtherUserId = <?php echo e(($activeConversation->user1_id === Auth::id() ? $activeConversation->user2 : $activeConversation->user1)->id); ?>;
            initChat(initialConversationId, initialOtherUserName, initialOtherUserId);
        <?php endif; ?>
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.sidebar-seller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Aplikasi\laragon\www\softably\resources\views/view-seller/chat-seller.blade.php ENDPATH**/ ?>