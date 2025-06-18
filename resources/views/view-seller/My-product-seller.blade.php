<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/1531486bb6.js" crossorigin="anonymous"></script>
</head>

<body class="bg-[#23293a] text-white min-h-screen font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-[#23293a] flex flex-col justify-between border-r border-[#23293a] relative z-10">
            <div>
                <!-- Logo -->
                <div class="p-6 border-b border-gray-700 flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                        <img src="img/man.jpg" alt="" class="rounded-full">
                    </div>
                    <span class="text-white font-semibold">Ini Logo Web</span>
                </div>
                <!-- Menu -->
                <div class="p-4">
                    <p class="text-gray-400 text-xs uppercase tracking-wider mb-4">MENU</p>
                    <nav class="space-y-2">
                        <a href="/dashboard-seller"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fa-solid fa-store"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="/My-product-seller"
                            class="flex items-center space-x-3 p-3 rounded-lg bg-gray-700 text-gray-300 font-semibold transition-colors">
                            <i class="fas fa-file-alt text-gray-300"></i>
                            <span>My Product</span>
                        </a>
                        <a href="/Chat-seller"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 transition-colors">
                            <i class="fa-solid fa-message"></i>
                            <span>Chat</span>
                        </a>
                        <a href="/Notification-seller"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fa-solid fa-bell"></i>
                            <span>Notification</span>
                            <div
                                class="flex items-center w-3 h-3 bg-green-600 rounded-full right-5 justify-center py-3 px-4 ml-2">
                                <div class="flex">4</div>
                            </div>
                        </a>
                        <a href="/Help-Center-seller"
                            class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                            <i class="fa-solid fa-circle-question"></i>
                            <span>Help Center</span>
                        </a>
                    </nav>
                </div>
            </div>
            <!-- User Profile -->
            <div class="w-full p-4 border-t border-gray-700">
                <div
                    class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors cursor-pointer">
                    <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center">
                        <img src="img/man.jpg" alt="" class="rounded-full">
                    </div>
                    <div class="flex-1">
                        <p class="text-white text-sm font-medium">Fuad Store</p>
                        <p class="text-gray-400 text-xs">Store settings</p>
                    </div>
                </div>
                <div class="mt-8 space-y-2">
                    <a href="/Settings-seller"
                        class="flex items-center space-x-3 p-2 text-gray-300 hover:text-white transition-colors">
                        <i class="fa-solid fa-gear"></i>
                        <span class="text-sm">Settings</span>
                    </a>
                    <a href="/Log-out-seller"
                        class="flex items-center space-x-3 p-2 text-gray-300 hover:text-white transition-colors">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="text-sm">Log Out</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Main Content -->
        <div class="flex-1 flex border-l border-gray-700 flex-col px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b px-2 py-1 border-gray-700 mb-8 gap-3">
                <h1 class="text-2xl font-bold">My Product</h1>
                <div class="flex flex-col md:flex-row md:items-center gap-3 w-full md:w-auto">
                    <div class="flex items-center gap-3">
                        <span class="text-gray-300">Filter by</span>
                        <div class="relative">
                            <button id="filterButton"
                                class="bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-gray-700 transition-colors">
                                <span id="filterText">Best seller</span>
                                <i id="filterIcon" class="fa-solid fa-chevron-down transition-transform"></i>
                            </button>
                            <div id="filterDropdown"
                                class="absolute top-full left-0 mt-1 w-48 bg-[#29314a] border border-gray-600 rounded-lg shadow-lg z-20 hidden">
                                <div class="py-1">
                                    <button class="filter-option w-full text-left px-4 py-2 text-white hover:bg-gray-700 transition-colors" data-value="best-seller">
                                        Best seller
                                    </button>
                                    <button class="filter-option w-full text-left px-4 py-2 text-white hover:bg-gray-700 transition-colors" data-value="newest">
                                        Newest
                                    </button>
                                    <button class="filter-option w-full text-left px-4 py-2 text-white hover:bg-gray-700 transition-colors" data-value="oldest">
                                        Oldest
                                    </button>
                                    <button class="filter-option w-full text-left px-4 py-2 text-white hover:bg-gray-700 transition-colors" data-value="price-high">
                                        Price: High to Low
                                    </button>
                                    <button class="filter-option w-full text-left px-4 py-2 text-white hover:bg-gray-700 transition-colors" data-value="price-low">
                                        Price: Low to High
                                    </button>
                                    <button class="filter-option w-full text-left px-4 py-2 text-white hover:bg-gray-700 transition-colors" data-value="most-viewed">
                                        Most Viewed
                                    </button>
                                    <button class="filter-option w-full text-left px-4 py-2 text-white hover:bg-gray-700 transition-colors" data-value="rating">
                                        Highest Rating
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button id="clearFilter" class="bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 transition-colors hidden">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <div class="relative flex-1 md:flex-none">
                        <input type="text" placeholder="Search product"
                            class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg pl-10 focus:outline-none focus:border-blue-500 transition-colors" />
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-2 gap-8">
                <div class="bg-[#29314a] rounded-lg p-6 flex flex-col md:flex-row items-center gap-6">
                    <div class="w-48 h-32 bg-white rounded-lg">
                        <img src="" alt="" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="flex-1">
                        <h2 class="font-bold text-lg mb-2">Template canva</h2>
                        <p class="text-gray-300 text-sm mb-4">Lorem ipsum dolor sit amet consectetur. Pulvinar sed
                            egestas suspendisse lorem.</p>
                        <a href="/Details-Product-seller"><button
                            class="border border-gray-400 bg-blue-700 border-slate-700 px-4 py-2 rounded-lg text-white font-semibold hover:bg-blue-800 transition-colors">Check
                            Details</button>
                        </a>
                    </div>
                </div>
                <div class="bg-[#29314a] rounded-lg p-6 flex flex-col md:flex-row items-center gap-6">
                    <div class="w-48 h-32 bg-white rounded-lg">
                        <img src="" alt="" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="flex-1">
                        <h2 class="font-bold text-lg mb-2">Template canva</h2>
                        <p class="text-gray-300 text-sm mb-4">Lorem ipsum dolor sit amet consectetur. Pulvinar sed
                            egestas suspendisse lorem.</p>
                        <a href="/Details-Product-seller"><button
                            class="border border-gray-400 bg-blue-700 border-slate-700 px-4 py-2 rounded-lg text-white font-semibold hover:bg-blue-800 transition-colors">Check
                            Details</button>
                        </a>
                    </div>
                </div>
                <div class="bg-[#29314a] rounded-lg p-6 flex flex-col md:flex-row items-center gap-6">
                    <div class="w-48 h-32 bg-white rounded-lg">
                        <img src="" alt="" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="flex-1">
                        <h2 class="font-bold text-lg mb-2">Template canva</h2>
                        <p class="text-gray-300 text-sm mb-4">Lorem ipsum dolor sit amet consectetur. Pulvinar sed
                            egestas suspendisse lorem.</p>
                        <a href="/Details-Product-seller"><button
                            class="border border-gray-400 bg-blue-700 border-slate-700 px-4 py-2 rounded-lg text-white font-semibold hover:bg-blue-800 transition-colors">Check
                            Details</button>
                        </a>
                    </div>
                </div>
                <div class="bg-[#29314a] rounded-lg p-6 flex flex-col md:flex-row items-center gap-6">
                    <div class="w-48 h-32 bg-white rounded-lg">
                        <img src="" alt="" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="flex-1">
                        <h2 class="font-bold text-lg mb-2">Template canva</h2>
                        <p class="text-gray-300 text-sm mb-4">Lorem ipsum dolor sit amet consectetur. Pulvinar sed
                            egestas suspendisse lorem.</p>
                        <a href="/Details-Product-seller"><button
                            class="border border-gray-400 bg-blue-700 border-slate-700 px-4 py-2 rounded-lg text-white font-semibold hover:bg-blue-800 transition-colors">Check
                            Details</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-8">
                <a href="/Add-Product-seller"
                    class="bg-white text-[#23293a] font-semibold px-8 py-3 rounded-lg shadow hover:bg-gray-200 transition-colors">Add
                    Product</a>
            </div>
        </div>
    </div>

    <script>
        // Filter dropdown functionality
        const filterButton = document.getElementById('filterButton');
        const filterDropdown = document.getElementById('filterDropdown');
        const filterText = document.getElementById('filterText');
        const filterIcon = document.getElementById('filterIcon');
        const clearFilterBtn = document.getElementById('clearFilter');
        const filterOptions = document.querySelectorAll('.filter-option');

        // Toggle dropdown
        filterButton.addEventListener('click', () => {
            filterDropdown.classList.toggle('hidden');
            filterIcon.classList.toggle('rotate-180');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!filterButton.contains(e.target) && !filterDropdown.contains(e.target)) {
                filterDropdown.classList.add('hidden');
                filterIcon.classList.remove('rotate-180');
            }
        });

        // Handle filter option selection
        filterOptions.forEach(option => {
            option.addEventListener('click', () => {
                const selectedValue = option.getAttribute('data-value');
                const selectedText = option.textContent;
                
                // Update button text
                filterText.textContent = selectedText;
                
                // Close dropdown
                filterDropdown.classList.add('hidden');
                filterIcon.classList.remove('rotate-180');
                
                // Show clear filter button
                clearFilterBtn.classList.remove('hidden');
                
                // Here you would typically filter your products
                console.log('Filter selected:', selectedValue);
                
                // You can add your filtering logic here
                filterProducts(selectedValue);
            });
        });

        // Clear filter
        clearFilterBtn.addEventListener('click', () => {
            filterText.textContent = 'Select filter';
            clearFilterBtn.classList.add('hidden');
            
            // Reset to show all products
            console.log('Filter cleared');
            filterProducts('all');
        });

        // Filter products function (placeholder)
        function filterProducts(filterValue) {
            // This is where you would implement the actual filtering logic
            // For now, we'll just log the filter value
            console.log('Filtering products by:', filterValue);
            
            // Example: You could hide/show products based on the filter
            // const products = document.querySelectorAll('.product-card');
            // products.forEach(product => {
            //     // Your filtering logic here
            // });
        }
    </script>
</body>

</html>