<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://kit.fontawesome.com/1531486bb6.js" crossorigin="anonymous"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-bg': '#2d3748',
                        'dark-card': '#2d3748',
                        'dark-hover': '#374151',
                        'gray-900': '#1a202c',
                        'gray-800': '#2d3748',
                        'gray-700': '#4a5568',
                        'gray-600': '#718096',
                        'gray-500': '#a0aec0',
                        'gray-400': '#cbd5e0',
                        'gray-300': '#e2e8f0',
                        'white': '#ffffff',
                        'green-600': '#38a169',
                        'blue-600': '#3b82f6',
                        'blue-700': '#2563eb',
                        'red-900': '#7f1d1d',
                        'blue-400': '#60a5fa',
                        'yellow-400': '#facc15',
                        'yellow-500': '#eab308',
                        'online-green': '#19C94A'
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar for better appearance in dark theme */
        .scrollbar-thin::-webkit-scrollbar {
            width: 8px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #2d3748;
            /* dark-card */
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: #4a5568;
            /* gray-700 */
            border-radius: 20px;
            border: 2px solid #2d3748;
            /* dark-card */
        }
    </style>
</head>

<body class="bg-gray-900 text-white">
    <div class="flex h-screen">
        <div class="w-64 bg-[#23293a] flex flex-col justify-between border-r border-[#23293a] relative z-10">
            <div>
                <div class="p-6 border-b border-gray-700 flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                        <img src="/img/icon-soft.png" alt="" class="rounded-full">
                    </div>
                    <span class="text-white font-semibold">Ini Logo Web</span>
                </div>
                <div class="p-4">
                    <p class="text-gray-400 text-xs uppercase tracking-wider mb-4">MENU</p>
                    <nav class="space-y-2">
                        <a href="/Dashboard-seller" id="dashboard-link"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fa-solid fa-store"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="/My-product-seller" id="my-product-link"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fas fa-file-alt"></i>
                            <span>My Product</span>
                        </a>
                        <a href="/Chat-seller" id="chat-link"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fa-solid fa-message"></i>
                            <span>Chat</span>
                        </a>
                        <a href="/Notification-seller" id="notification-link"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fa-solid fa-bell"></i>
                            <span>Notification</span>
                            <div
                                class="flex items-center w-3 h-3 bg-green-600 rounded-full right-5 justify-center py-3 px-4 ml-2">
                                <div class="flex">4</div>
                            </div>
                        </a>
                        <a href="/Help-Center-seller" id="help-center-link"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
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
                        <img src="/img/icon-soft.png" alt="" class="rounded-full">
                    </div>
                    <div class="flex-1">
                        <p class="text-white text-sm font-medium">Fuad Store</p>
                        <p class="text-gray-400 text-xs">Store settings</p>
                    </div>
                </div>
                <div class="mt-8 space-y-2">
                    <a href="/Settings-seller" id="settings-link"
                        class="flex items-center space-x-3 p-2 text-gray-300 hover:text-white transition-colors">
                        <i class="fa-solid fa-gear"></i>
                        <span class="text-sm">Settings</span>
                    </a>
                    <a href="/Log-Out-seller" id="logout-link"
                        class="flex items-center space-x-3 p-2 text-gray-300 hover:text-white transition-colors">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="text-sm">Log Out</span>
                    </a>
                </div>
            </div>
        </div>
        <div id="chat" class="content-section flex-1 flex">
            <div class="w-70 bg-[#1e293b] border-r border-l border-gray-700 flex flex-col px-0 py-2 p-1">
                <div class="p-2 border-b border-gray-700">
                    <div class="flex-1 text-white font-medium text-2xl p-1 mb-5">
                        <bold>
                            <h1>Chat</h1>
                        </bold>
                    </div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="relative flex-1">
                            <i
                                class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" placeholder="Search people..."
                                class="w-full bg-gray-700 text-white pl-10 pr-3 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
                                id="chatSearchInput">
                        </div>
                        <select
                            class="bg-gray-700 text-white px-1 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
                            id="statusFilter">
                            <option value="all">All</option>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto scrollbar-thin" id="chatList">
                    </div>
            </div>

            <div class="flex-1 flex flex-col bg-gray-900">
                <div class="bg-dark-card border-b border-gray-700 p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gray-600 rounded-lg flex items-center justify-center overflow-hidden">
                                <img src="/img/icon-soft.png" alt="" class="rounded-full w-full h-full object-cover"
                                    id="chatHeaderProductImage">
                            </div>
                            <div>
                                <h3 class="text-white font-medium text-lg" id="chatHeaderProductName">Pilih Chat</h3>
                                <p class="text-gray-400 text-sm" id="chatHeaderProductDate"></p>
                            </div>
                        </div>
                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors"
                            id="checkDetailsButton">
                            Check Details
                        </button>
                    </div>
                </div>

                <div class="flex-1 p-6 overflow-y-auto scrollbar-thin" id="chatMessagesArea">
                    <div class="space-y-6">
                        <p class="text-gray-400 text-center">Pilih percakapan untuk memulai chat.</p>
                    </div>
                </div>

                <div class="bg-dark-card border-t border-gray-700 p-4">
                    <div class="flex items-center space-x-3">
                        <button class="text-gray-400 hover:text-white transition-colors" id="attachButton">
                            <i class="fa-solid fa-paperclip text-lg"></i>
                        </button>
                        <div class="flex-1 relative">
                            <input type="text" placeholder="Ketik pesan..."
                                class="w-full bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                                id="messageInput">
                        </div>
                        <button class="bg-green-600 hover:bg-blue-700 text-white p-3 rounded-lg transition-colors"
                            id="sendButton">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // BASE_URL untuk API Anda
        const BASE_API_URL = 'http://localhost/your_store_project/api'; // Ganti 'your_store_project' dengan nama folder Anda

        // ID Seller yang sedang login (hardcode untuk demo, di aplikasi nyata dari sesi/autentikasi)
        const CURRENT_SELLER_ID = 3; // Contoh: ID Ahmad Basikal di DB Anda

        let allChats = []; // Untuk menyimpan semua data chat yang diambil dari backend
        let activeChatId = null; // ID percakapan aktif dari database (bukan ID mock frontend)
        let activeChatParticipantId = null; // ID partisipan lawan bicara
        let currentSearchQuery = '';
        let currentStatusFilter = 'all';

        const chatListElement = document.getElementById('chatList');
        const chatMessagesArea = document.getElementById('chatMessagesArea');
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');
        const attachButton = document.getElementById('attachButton');
        const chatHeaderProductName = document.getElementById('chatHeaderProductName');
        const chatHeaderProductDate = document.getElementById('chatHeaderProductDate');
        const chatHeaderProductImage = document.getElementById('chatHeaderProductImage');
        const checkDetailsButton = document.getElementById('checkDetailsButton');
        const chatSearchInput = document.getElementById('chatSearchInput');
        const statusFilter = document.getElementById('statusFilter');

        // Function to fetch and render chat list from backend
        async function fetchAndRenderChatList() {
            try {
                const response = await fetch(`${BASE_API_URL}/get_chats.php`);
                const result = await response.json();

                if (result.success) {
                    allChats = result.chats; // Simpan data chat yang sebenarnya
                    renderChatList(); // Render daftar chat ke UI
                    // Setelah memuat daftar chat, jika ada chat aktif yang tersimpan
                    // atau jika ada chat pertama, muat pesannya.
                    if (activeChatId) {
                        const foundChat = allChats.find(chat => chat.conversation_id_db === activeChatId);
                        if (!foundChat) { // Jika chat aktif tidak ada di hasil filter
                            activeChatId = null; // Reset
                            activeChatParticipantId = null;
                            chatMessagesArea.querySelector('div').innerHTML = '<p class="text-gray-400 text-center">Pilih percakapan untuk memulai chat.</p>';
                            chatHeaderProductName.textContent = 'Pilih Chat';
                            chatHeaderProductDate.textContent = '';
                            chatHeaderProductImage.src = '/img/icon-soft.png';
                        } else {
                            // Re-render chat messages for the already active chat
                            await fetchAndRenderChatMessages(activeChatId);
                        }
                    } else if (allChats.length > 0) {
                        // Jika belum ada chat aktif, set chat pertama sebagai aktif
                        setActiveChat(allChats[0].conversation_id_db, allChats[0].participant_id);
                    }
                } else {
                    console.error('Failed to fetch chat list:', result.message);
                    chatListElement.innerHTML = `<p class="text-gray-400 text-center p-4">${result.message}</p>`;
                }
            } catch (error) {
                console.error('Error fetching chat list:', error);
                chatListElement.innerHTML = `<p class="text-red-500 text-center p-4">Gagal memuat daftar chat. Cek koneksi server.</p>`;
            }
        }

        // Function to render chat list in sidebar (based on local 'allChats' data)
        function renderChatList() {
            chatListElement.innerHTML = ''; // Clear existing list

            let filteredChats = allChats.filter(chat => {
                const matchesSearch = chat.name.toLowerCase().includes(currentSearchQuery.toLowerCase());
                const matchesStatus = currentStatusFilter === 'all' || chat.status === currentStatusFilter;
                return matchesSearch && matchesStatus;
            });

            // If the currently active chat is no longer in the filtered list, reset activeChatId
            if (activeChatId && !filteredChats.some(chat => chat.conversation_id_db === activeChatId)) {
                activeChatId = null;
                activeChatParticipantId = null;
                chatHeaderProductName.textContent = 'Pilih Chat';
                chatHeaderProductDate.textContent = '';
                chatHeaderProductImage.src = '/img/icon-soft.png';
                chatMessagesArea.querySelector('div').innerHTML = '<p class="text-gray-400 text-center">Pilih percakapan untuk memulai chat.</p>';
            }

            if (filteredChats.length === 0) {
                chatListElement.innerHTML = '<p class="text-gray-400 text-center p-4">Tidak ada chat yang cocok.</p>';
            }


            filteredChats.forEach(chat => {
                const isActive = chat.conversation_id_db === activeChatId ? 'bg-dark-hover' : 'hover:bg-dark-hover';
                const chatItem = document.createElement('div');
                chatItem.className = `p-4 ${isActive} cursor-pointer transition-colors border-b border-gray-700 chat-item`;
                chatItem.dataset.conversationId = chat.conversation_id_db; // Simpan ID percakapan DB
                chatItem.dataset.participantId = chat.participant_id; // Simpan ID partisipan

                const onlineIndicator = chat.status === 'online' ?
                    `<span class="w-2 h-2 bg-online-green rounded-full absolute bottom-0 right-0 border border-dark-hover"></span>` : '';

                chatItem.innerHTML = `
                    <div class="flex items-start space-x-3">
                        <div class="w-9 h-9 bg-white rounded-full flex-shrink-0 flex items-center justify-center overflow-hidden relative">
                            <img src="${chat.avatar}" alt="${chat.name}" class="rounded-full w-full h-full object-cover">
                            ${onlineIndicator}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center space-x-2">
                                    <h4 class="text-white font-medium text-sm">${chat.name}</h4>
                                    <span class="text-gray-400 text-xs">${chat.lastMessageTime}</span>
                                </div>
                            </div>
                            <p class="text-gray-300 text-sm">${chat.lastMessage}</p>
                        </div>
                    </div>
                `;
                chatListElement.appendChild(chatItem);

                chatItem.addEventListener('click', () => {
                    setActiveChat(chat.conversation_id_db, chat.participant_id);
                });
            });
        }

        // Function to fetch and render messages for the active chat from backend
        async function fetchAndRenderChatMessages(conversationId) {
            const currentChat = allChats.find(chat => chat.conversation_id_db === conversationId);
            if (!currentChat) {
                chatMessagesArea.querySelector('div').innerHTML = '<p class="text-gray-400 text-center">Percakapan tidak ditemukan.</p>';
                return;
            }

            chatMessagesArea.querySelector('div').innerHTML = '<p class="text-gray-400 text-center">Memuat pesan...</p>'; // Loading indicator

            try {
                const response = await fetch(`${BASE_API_URL}/get_messages.php?conversation_id=${conversationId}`);
                const result = await response.json();

                if (result.success) {
                    // Update header product info
                    chatHeaderProductName.textContent = currentChat.productName;
                    chatHeaderProductDate.textContent = `Selesai pada ${currentChat.productDate}`;
                    chatHeaderProductImage.src = currentChat.productImage; // Use actual product image

                    chatMessagesArea.querySelector('div').innerHTML = ''; // Clear loading message

                    if (result.messages.length === 0) {
                        chatMessagesArea.querySelector('div').innerHTML = '<p class="text-gray-400 text-center">Belum ada pesan dalam percakapan ini.</p>';
                    } else {
                        result.messages.forEach(message => {
                            const messageElement = document.createElement('div');
                            messageElement.className = 'bg-dark-card rounded-lg hover:bg-dark-hover p-2';
                            // Sesuaikan rendering pesan
                            messageElement.innerHTML = `
                                <div class="flex items-start space-x-3 mb-1">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <h4 class="text-white font-medium text-sm">${message.sender}</h4>
                                            <span class="text-gray-400 text-xs">${message.time}</span>
                                        </div>
                                        <span class="text-blue-400 text-xs font-medium">${message.date}</span>
                                    </div>
                                </div>
                                <p class="text-gray-300 text-sm leading-relaxed">${message.text}</p>
                            `;
                            chatMessagesArea.querySelector('div').appendChild(messageElement);
                        });
                    }
                    scrollToBottom();
                } else {
                    console.error('Failed to fetch messages:', result.message);
                    chatMessagesArea.querySelector('div').innerHTML = `<p class="text-red-500 text-center">Gagal memuat pesan: ${result.message}</p>`;
                }
            } catch (error) {
                console.error('Error fetching messages:', error);
                chatMessagesArea.querySelector('div').innerHTML = `<p class="text-red-500 text-center">Terjadi kesalahan jaringan saat memuat pesan.</p>`;
            }
        }

        // Function to set active chat
        async function setActiveChat(conversationId, participantId) {
            if (activeChatId === conversationId) return; // Prevent re-fetching if already active

            activeChatId = conversationId;
            activeChatParticipantId = participantId;
            renderChatList(); // Re-render chat list to update active state visual
            await fetchAndRenderChatMessages(conversationId); // Fetch and render messages for the newly active chat
        }

        // Scroll chat to bottom
        function scrollToBottom() {
            chatMessagesArea.scrollTop = chatMessagesArea.scrollHeight;
        }

        // Send Message functionality
        async function sendMessage() {
            const message = messageInput.value.trim();
            if (!message || !activeChatId || !activeChatParticipantId) {
                alert('Pesan kosong atau tidak ada chat yang dipilih.');
                return;
            }

            try {
                const response = await fetch(`${BASE_API_URL}/send_message.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        conversation_id: activeChatId,
                        receiver_id: activeChatParticipantId,
                        message: message
                    }),
                });

                const result = await response.json();

                if (result.success) {
                    messageInput.value = ''; // Clear input
                    // Re-fetch and re-render messages to show the new message
                    await fetchAndRenderChatMessages(activeChatId);
                    // Re-fetch chat list to update last message time/content
                    await fetchAndRenderChatList(); // This also triggers renderChatList()
                } else {
                    alert('Gagal mengirim pesan: ' + result.message);
                }
            } catch (error) {
                console.error('Error sending message:', error);
                alert('Terjadi kesalahan jaringan atau server saat mengirim pesan.');
            }
        }

        // Attach File/Image functionality (currently simulated)
        function attachFile() {
             if (!activeChatId || !activeChatParticipantId) {
                alert('Pilih chat terlebih dahulu untuk mengirim lampiran.');
                return;
            }
            alert("Fitur lampiran belum terintegrasi dengan backend. Ini hanya simulasi frontend.");
            // Implementasi real: Anda akan memerlukan endpoint backend terpisah untuk upload file.
            // Setelah file diupload dan mendapatkan URL, Anda akan mengirimkan pesan tipe 'attachment'
            // melalui send_message.php dengan URL file tersebut.
            // Untuk simulasi, kita tetap bisa tambahkan mock message attachment ke UI sementara.
            const attachmentType = prompt("Attach: (1) Image, (2) Document, (3) Other");
            let fileName = '';
            let fileUrl = '#';
            let isImage = false;

            if (attachmentType === '1') {
                fileName = prompt("Enter image name (e.g., 'my_photo.jpg'):");
                if (fileName) {
                    fileUrl = `https://via.placeholder.com/200x150/888888/FFFFFF?text=${encodeURIComponent(fileName)}`;
                    isImage = true;
                }
            } else if (attachmentType === '2') {
                fileName = prompt("Enter document name (e.g., 'report.pdf'):");
                if (fileName) {
                    fileUrl = `https://example.com/documents/${encodeURIComponent(fileName)}`;
                }
            } else if (attachmentType === '3') {
                fileName = prompt("Enter file name (e.g., 'archive.zip'):");
                    if (fileName) {
                    fileUrl = `https://example.com/files/${encodeURIComponent(fileName)}`;
                }
            }

            if (fileName) {
                const activeChat = allChats.find(chat => chat.conversation_id_db === activeChatId);
                if (activeChat) {
                    const now = new Date();
                    const time = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
                    const date = 'Hari ini';

                    // Mock attachment message (frontend only)
                    const newMessage = {
                        sender: 'You',
                        time: time,
                        date: date,
                        type: 'attachment',
                        fileName: fileName,
                        url: fileUrl,
                        isImage: isImage
                    };
                    // In a real app, this would be sent to backend, not just pushed to client-side data
                    // For now, let's just re-fetch to see it disappear if not saved
                    alert("Lampiran ini hanya simulasi di frontend dan tidak akan tersimpan ke database. Anda perlu implementasi backend untuk upload file.");
                    // After successful upload, you'd send a message of type 'attachment'
                    // to the backend just like a normal message but with file details.
                    // For now, we'll just re-render to make it seem like it's sent.
                    // This will NOT persist unless backend is implemented.
                    // fetchAndRenderChatMessages(activeChatId);
                }
            }
        }

        // Check Details functionality
        function showProductDetails() {
            const activeChat = allChats.find(chat => chat.conversation_id_db === activeChatId);
            if (activeChat) {
                alert(`Product: ${activeChat.productName}\nCompletion Date: ${activeChat.productDate}\n\nDetails: ${activeChat.details}`);
            } else {
                alert('No chat selected or product details unavailable.');
            }
        }

        // Event Listeners
        sendButton.addEventListener('click', sendMessage);
        messageInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
        attachButton.addEventListener('click', attachFile);
        checkDetailsButton.addEventListener('click', showProductDetails);

        // Search and Filter Event Listeners
        chatSearchInput.addEventListener('input', (e) => {
            currentSearchQuery = e.target.value;
            renderChatList();
        });

        statusFilter.addEventListener('change', (e) => {
            currentStatusFilter = e.target.value;
            renderChatList();
        });

        // Sidebar active link logic (consistent across all pages)
        document.addEventListener('DOMContentLoaded', async () => {
            const currentPath = window.location.pathname;
            const sidebarLinks = document.querySelectorAll('nav a');

            sidebarLinks.forEach(link => {
                link.classList.remove('bg-gray-700', 'text-white', 'font-semibold');
                link.classList.add('text-gray-300');

                const linkPath = link.getAttribute('href').replace(/\/$/, '');
                const currentPathClean = currentPath.replace(/\/$/, '');

                if (linkPath === currentPathClean) {
                    link.classList.add('bg-gray-700', 'text-white', 'font-semibold');
                    link.classList.remove('text-gray-300');
                }
            });

            // Initial load of chat data from backend
            await fetchAndRenderChatList();

            // Set up polling for new messages/chats (simple approach for non-WebSockets)
            // Polling interval (e.g., every 5 seconds)
            setInterval(async () => {
                const oldActiveChatId = activeChatId; // Store current active chat
                await fetchAndRenderChatList(); // Fetch list which also updates messages for active chat
                // If active chat changes (e.g., due to filter), its messages will be rendered.
                // If the same chat is active, fetchAndRenderChatMessages will be called again,
                // effectively refreshing the messages.
                if (oldActiveChatId && oldActiveChatId === activeChatId) {
                    // Only re-scroll if it was already active and didn't change
                    scrollToBottom();
                }
            }, 5000); // Poll every 5 seconds
        });
    </script>
</body>

</html>