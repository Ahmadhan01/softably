<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-[#23293a] text-white min-h-screen font-sans">
    <div class="flex min-h-screen">
        <div class="w-64 bg-[#23293a] flex flex-col justify-between border-r border-[#23293a] relative z-10">
            <div>
                <div class="p-6 border-b border-gray-700 flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center">
                        <img src="img/man.jpg" alt="" class="rounded-full">
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
                        <img src="img/man.jpg" alt="" class="rounded-full">
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
                    <a href="/Log-out-seller" id="logout-link"
                        class="flex items-center space-x-3 p-2 text-gray-300 hover:text-white transition-colors">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="text-sm">Log Out</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="flex-1 flex border-l border-gray-700 flex-col px-8 py-8">
            <div
                class="flex flex-col md:flex-row md:items-center md:justify-between border-b px-2 py-1 border-gray-700 mb-8 gap-3">
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
                                    <button
                                        class="filter-option w-full text-left px-4 py-2 text-white hover:bg-gray-700 transition-colors"
                                        data-value="best-seller">
                                        Best seller
                                    </button>
                                    <button
                                        class="filter-option w-full text-left px-4 py-2 text-white hover:bg-gray-700 transition-colors"
                                        data-value="newest">
                                        Newest
                                    </button>
                                    <button
                                        class="filter-option w-full text-left px-4 py-2 text-white hover:bg-gray-700 transition-colors"
                                        data-value="oldest">
                                        Oldest
                                    </button>
                                    <button
                                        class="filter-option w-full text-left px-4 py-2 text-white hover:bg-gray-700 transition-colors"
                                        data-value="price-high">
                                        Price: High to Low
                                    </button>
                                    <button
                                        class="filter-option w-full text-left px-4 py-2 text-white hover:bg-gray-700 transition-colors"
                                        data-value="price-low">
                                        Price: Low to High
                                    </button>
                                    <button
                                        class="filter-option w-full text-left px-4 py-2 text-white hover:bg-gray-700 transition-colors"
                                        data-value="most-viewed">
                                        Most Viewed
                                    </button>
                                    <button
                                        class="filter-option w-full text-left px-4 py-2 text-white hover:bg-gray-700 transition-colors"
                                        data-value="rating">
                                        Highest Rating
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button id="clearFilter"
                            class="bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 transition-colors hidden">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <div class="relative flex-1 md:flex-none">
                        <input type="text" placeholder="Search product"
                            class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg pl-10 focus:outline-none focus:border-blue-500 transition-colors"
                            id="productSearchInput" />
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-2 gap-8"
                id="productGrid">
                </div>
            <div class="flex justify-end mt-8">
                <a href="/Add-Product-seller"
                    class="bg-white text-[#23293a] font-semibold px-8 py-3 rounded-lg shadow hover:bg-gray-200 transition-colors">Add
                    Product</a>
            </div>
        </div>
    </div>

    <script>
        // Sample product data - **IMPORTANT: This data needs to be available on both pages.**
        // In a real application, you'd fetch this from a backend API or a shared data store.
        // For this example, we'll make it a global constant.
        const allProducts = [
            {
                id: 'prod001', // Added unique ID for each product
                name: "Template Canva Bisnis Profesional",
                description: "Kumpulan template Canva siap pakai untuk keperluan promosi bisnis Anda. Desain modern, mudah diedit dan disesuaikan untuk berbagai platform media sosial.",
                imageUrl: "https://via.placeholder.com/300x200/4A5568/CBD5E0?Text=Canva+Bisnis",
                price: 150000,
                views: 1200,
                rating: 4.8,
                addedDate: "2024-01-15",
                isBestSeller: true,
                sold: 40700,
                wish: 1500,
                cart: 2000
            },
            {
                id: 'prod002',
                name: "Ebook Panduan Lengkap SEO Pemula",
                description: "Pelajari dasar-dasar Search Engine Optimization (SEO) dari nol hingga mahir untuk meningkatkan visibilitas website Anda di mesin pencari Google dan lainnya.",
                imageUrl: "https://via.placeholder.com/300x200/718096/E2E8F0?Text=SEO+Pemula",
                price: 95000,
                views: 850,
                rating: 4.5,
                addedDate: "2024-03-20",
                isBestSeller: false,
                sold: 11200,
                wish: 800,
                cart: 100
            },
            {
                id: 'prod003',
                name: "Preset Lightroom Mobile Estetik",
                description: "Koleksi preset Lightroom untuk perangkat mobile yang akan membuat foto Anda terlihat lebih profesional dan konsisten dengan sentuhan estetik hanya dengan satu klik.",
                imageUrl: "https://via.placeholder.com/300x200/A0AEC0/F7FAFC?Text=LR+Mobile",
                price: 70000,
                views: 1500,
                rating: 4.9,
                addedDate: "2023-11-01",
                isBestSeller: true,
                sold: 23400,
                wish: 2100,
                cart: 500
            },
            {
                id: 'prod004',
                name: "Paket Ikon Media Sosial Modern",
                description: "Set ikon media sosial lengkap dalam berbagai gaya dan format (SVG, PNG). Cocok untuk website, aplikasi, dan desain promosi Anda. Desain minimalis dan modern.",
                imageUrl: "https://via.placeholder.com/300x200/CBD5E0/2D3748?Text=Social+Icons",
                price: 50000,
                views: 600,
                rating: 4.2,
                addedDate: "2024-02-10",
                isBestSeller: false,
                sold: 8900,
                wish: 300,
                cart: 70
            },
            {
                id: 'prod005',
                name: "Kursus Online Master Web Development",
                description: "Pelajari cara membuat website interaktif dari nol dengan kursus online ini. Materi lengkap dari HTML, CSS, JavaScript hingga framework modern. Termasuk proyek-proyek praktis.",
                imageUrl: "https://via.placeholder.com/300x200/E2E8F0/4A5568?Text=Web+Dev",
                price: 250000,
                views: 900,
                rating: 4.7,
                addedDate: "2024-04-05",
                isBestSeller: false,
                sold: 3000,
                wish: 100,
                cart: 50
            },
            {
                id: 'prod006',
                name: "Font Premium Eksklusif (Lisensi Penuh)",
                description: "Koleksi font premium dengan desain unik dan elegan untuk meningkatkan tampilan visual proyek desain Anda. Dilengkapi lisensi penuh untuk penggunaan komersial.",
                imageUrl: "https://via.placeholder.com/300x200/F7FAFC/718096?Text=Premium+Fonts",
                price: 180000,
                views: 720,
                rating: 4.6,
                addedDate: "2023-10-25",
                isBestSeller: true,
                sold: 15000,
                wish: 700,
                cart: 120
            },
            {
                id: 'prod007',
                name: "Mockup T-Shirt Kustom Berkualitas Tinggi",
                description: "File mockup PSD berkualitas tinggi untuk presentasi desain kaos Anda. Mudah digunakan dengan smart object. Tersedia berbagai sudut pandang dan pilihan latar belakang.",
                imageUrl: "https://via.placeholder.com/300x200/6B7280/D1D5DB?Text=T-Shirt+Mockup",
                price: 60000,
                views: 1100,
                rating: 4.4,
                addedDate: "2024-01-01",
                isBestSeller: false,
                sold: 5000,
                wish: 250,
                cart: 80
            },
            {
                id: 'prod008',
                name: "Template Presentasi Bisnis Modern",
                description: "Template presentasi PowerPoint/Keynote/Google Slides dengan desain minimalis dan profesional. Cocok untuk proposal bisnis, pitch deck, dan laporan tahunan Anda.",
                imageUrl: "https://via.placeholder.com/300x200/9CA3AF/1F2937?Text=PPT+Template",
                price: 120000,
                views: 950,
                rating: 4.7,
                addedDate: "2024-03-01",
                isBestSeller: true,
                sold: 7200,
                wish: 400,
                cart: 90
            }
        ];

        let currentFilteredProducts = [...allProducts]; // Initialize with all products
        let currentSearchTerm = '';
        let currentFilterValue = 'best-seller'; // Default filter

        const productGrid = document.getElementById('productGrid');
        const productSearchInput = document.getElementById('productSearchInput');


        function generateProductCard(product) {
            return `
                <div class="bg-[#29314a] rounded-lg p-6 flex flex-col md:flex-row items-center gap-6">
                    <div class="w-48 h-32 bg-white rounded-lg overflow-hidden flex-shrink-0">
                        <img src="${product.imageUrl || 'https://via.placeholder.com/300x200/6B7280/D1D5DB?Text=No+Image'}" alt="${product.name}" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="flex-1">
                        <h2 class="font-bold text-lg mb-2">${product.name}</h2>
                        <p class="text-gray-300 text-sm mb-4">${product.description}</p>
                        <p class="text-white text-md font-semibold mb-2">Rp ${product.price.toLocaleString('id-ID')}</p>
                        <div class="flex items-center text-gray-400 text-sm mb-4">
                            <i class="fa-solid fa-star text-yellow-400 mr-1"></i> ${product.rating} 
                            <span class="ml-2 mr-1">|</span> Dilihat: ${product.views.toLocaleString('id-ID')}
                        </div>
                        <button class="check-details-btn border border-gray-400 bg-blue-700 border-slate-700 px-4 py-2 rounded-lg text-white font-semibold hover:bg-blue-800 transition-colors" 
                                data-product-id="${product.id}">
                            Check Details
                        </button>
                    </div>
                </div>
            `;
        }

        function displayProducts(productsToDisplay) {
            productGrid.innerHTML = ''; // Clear existing content
            if (productsToDisplay.length === 0) {
                productGrid.innerHTML = '<p class="text-center text-gray-400 col-span-full">No products found matching your criteria.</p>';
                return;
            }

            productsToDisplay.forEach(product => {
                productGrid.innerHTML += generateProductCard(product);
            });

            // Add event listeners to the "Check Details" buttons after they are added to the DOM
            const checkDetailsButtons = document.querySelectorAll('.check-details-btn');
            checkDetailsButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    // Redirect to the details page with the product ID in the URL
                    window.location.href = `/Details-Product-seller?id=${productId}`;
                });
            });
        }

        function applyFiltersAndSearch() {
            let filtered = [...allProducts];

            // Apply search filter
            if (currentSearchTerm) {
                filtered = filtered.filter(product =>
                    product.name.toLowerCase().includes(currentSearchTerm.toLowerCase()) ||
                    product.description.toLowerCase().includes(currentSearchTerm.toLowerCase())
                );
            }

            // Apply sort filter
            switch (currentFilterValue) {
                case 'best-seller':
                    // Sort by isBestSeller (true first), then by views (desc)
                    filtered.sort((a, b) => (b.isBestSeller - a.isBestSeller) || (b.views - a.views));
                    break;
                case 'newest':
                    filtered.sort((a, b) => new Date(b.addedDate) - new Date(a.addedDate));
                    break;
                case 'oldest':
                    filtered.sort((a, b) => new Date(a.addedDate) - new Date(b.addedDate));
                    break;
                case 'price-high':
                    filtered.sort((a, b) => b.price - a.price);
                    break;
                case 'price-low':
                    filtered.sort((a, b) => a.price - b.price);
                    break;
                case 'most-viewed':
                    filtered.sort((a, b) => b.views - a.views);
                    break;
                case 'rating':
                    filtered.sort((a, b) => b.rating - a.rating);
                    break;
            }

            currentFilteredProducts = filtered;
            displayProducts(currentFilteredProducts);
        }


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

                filterText.textContent = selectedText;
                currentFilterValue = selectedValue; // Update current filter value

                filterDropdown.classList.add('hidden');
                filterIcon.classList.remove('rotate-180');

                clearFilterBtn.classList.remove('hidden');

                applyFiltersAndSearch(); // Apply filters and search
            });
        });

        // Clear filter
        clearFilterBtn.addEventListener('click', () => {
            filterText.textContent = 'Best seller'; // Reset to default text
            currentFilterValue = 'best-seller'; // Reset current filter value
            clearFilterBtn.classList.add('hidden');

            // Optionally, also clear search term if desired when clearing filter
            // productSearchInput.value = '';
            // currentSearchTerm = '';

            applyFiltersAndSearch(); // Apply filters and search to show all (or default)
        });

        // Search input functionality
        productSearchInput.addEventListener('input', (e) => {
            currentSearchTerm = e.target.value;
            applyFiltersAndSearch(); // Apply filters and search
        });


        // Sidebar active link logic (consistent across all pages)
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

            // Initial display of products when the page loads
            applyFiltersAndSearch(); // Call this to initially render products based on default filter/search
        });
    </script>
</body>

</html>