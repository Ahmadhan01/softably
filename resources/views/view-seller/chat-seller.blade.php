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
                        'online-green': '#19C94A' // New color for online indicator
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
            background: #2d3748; /* dark-card */
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: #4a5568; /* gray-700 */
            border-radius: 20px;
            border: 2px solid #2d3748; /* dark-card */
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
                                <img src="/img/icon-soft.png" alt="" class="rounded-full w-full h-full object-cover" id="chatHeaderProductImage">
                            </div>
                            <div>
                                <h3 class="text-white font-medium text-lg" id="chatHeaderProductName">Template Canva</h3>
                                <p class="text-gray-400 text-sm" id="chatHeaderProductDate">Selesai pada 2-2-2025</p>
                            </div>
                        </div>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors" id="checkDetailsButton">
                            Check Details
                        </button>
                    </div>
                </div>

                <div class="flex-1 p-6 overflow-y-auto scrollbar-thin" id="chatMessagesArea">
                    <div class="space-y-6">
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
                        <button class="bg-green-600 hover:bg-blue-700 text-white p-3 rounded-lg transition-colors" id="sendButton">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mock Chat Data
        let chatData = [
            {
                id: 'chat1',
                name: 'Ahmad Temola',
                avatar: '/img/man.jpg',
                lastMessage: 'Hai aku ahmad te...',
                lastMessageTime: '12:22 AM', // Updated to current time zone (WIB)
                status: 'online', // Added status
                productName: 'Template Canva',
                productDate: '2-2-2025',
                productImage: 'https://via.placeholder.com/150/5000FF/FFFFFF?text=Canva', // Placeholder for product image
                details: 'This product is a Canva template for social media posts. It includes 10 editable designs. File type: .canva',
                messages: [
                    { sender: 'Ahmad Temola', time: '12:22 AM', date: 'Hari ini', text: 'Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas suspendisse lorem. Mauris rhoncus amet purus commodo nulla tellus massa. Amet nisl nibh fermentum orci tincidunt feugiat leo id. A odio leo gravida lectus ipsum.' },
                    { sender: 'You', time: '12:23 AM', date: 'Hari ini', text: 'Baik, ada yang bisa saya bantu terkait template ini?' },
                    { sender: 'Ahmad Temola', time: '12:23 AM', date: 'Hari ini', text: 'Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas suspendisse lorem. Mauris rhoncus amet purus commodo nulla tellus massa. Amet nisl nibh fermentum orci tincidunt feugiat leo id. A odio leo gravida lectus ipsum.' },
                    { sender: 'You', time: '12:24 AM', date: 'Hari ini', text: 'Tentu, saya akan cek detailnya.' },
                ]
            },
            {
                id: 'chat2',
                name: 'Budi Santoso',
                avatar: 'https://via.placeholder.com/40/FF5733/FFFFFF?text=BS',
                lastMessage: 'Bagaimana status order saya?',
                lastMessageTime: '10:15 AM',
                status: 'offline', // Added status
                productName: 'Custom Logo Design',
                productDate: '15-1-2025',
                productImage: 'https://via.placeholder.com/150/FF5733/FFFFFF?text=Logo', // Placeholder for product image
                details: 'This order is for a custom logo design. Initial concepts sent on 10-1-2025. Waiting for client feedback.',
                messages: [
                    { sender: 'Budi Santoso', time: '10:15 AM', date: 'Kemarin', text: 'Bagaimana status order saya?' },
                    { sender: 'You', time: '10:18 AM', date: 'Kemarin', text: 'Proses desain sedang berjalan, mohon tunggu update berikutnya.' },
                ]
            },
            {
                id: 'chat3',
                name: 'Citra Dewi',
                avatar: 'https://via.placeholder.com/40/33FF57/FFFFFF?text=CD',
                lastMessage: 'Saya ingin bertanya tentang produk...',
                lastMessageTime: '09:00 AM',
                status: 'online', // Added status
                productName: 'E-book Marketing Digital',
                productDate: '5-3-2025',
                productImage: 'https://via.placeholder.com/150/33FF57/FFFFFF?text=E-book', // Placeholder for product image
                details: 'E-book about digital marketing strategies. File type: .pdf. Version 2.0.',
                messages: [
                    { sender: 'Citra Dewi', time: '09:00 AM', date: 'Minggu lalu', text: 'Saya ingin bertanya tentang produk e-book marketing digital.' },
                    { sender: 'You', time: '09:05 AM', date: 'Minggu lalu', text: 'Tentu, apa yang ingin Anda tanyakan?' },
                ]
            },
            {
                id: 'chat4',
                name: 'Dewi Lestari',
                avatar: 'https://via.placeholder.com/40/3366FF/FFFFFF?text=DL',
                lastMessage: 'Terima kasih atas bantuannya!',
                lastMessageTime: '02:30 PM',
                status: 'offline', // Added status
                productName: 'Website Template E-commerce',
                productDate: '20-4-2025',
                productImage: 'https://via.placeholder.com/150/3366FF/FFFFFF?text=Website', // Placeholder for product image
                details: 'A fully responsive e-commerce website template. Compatible with WordPress.',
                messages: [
                    { sender: 'Dewi Lestari', time: '02:30 PM', date: '20 Jun', text: 'Terima kasih atas bantuannya!' },
                    { sender: 'You', time: '02:35 PM', date: '20 Jun', text: 'Sama-sama, senang bisa membantu!' },
                ]
            },
            {
                id: 'chat5',
                name: 'Eko Prabowo',
                avatar: 'https://via.placeholder.com/40/FF33CC/FFFFFF?text=EP',
                lastMessage: 'Kapan produk ini restock?',
                lastMessageTime: '11:00 AM',
                status: 'online', // Added status
                productName: 'Premium UI Kit',
                productDate: '10-5-2025',
                productImage: 'https://via.placeholder.com/150/FF33CC/FFFFFF?text=UI+Kit', // Placeholder for product image
                details: 'Comprehensive UI kit for mobile app development. Available for Figma and Sketch.',
                messages: [
                    { sender: 'Eko Prabowo', time: '11:00 AM', date: '15 Jun', text: 'Kapan produk Premium UI Kit ini akan restock?' },
                    { sender: 'You', time: '11:05 AM', date: '15 Jun', text: 'Mohon maaf, kami belum ada informasi restock untuk saat ini.' },
                ]
            },
        ];

        let activeChatId = 'chat1'; // Default active chat
        let currentSearchQuery = '';
        let currentStatusFilter = 'all';

        const chatList = document.getElementById('chatList');
        const chatMessagesArea = document.getElementById('chatMessagesArea');
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');
        const attachButton = document.getElementById('attachButton');
        const chatHeaderProductName = document.getElementById('chatHeaderProductName');
        const chatHeaderProductDate = document.getElementById('chatHeaderProductDate');
        const chatHeaderProductImage = document.getElementById('chatHeaderProductImage'); // New element for product image
        const checkDetailsButton = document.getElementById('checkDetailsButton');
        const chatSearchInput = document.getElementById('chatSearchInput');
        const statusFilter = document.getElementById('statusFilter');

        // Function to render chat list in sidebar
        function renderChatList() {
            chatList.innerHTML = ''; // Clear existing list

            let filteredChats = chatData.filter(chat => {
                const matchesSearch = chat.name.toLowerCase().includes(currentSearchQuery.toLowerCase());
                const matchesStatus = currentStatusFilter === 'all' || chat.status === currentStatusFilter;
                return matchesSearch && matchesStatus;
            });

            if (filteredChats.length > 0 && !filteredChats.some(chat => chat.id === activeChatId)) {
                // If the active chat is no longer in the filtered list, set the first filtered chat as active
                activeChatId = filteredChats[0].id;
                renderChatMessages(); // Re-render messages for the new active chat
            } else if (filteredChats.length === 0) {
                    // If no chats match the filter, clear main chat area
                    chatHeaderProductName.textContent = 'No Chat Selected';
                    chatHeaderProductDate.textContent = '';
                    chatHeaderProductImage.src = '';
                    chatMessagesArea.querySelector('div').innerHTML = '<p class="text-gray-400 text-center">No messages for this filter.</p>';
            }


            filteredChats.forEach(chat => {
                const isActive = chat.id === activeChatId ? 'bg-dark-hover' : 'hover:bg-dark-hover';
                const chatItem = document.createElement('div');
                chatItem.className = `p-4 ${isActive} cursor-pointer transition-colors border-b border-gray-700 chat-item`;
                chatItem.dataset.chatId = chat.id;

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
                chatList.appendChild(chatItem);

                chatItem.addEventListener('click', () => {
                    setActiveChat(chat.id);
                });
            });
        }

        // Function to render messages for the active chat
        function renderChatMessages() {
            const activeChat = chatData.find(chat => chat.id === activeChatId);
            chatMessagesArea.querySelector('div').innerHTML = ''; // Clear existing messages

            if (activeChat) {
                // Update chat header
                chatHeaderProductName.textContent = activeChat.productName;
                chatHeaderProductDate.textContent = `Selesai pada ${activeChat.productDate}`;
                chatHeaderProductImage.src = activeChat.productImage || '/img/icon-soft.png'; // Fallback to default if no product image

                activeChat.messages.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.className = 'bg-dark-card rounded-lg hover:bg-dark-hover p-2';
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
                        ${message.type === 'attachment' ?
                            `<p class="text-gray-300 text-sm leading-relaxed">
                                <i class="fa-solid fa-paperclip mr-2"></i>Attached: <a href="${message.url}" target="_blank" class="text-blue-400 hover:underline">${message.fileName}</a>
                                ${message.isImage ? `<br><img src="${message.url}" class="max-w-xs mt-2 rounded-md">` : ''}
                            </p>` :
                            `<p class="text-gray-300 text-sm leading-relaxed">${message.text}</p>`
                        }
                    `;
                    chatMessagesArea.querySelector('div').appendChild(messageElement);
                });
                scrollToBottom();
            }
        }

        // Function to set active chat
        function setActiveChat(id) {
            activeChatId = id;
            renderChatList(); // Re-render chat list to update active state
            renderChatMessages(); // Render messages for the new active chat
        }

        // Scroll chat to bottom
        function scrollToBottom() {
            chatMessagesArea.scrollTop = chatMessagesArea.scrollHeight;
        }

        // Send Message functionality
        function sendMessage() {
            const message = messageInput.value.trim();
            if (message) {
                const activeChat = chatData.find(chat => chat.id === activeChatId);
                if (activeChat) {
                    const now = new Date();
                    // Format time to HH:MM AM/PM
                    const time = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
                    const date = 'Hari ini'; // You can make this dynamic if needed

                    const newMessage = { sender: 'You', time: time, date: date, text: message };
                    activeChat.messages.push(newMessage);
                    activeChat.lastMessage = message; // Update last message in sidebar
                    activeChat.lastMessageTime = time; // Update last message time in sidebar

                    renderChatMessages(); // Re-render messages for current chat
                    renderChatList(); // Re-render chat list to update last message preview
                    messageInput.value = ''; // Clear input
                }
            }
        }

        // Attach File/Image functionality (simulated)
        function attachFile() {
            // In a real application, you'd open a file input here.
            // For simulation, we'll prompt for type and then file name.
            const attachmentType = prompt("Attach: (1) Image, (2) Document, (3) Other");
            let fileName = '';
            let fileUrl = '#';
            let isImage = false;

            if (attachmentType === '1') {
                fileName = prompt("Enter image name (e.g., 'my_photo.jpg'):");
                if (fileName) {
                    // Use a placeholder image that changes with filename for variety
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
                const activeChat = chatData.find(chat => chat.id === activeChatId);
                if (activeChat) {
                    const now = new Date();
                    const time = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
                    const date = 'Hari ini';

                    const newMessage = {
                        sender: 'You',
                        time: time,
                        date: date,
                        type: 'attachment',
                        fileName: fileName,
                        url: fileUrl,
                        isImage: isImage
                    };
                    activeChat.messages.push(newMessage);
                    activeChat.lastMessage = `[File: ${fileName}]`; // Update last message for attachment
                    activeChat.lastMessageTime = time;

                    renderChatMessages();
                    renderChatList();
                }
            }
        }

        // Check Details functionality
        function showProductDetails() {
            const activeChat = chatData.find(chat => chat.id === activeChatId);
            if (activeChat) {
                alert(`Product: ${activeChat.productName}\nCompletion Date: ${activeChat.productDate}\n\nDetails: ${activeChat.details}`);
            } else {
                alert('No chat selected or product details unavailable.');
            }
        }

        // Event Listeners
        sendButton.addEventListener('click', sendMessage);
        messageInput.addEventListener('keypress', function(e) {
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

        // Sidebar active link logic
        document.addEventListener('DOMContentLoaded', () => {
            const currentPath = window.location.pathname;
            const sidebarLinks = document.querySelectorAll('nav a');

            sidebarLinks.forEach(link => {
                link.classList.remove('bg-gray-700', 'text-white', 'font-semibold');
                link.classList.add('text-gray-300');

                // Adjust path comparison for robustness if paths might have trailing slashes
                const linkPath = link.getAttribute('href').replace(/\/$/, '');
                const currentPathClean = currentPath.replace(/\/$/, '');

                if (linkPath === currentPathClean) {
                    link.classList.add('bg-gray-700', 'text-white', 'font-semibold');
                    link.classList.remove('text-gray-300');
                }
            });

            // Initial render of chat components
            renderChatList();
            // If renderChatList sets an activeChatId (e.g., first filtered chat), render its messages
            if (chatData.find(chat => chat.id === activeChatId)) {
                renderChatMessages();
            }
        });
    </script>
</body>
</html>