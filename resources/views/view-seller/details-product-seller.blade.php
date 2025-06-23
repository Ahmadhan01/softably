<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details Product</title>
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
                        'yellow-400': '#facc15', // Added for star rating
                        'yellow-500': '#eab308' // Added for Product Wish box
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
                        <img src="img/icon-soft.png" alt="" class="rounded-full">
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
                    <a href="/Log-Out-seller" id="logout-link"
                        class="flex items-center space-x-3 p-2 text-gray-300 hover:text-white transition-colors">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="text-sm">Log Out</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="flex-1 flex flex-col px-8 py-8">
            <div class="flex items-center mb-8 gap-4">
                <a href="/My-product-seller" class="text-white hover:text-gray-300"><i
                        class="fa-solid fa-arrow-left text-xl"></i></a>
                <h1 class="text-2xl font-bold">Details Product</h1>
            </div>
            <div class="bg-[#29314a] rounded-lg p-8 mb-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="flex-shrink-0 w-full lg:w-1/3 flex flex-col items-center">
                        <div class="w-72 h-56 bg-white rounded-lg mb-4">
                            <img src="" id="productImage" alt="Product Image" class="w-full h-full object-cover rounded-lg">
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-400 rounded-full flex items-center justify-center">
                                    <img src="img/man.jpg" alt="Shop Avatar" class="rounded-full w-full h-full object-cover">
                                </div>
                                <span class="font-semibold">Toko Ahmad</span>
                            </div>
                            <button id="editProductBtn" class="border bg-yellow-700 hover:bg-yellow-800 border-slate-700 text-white px-4 py-2 rounded-lg font-semibold">Edit</button>
                        </div>
                        <h2 class="font-bold text-xl" id="productName"></h2>
                        <p class="text-gray-300 text-sm" id="productDescription"></p>
                        <div class="text-3xl font-bold text-yellow-400 mt-2" id="productPrice"></div>
                        <div class="flex items-center text-gray-400 text-sm">
                            <i class="fa-solid fa-star text-yellow-400 mr-1"></i> <span id="productRating"></span> 
                            <span class="ml-2 mr-1">|</span> Dilihat: <span id="productViews"></span>
                            <span class="ml-2 mr-1">|</span> Ditambahkan: <span id="productAddedDate"></span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <div class="bg-green-600 rounded-lg p-4 flex flex-col items-center">
                                <span class="text-white font-semibold text-sm">Product Sold</span>
                                <span class="text-2xl font-bold" id="productSold">0</span>
                            </div>
                            <div class="bg-yellow-500 rounded-lg p-4 flex flex-col items-center">
                                <span class="text-white font-semibold text-sm">Product Wish</span>
                                <span class="text-2xl font-bold" id="productWish">0</span>
                            </div>
                            <div class="bg-blue-600 rounded-lg p-4 flex flex-col items-center">
                                <span class="text-white font-semibold text-sm">Product Cart</span>
                                <span class="text-2xl font-bold" id="productCart">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-[#29314a] rounded-lg p-8 mb-8">
                <button type="button" class="flex items-center justify-between w-full mb-4"
                    onclick="toggleSection('transactionSection', 'transactionIcon')">
                    <h2 class="font-bold text-lg">Recent Transaction</h2>
                    <i id="transactionIcon" class="fa-solid fa-chevron-down transition-transform"></i>
                </button>
                <div id="transactionSection" class="space-y-2">
                    </div>
            </div>
            <div class="bg-[#29314a] rounded-lg p-8">
                <button type="button" class="flex items-center justify-between w-full mb-4"
                    onclick="toggleSection('commentSection', 'commentIcon')">
                    <h2 class="font-bold text-lg">Comment</h2>
                    <i id="commentIcon" class="fa-solid fa-chevron-down transition-transform"></i>
                </button>
                <div id="commentSection" class="space-y-4">
                    </div>
            </div>
        </div>
    </div>

    <script>
        // Common product data (MUST be identical to the one in My-product-seller.html)
        const allProducts = [
            {
                id: 'prod001',
                name: "Template Canva Bisnis Profesional",
                description: "Kumpulan template Canva siap pakai untuk keperluan promosi bisnis Anda. Desain modern, mudah diedit dan disesuaikan untuk berbagai platform media sosial.",
                imageUrl: "https://via.placeholder.com/400x300/4A5568/CBD5E0?Text=Canva+Bisnis",
                price: 150000,
                views: 1200,
                rating: 4.8,
                addedDate: "2024-01-15",
                isBestSeller: true,
                sold: 40700,
                wish: 1500,
                cart: 2000,
                transactions: [
                    { customer: 'Ahmad Nudy', email: 'ahmadnudy@gmail.com', phone: '+62 8765 2324 2342' },
                    { customer: 'Budi Doremi', email: 'budi.doremi@example.com', phone: '+62 8123 1234 5678' }
                ],
                comments: [
                    { user: 'Fajar Baskial', avatar: 'https://via.placeholder.com/40/FF5733/FFFFFF?text=FB', text: 'Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas suspendisse lorem. Mauris neque amet purus commodo nulla tellus massa. Amet nisi nibh fermentum cras tincidunt feugiat leo id. A odio leo gravida lectus ipsum.', shopReply: 'Lorem ipsum dolor sit amet consectetur.' },
                    { user: 'Siti Khadijah', avatar: 'https://via.placeholder.com/40/3366FF/FFFFFF?text=SK', text: 'Produk ini sangat membantu pekerjaan saya! Sangat direkomendasikan untuk pebisnis pemula.', shopReply: 'Sangat puas dengan pembelian ini.' }
                ]
            },
            {
                id: 'prod002',
                name: "Ebook Panduan Lengkap SEO Pemula",
                description: "Pelajari dasar-dasar Search Engine Optimization (SEO) dari nol hingga mahir untuk meningkatkan visibilitas website Anda di mesin pencari Google dan lainnya.",
                imageUrl: "https://via.placeholder.com/400x300/718096/E2E8F0?Text=SEO+Pemula",
                price: 95000,
                views: 850,
                rating: 4.5,
                addedDate: "2024-03-20",
                isBestSeller: false,
                sold: 11200,
                wish: 800,
                cart: 100,
                transactions: [
                    { customer: 'Dina Amelia', email: 'dina.amelia@example.com', phone: '+62 8987 6543 2109' }
                ],
                comments: [
                    { user: 'Rizky Pratama', avatar: 'https://via.placeholder.com/40/FFCC00/FFFFFF?text=RP', text: 'Ebooknya sangat informatif dan mudah dipahami. Terima kasih!', shopReply: 'Senang bisa membantu!' }
                ]
            },
            {
                id: 'prod003',
                name: "Preset Lightroom Mobile Estetik",
                description: "Koleksi preset Lightroom untuk perangkat mobile yang akan membuat foto Anda terlihat lebih profesional dan konsisten dengan sentuhan estetik hanya dengan satu klik.",
                imageUrl: "https://via.placeholder.com/400x300/A0AEC0/F7FAFC?Text=LR+Mobile",
                price: 70000,
                views: 1500,
                rating: 4.9,
                addedDate: "2023-11-01",
                isBestSeller: true,
                sold: 23400,
                wish: 2100,
                cart: 500,
                transactions: [
                    { customer: 'Faisal Hadi', email: 'faisal.hadi@example.com', phone: '+62 8567 8901 2345' },
                    { customer: 'Gita Saraswati', email: 'gita.saraswati@example.com', phone: '+62 8789 0123 4567' },
                    { customer: 'Hanif Putra', email: 'hanif.putra@example.com', phone: '+62 8112 2334 4556' }
                ],
                comments: [
                    { user: 'Yoga Saputra', avatar: 'https://via.placeholder.com/40/00FFFF/FFFFFF?text=YS', text: 'Presetsnya luar biasa! Foto-foto saya jadi lebih hidup. 👍', shopReply: '' }
                ]
            },
            {
                id: 'prod004',
                name: "Paket Ikon Media Sosial Modern",
                description: "Set ikon media sosial lengkap dalam berbagai gaya dan format (SVG, PNG). Cocok untuk website, aplikasi, dan desain promosi Anda. Desain minimalis dan modern.",
                imageUrl: "https://via.placeholder.com/400x300/CBD5E0/2D3748?Text=Social+Icons",
                price: 50000,
                views: 600,
                rating: 4.2,
                addedDate: "2024-02-10",
                isBestSeller: false,
                sold: 8900,
                wish: 300,
                cart: 70,
                transactions: [],
                comments: []
            },
            {
                id: 'prod005',
                name: "Kursus Online Master Web Development",
                description: "Pelajari cara membuat website interaktif dari nol dengan kursus online ini. Materi lengkap dari HTML, CSS, JavaScript hingga framework modern. Termasuk proyek-proyek praktis.",
                imageUrl: "https://via.placeholder.com/400x300/E2E8F0/4A5568?Text=Web+Dev",
                price: 250000,
                views: 900,
                rating: 4.7,
                addedDate: "2024-04-05",
                isBestSeller: false,
                sold: 3000,
                wish: 100,
                cart: 50,
                transactions: [
                    { customer: 'Indra Jaya', email: 'indra.jaya@example.com', phone: '+62 8223 3445 5667' }
                ],
                comments: [
                    { user: 'Joko Susanto', avatar: 'https://via.placeholder.com/40/FF0000/FFFFFF?text=JS', text: 'Kursusnya terlalu cepat, butuh lebih banyak latihan.', shopReply: 'Terima kasih atas masukannya, akan kami pertimbangkan untuk perbaikan.' }
                ]
            },
            {
                id: 'prod006',
                name: "Font Premium Eksklusif (Lisensi Penuh)",
                description: "Koleksi font premium dengan desain unik dan elegan untuk meningkatkan tampilan visual proyek desain Anda. Dilengkapi lisensi penuh untuk penggunaan komersial.",
                imageUrl: "https://via.placeholder.com/400x300/F7FAFC/718096?Text=Premium+Fonts",
                price: 180000,
                views: 720,
                rating: 4.6,
                addedDate: "2023-10-25",
                isBestSeller: true,
                sold: 15000,
                wish: 700,
                cart: 120,
                transactions: [
                    { customer: 'Kiki Amalia', email: 'kiki.amalia@example.com', phone: '+62 8111 2223 3344' }
                ],
                comments: []
            },
            {
                id: 'prod007',
                name: "Mockup T-Shirt Kustom Berkualitas Tinggi",
                description: "File mockup PSD berkualitas tinggi untuk presentasi desain kaos Anda. Mudah digunakan dengan smart object. Tersedia berbagai sudut pandang dan pilihan latar belakang.",
                imageUrl: "https://via.placeholder.com/400x300/6B7280/D1D5DB?Text=T-Shirt+Mockup",
                price: 60000,
                views: 1100,
                rating: 4.4,
                addedDate: "2024-01-01",
                isBestSeller: false,
                sold: 5000,
                wish: 250,
                cart: 80,
                transactions: [
                    { customer: 'Lina Marlina', email: 'lina.marlina@example.com', phone: '+62 8578 9012 3456' },
                    { customer: 'Maman Sudirman', email: 'maman.s@example.com', phone: '+62 8334 4556 6778' }
                ],
                comments: [
                    { user: 'Nia Kurnia', avatar: 'https://via.placeholder.com/40/0000FF/FFFFFF?text=NK', text: 'Mockupnya sangat realistis, detailnya bagus sekali!', shopReply: '' }
                ]
            },
            {
                id: 'prod008',
                name: "Template Presentasi Bisnis Modern",
                description: "Template presentasi PowerPoint/Keynote/Google Slides dengan desain minimalis dan profesional. Cocok untuk proposal bisnis, pitch deck, dan laporan tahunan Anda.",
                imageUrl: "https://via.placeholder.com/400x300/9CA3AF/1F2937?Text=PPT+Template",
                price: 120000,
                views: 950,
                rating: 4.7,
                addedDate: "2024-03-01",
                isBestSeller: true,
                sold: 7200,
                wish: 400,
                cart: 90,
                transactions: [
                    { customer: 'Oscar Wijaya', email: 'oscar.w@example.com', phone: '+62 8199 8877 6655' }
                ],
                comments: [
                    { user: 'Putri Ayu', avatar: 'https://via.placeholder.com/40/FFC0CB/FFFFFF?text=PA', text: 'Desainnya bersih dan elegan. Sangat mudah diedit!', shopReply: 'Terima kasih atas ulasannya!' }
                ]
            }
        ];

        // Function to parse URL parameters
        function getQueryParams() {
            const params = {};
            window.location.search.substring(1).split('&').forEach(param => {
                const parts = param.split('=');
                if (parts[0]) {
                    params[decodeURIComponent(parts[0])] = decodeURIComponent(parts[1] || '');
                }
            });
            return params;
        }

        // Function to render product details
        function renderProductDetails(productId) {
            const product = allProducts.find(p => p.id === productId);

            if (product) {
                document.getElementById('productImage').src = product.imageUrl;
                document.getElementById('productName').textContent = product.name;
                document.getElementById('productDescription').textContent = product.description;
                document.getElementById('productPrice').textContent = `Rp ${product.price.toLocaleString('id-ID')}`;
                document.getElementById('productRating').textContent = product.rating;
                document.getElementById('productViews').textContent = product.views.toLocaleString('id-ID');
                document.getElementById('productAddedDate').textContent = product.addedDate;
                document.getElementById('productSold').textContent = product.sold.toLocaleString('id-ID');
                document.getElementById('productWish').textContent = product.wish.toLocaleString('id-ID');
                document.getElementById('productCart').textContent = product.cart.toLocaleString('id-ID');

                // Render Transactions
                const transactionSection = document.getElementById('transactionSection');
                transactionSection.innerHTML = ''; // Clear existing
                if (product.transactions && product.transactions.length > 0) {
                    product.transactions.forEach(tx => {
                        const txDiv = document.createElement('div');
                        txDiv.className = 'flex items-center justify-between bg-[#23293a] rounded-lg p-4';
                        txDiv.innerHTML = `
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center"><i
                                        class="fa-solid fa-user text-white"></i></div>
                                <span>${tx.customer}</span>
                            </div>
                            <span class="text-gray-300">${tx.email}</span>
                            <span class="text-gray-300">${tx.phone}</span>
                        `;
                        transactionSection.appendChild(txDiv);
                    });
                } else {
                    transactionSection.innerHTML = '<p class="text-center text-gray-400">No recent transactions for this product.</p>';
                }


                // Render Comments
                const commentSection = document.getElementById('commentSection');
                commentSection.innerHTML = ''; // Clear existing
                if (product.comments && product.comments.length > 0) {
                    product.comments.forEach(comment => {
                        const commentDiv = document.createElement('div');
                        commentDiv.className = 'bg-[#23293a] rounded-lg p-4';
                        commentDiv.innerHTML = `
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-gray-400 rounded-full flex items-center justify-center">
                                    <img src="${comment.avatar || 'https://via.placeholder.com/40/CCCCCC/000000?text=U'}" alt="User Avatar" class="rounded-full w-full h-full object-cover">
                                </div>
                                <span class="font-semibold">${comment.user}</span>
                            </div>
                            <p class="text-gray-300 text-sm mb-2">${comment.text}</p>
                            ${comment.shopReply ? `
                                <div class="flex items-center gap-2">
                                    <span class="bg-gray-700 text-white px-3 py-1 rounded-lg text-xs">Toko Ahmad</span>
                                    <span class="text-gray-400 text-xs">${comment.shopReply}</span>
                                </div>` : ''}
                            <div class="flex gap-2 mt-2">
                                <button class="border border-slate-700 hover:bg-green-900 bg-red-600 text-white px-4 py-2 rounded-lg font-semibold flex items-center gap-2 delete-comment-btn"><i
                                        class="fa-solid fa-trash"></i>Delete</button>
                                <button class="bg-blue-700 border border-slate-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg font-semibold reply-comment-btn">Reply</button>
                            </div>
                        `;
                        commentSection.appendChild(commentDiv);
                    });

                    // Add event listeners for new delete/reply buttons
                    document.querySelectorAll('.delete-comment-btn').forEach(button => {
                        button.addEventListener('click', () => alert('Delete comment clicked (simulated)!'));
                    });
                    document.querySelectorAll('.reply-comment-btn').forEach(button => {
                        button.addEventListener('click', () => prompt('Reply to comment:'));
                    });

                } else {
                    commentSection.innerHTML = '<p class="text-center text-gray-400">No comments for this product.</p>';
                }

            } else {
                // Handle case where product is not found
                document.getElementById('productName').textContent = 'Product Not Found';
                document.getElementById('productDescription').textContent = 'The requested product could not be found.';
                document.getElementById('productPrice').textContent = '';
                document.getElementById('productImage').src = 'https://via.placeholder.com/400x300/FF0000/FFFFFF?text=Product+Not+Found';
                document.getElementById('productRating').textContent = '';
                document.getElementById('productViews').textContent = '';
                document.getElementById('productAddedDate').textContent = '';
                document.getElementById('productSold').textContent = 'N/A';
                document.getElementById('productWish').textContent = 'N/A';
                document.getElementById('productCart').textContent = 'N/A';
                document.getElementById('transactionSection').innerHTML = '<p class="text-center text-gray-400">No recent transactions for this product.</p>';
                document.getElementById('commentSection').innerHTML = '<p class="text-center text-gray-400">No comments for this product.</p>';
            }
        }

        // Collapsible section logic
        function toggleSection(sectionId, iconId) {
            const section = document.getElementById(sectionId);
            const icon = document.getElementById(iconId);
            if (section.classList.contains('hidden')) {
                section.classList.remove('hidden');
                icon.classList.remove('rotate-180');
            } else {
                section.classList.add('hidden');
                icon.classList.add('rotate-180');
            }
        }

        // Sidebar active link logic (consistent across all pages)
        document.addEventListener('DOMContentLoaded', () => {
            const currentPath = window.location.pathname;
            const sidebarLinks = document.querySelectorAll('nav a');

            sidebarLinks.forEach(link => {
                link.classList.remove('bg-gray-700', 'text-white', 'font-semibold');
                link.classList.add('text-gray-300');

                const linkPath = link.getAttribute('href').replace(/\/$/, '').replace(/\.html$/, '');
                const currentPathClean = currentPath.replace(/\/$/, '').replace(/\.html$/, '');

                if (linkPath === currentPathClean) {
                    link.classList.add('bg-gray-700', 'text-white', 'font-semibold');
                    link.classList.remove('text-gray-300');
                }
            });

            // Get product ID from URL and render details
            const queryParams = getQueryParams();
            const productId = queryParams.id;
            if (productId) {
                renderProductDetails(productId);
            } else {
                // Display a message if no product ID is provided
                document.getElementById('productName').textContent = 'No Product Selected';
                document.getElementById('productDescription').textContent = 'Please select a product from the "My Product" page.';
                // You might hide other elements or show a default empty state
                document.getElementById('productPrice').textContent = '';
                document.getElementById('productImage').src = 'https://via.placeholder.com/400x300/DDDDDD/666666?text=Select+Product';
                document.getElementById('productRating').textContent = '';
                document.getElementById('productViews').textContent = '';
                document.getElementById('productAddedDate').textContent = '';
                document.getElementById('productSold').textContent = 'N/A';
                document.getElementById('productWish').textContent = 'N/A';
                document.getElementById('productCart').textContent = 'N/A';
                document.getElementById('transactionSection').innerHTML = '<p class="text-center text-gray-400">No transactions to display.</p>';
                document.getElementById('commentSection').innerHTML = '<p class="text-center text-gray-400">No comments to display.</p>';
            }

            // Make Edit button interactive (simulated)
            const editProductBtn = document.getElementById('editProductBtn');
            if (editProductBtn) {
                editProductBtn.addEventListener('click', () => {
                    const currentProduct = allProducts.find(p => p.id === productId);
                    if (currentProduct) {
                         alert(`Editing Product: ${currentProduct.name}\n\n(This would navigate to an edit form in a real application)`);
                    } else {
                        alert('No product selected to edit.');
                    }
                });
            }
        });
    </script>
</body>

</html>