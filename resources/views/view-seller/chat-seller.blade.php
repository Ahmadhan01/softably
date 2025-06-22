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
                        'dark-hover': '#374151'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-900 text-white">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 shadow-lg">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-700">
                <div class="flex items-center space-x-3 mtp-2">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                       <img src="/img/man.jpg" alt="" class="">
                    </div>
                    <span class="text-white font-semibold">Ini Logo Web</span>
                </div>
            </div>

            <!-- Menu -->
            <div class="p-4">
                <p class="text-gray-400 text-xs uppercase tracking-wider mb-4">MENU</p>
                <nav class="space-y-2">
                    <a href="/dashboard-seller" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                        <i class="fa-solid fa-store"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="/My-product-seller" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                        <i class="fas fa-file-alt text-gray-300"></i>
                        <span>My Product</span>
                    </a>
                    <a href="/Chat-seller" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 bg-gray-700 hover:text-white transition-colors">
                        <i class="fa-solid fa-message"></i>
                        <span>Chat</span>
                    </a>
                    <a href="/Notification-seller" class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                        <i class="fa-solid fa-bell"></i>
                        <span>Notification</span>
                        <div class="flex items-center w-3 h-3 bg-green-600 rounded-full right-5 justify-center py-3 px-4">
                            <div class="flex">4</div>
                        </div>
                    </a>
                   </a>
                     <a href="/Help-Center-seller"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fa-solid fa-circle-question"></i>
                            <span>Help Center</span>
                        </a>
                </nav>
            </div>

            <!-- User Profile -->
            <div class="absolute bottom-0 w-64 p-4 border-t border-gray-700">
                <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors cursor-pointer">
                    <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center">
                        <img src="/img/man.jpg" alt="" class="rounded-full 1xl">
                    </div>
                    <div class="flex-1">
                        <p class="text-white text-sm font-medium 1xl">Fuad Store</p>
                        <p class="text-gray-400 text-xs">Store settings</p>
                    </div>
                </div>
                <div class="mt-16 space-y-2">
                    <a href="/Settings-seller" class="flex items-center space-x-3 p-2 text-gray-300 hover:text-white transition-colors">
                        <i class="fa-solid fa-gear"></i>
                        <span class="text-sm">Settings</span>
                    </a>
                    <a href="/Log-Out-seller" class="flex items-center space-x-3 p-2 text-gray-300 hover:text-white transition-colors">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="text-sm">Log Out</span>
                    </a>
                </div>
            </div>
        </div>
         <div id="chat" class="content-section flex-1 flex">
                <!-- Chat Sidebar -->
                <div class="w-70 bg-gray-800 border-r border-l border-gray-700 flex flex-col px-0 py-2 p-1 ">
                    <!-- Header dengan Search -->
                    <div class="p-2 border-b border-gray-700">
                        <div class="flex-1 font-white font-medium text-2xl p-1 mb-5">
                            <bold><h1>Chat</h1></bold>
                        </div>
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="relative flex-1">
                                <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input 
                                    type="text" 
                                    placeholder="Search people..." 
                                    class="w-full bg-gray-700 text-white pl-10 pr-3 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                            </div>
                            <select class="bg-gray-700 text-white px-1 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option>All</option>
                                <option>Online</option>
                                <option>Offline</option>
                            </select>
                        </div>
                    </div>

                    <!-- Chat List -->
                    <div class="flex-1 overflow-y-auto scrollbar-thin">
                        <!-- Ahmad Temola - Message 1 -->
                        <div class="p-4 hover:bg-gray-750 cursor-pointer transition-colors border-b border-gray-700 chat-item active">
                            <div class="flex items-start space-x-3">
                                <div class="w-9 h-9 bg-white rounded-full flex-shrink-0 flex items-center justify-center">
                                    <img src="/img/man.jpg" alt="" class="rounded-full">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex items-center space-x-2">
                                            <h4 class="text-white font-medium text-sm">Ahmad Temola</h4>
                                            <span class="text-gray-400 text-xs">21:22</span>
                                        </div>
                                    </div>
                                    <p class="text-gray-300 text-sm">Hai aku ahmad te...</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Ahmad Temola - Message 2 -->
                        <div class="p-4 hover:bg-gray-750 cursor-pointer transition-colors border-b border-gray-700 chat-item">
                            <div class="flex items-start space-x-3">
                                <div class="w-9 h-9 bg-white rounded-full flex-shrink-0 flex items-center justify-center">
                                    <img src="/img/man.jpg" alt="" class="rounded-full">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex items-center space-x-2">
                                            <h4 class="text-white font-medium text-sm">Ahmad Temola</h4>
                                            <span class="text-gray-400 text-xs">21:23</span>
                                        </div>
                                    </div>
                                    <p class="text-gray-300 text-sm">Hai aku ahmad te...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ahmad Temola - Message 3 -->
                        <div class="p-4 hover:bg-gray-750 cursor-pointer transition-colors border-b border-gray-700 chat-item">
                            <div class="flex items-start space-x-3">
                                <div class="w-9 h-9 bg-white rounded-full flex-shrink-0 flex items-center justify-center">
                                     <img src="/img/man.jpg" alt="" class="rounded-full">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex items-center space-x-2">
                                            <h4 class="text-white font-medium text-sm">Ahmad Temola</h4>
                                            <span class="text-gray-400 text-xs">21:24</span>
                                        </div>
                                    </div>
                                    <p class="text-gray-300 text-sm">Hai aku ahmad te...</p>
                                </div>
                            </div>
                        </div>

                         <!-- Ahmad Temola - Message 4 -->
                        <div class="p-4 hover:bg-gray-750 cursor-pointer transition-colors border-b border-gray-700 chat-item">
                            <div class="flex items-start space-x-3">
                                <div class="w-9 h-9 bg-white rounded-full flex-shrink-0 flex items-center justify-center">
                                     <img src="/img/man.jpg" alt="" class="rounded-full">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex items-center space-x-2">
                                            <h4 class="text-white font-medium text-sm">Ahmad Temola</h4>
                                            <span class="text-gray-400 text-xs">21:25</span>
                                        </div>
                                    </div>
                                    <p class="text-gray-300 text-sm">Hai aku ahmad te...</p>
                                </div>
                            </div>
                        </div>

                         <!-- Ahmad Temola - Message 5 -->
                        <div class="p-4 hover:bg-gray-750 cursor-pointer transition-colors border-b border-gray-700 chat-item">
                            <div class="flex items-start space-x-3">
                                <div class="w-9 h-9 bg-white rounded-full flex-shrink-0 flex items-center justify-center">
                                     <img src="/img/man.jpg" alt="" class="rounded-full">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex items-center space-x-2">
                                            <h4 class="text-white font-medium text-sm">Ahmad Temola</h4>
                                            <span class="text-gray-400 text-xs">21:26</span>
                                        </div>
                                    </div>
                                    <p class="text-gray-300 text-sm">Hai aku ahmad te...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Chat Area -->
                <div class="flex-1 flex flex-col bg-gray-900">
                    <!-- Chat Header -->
                    <div class="bg-gray-800 border-b border-gray-700 p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gray-600 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-image text-gray-300 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-white font-medium text-lg">Template Canva</h3>
                                    <p class="text-gray-400 text-sm">Selesai pada 2-2-2025</p>
                                </div>
                            </div>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Check Details
                            </button>
                        </div>
                    </div>

                    <!-- Chat Messages Area -->
                    <div class="flex-1 p-6 overflow-y-auto scrollbar-thin">
                        <div class="space-y-6">
                            <!-- Message 1 -->
                            <div class="bg-gray-800 rounded-lg hover:bg-gray-700     p-2">
                                <div class="flex items-start space-x-3 mb-1">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <h4 class="text-white font-medium text-sm">Ahmad Temola</h4>
                                            <span class="text-gray-400 text-xs">21:22</span>
                                        </div>
                                        <span class="text-blue-400 text-xs font-medium">Hari ini</span>
                                    </div>
                                </div>
                                <p class="text-gray-300 text-sm leading-relaxed">
                                    Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas suspendisse lorem. Mauris rhoncus amet purus commodo nulla tellus massa. Amet nisl nibh fermentum orci tincidunt feugiat leo id. A odio leo gravida lectus ipsum.
                                </p>
                            </div>

                            <!-- Message 2 -->
                            <div class="bg-gray-800 rounded-lg hover:bg-gray-700 p-2">
                                <div class="flex items-start space-x-3 mb-1">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <h4 class="text-white font-medium text-sm">Ahmad Temola</h4>
                                            <span class="text-gray-400 text-xs">21:23</span>
                                        </div>
                                        <span class="text-blue-400 text-xs font-medium">Hari ini</span>
                                    </div>
                                </div>
                                <p class="text-gray-300 text-sm leading-relaxed">
                                    Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas suspendisse lorem. Mauris rhoncus amet purus commodo nulla tellus massa. Amet nisl nibh fermentum orci tincidunt feugiat leo id. A odio leo gravida lectus ipsum.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Message Input Area -->
                    <div class="bg-gray-800 border-t border-gray-700 p-4">
                        <div class="flex items-center space-x-3">
                            <button class="text-gray-400 hover:text-white transition-colors">
                                <i class="fa-solid fa-paperclip text-lg"></i>
                            </button>
                            <div class="flex-1 relative">
                                <input 
                                    type="text" 
                                    placeholder="Ketik pesan..." 
                                    class="w-full bg-gray-700 text-white px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    id="messageInput"
                                >
                            </div>
                            <button class="bg-green-600 hover:bg-blue-700 text-white p-3 rounded-lg transition-colors" id="sendButton">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Navigation functionality
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all menu items
                document.querySelectorAll('.menu-item').forEach(el => {
                    el.classList.remove('active');
                });
                
                // Add active class to clicked item
                this.classList.add('active');
                
                // Hide all content sections
                document.querySelectorAll('.content-section').forEach(section => {
                    section.classList.remove('active');
                });
                
                // Show selected section
                const sectionId = this.getAttribute('data-section');
                const targetSection = document.getElementById(sectionId);
                if (targetSection) {
                    targetSection.classList.add('active');
                }
                
                // Auto-focus on message input when chat is selected
                if (sectionId === 'chat') {
                    setTimeout(() => {
                        const messageInput = document.getElementById('messageInput');
                        if (messageInput) {
                            messageInput.focus();
                        }
                    }, 100);
                }
            });
        });

        // Chat item selection functionality
        document.querySelectorAll('.chat-item').forEach(item => {
            item.addEventListener('click', function() {
                // Remove active state from all chat items
                document.querySelectorAll('.chat-item').forEach(el => {
                    el.classList.remove('bg-gray-700', 'active');
                });
                
                // Add active state to clicked item
                this.classList.add('bg-gray-700', 'active');
                
                // Get the name of the selected chat
                const chatName = this.querySelector('h4').textContent;
                console.log('Selected chat:', chatName);
            });
        });

        // Message sending functionality
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');

        function sendMessage() {
            if (messageInput) {
                const message = messageInput.value.trim();
                if (message) {
                    console.log('Sending message:', message);
                    messageInput.value = '';
                    // Here you would typically send the message to your backend
                }
            }
        }

        if (sendButton) {
            sendButton.addEventListener('click', sendMessage);
        }

        if (messageInput) {
            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });
        }
    </script>
</body>
</html>