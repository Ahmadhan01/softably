<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
                        'yellow-400': '#facc15',
                        'yellow-500': '#eab308'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-[#23293a] text-white min-h-screen font-sans">
    <div class="flex min-h-screen ">
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
                        <img src="img/icon-soft.png" alt="" class="rounded-full">
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
        <div class="flex-1 flex flex-col px-8 py-8">
            <div class="flex items-center mb-8 gap-4">
                <a href="/My-product-seller" class="text-white hover:text-gray-300"><i
                        class="fa-solid fa-arrow-left text-xl"></i></a>
                <h1 class="text-2xl font-bold">Add Product</h1>
            </div>
            <form id="addProductForm" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-8">
                    <div class="bg-[#29314a] rounded-lg p-6">
                        <h2 class="font-bold text-lg mb-6">Details</h2>
                        <div class="flex gap-2 mb-6" id="productImagePreviewContainer">
                            <div class="w-16 h-16 bg-gray-700 rounded-lg flex items-center justify-center text-gray-400 cursor-pointer"
                                onclick="document.getElementById('productImageUpload').click()">
                                <i class="fa-solid fa-plus text-xl"></i>
                            </div>
                            <input type="file" id="productImageUpload" multiple accept="image/*" class="hidden">
                        </div>
                        <div class="mb-4">
                            <label for="productTitle" class="block text-gray-300 mb-2">Nama Produk</label>
                            <input type="text" id="productTitle" placeholder="Masukkan nama produk disini"
                                class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-blue-500" />
                        </div>
                        <div class="mb-4">
                            <label for="productDescription" class="block text-gray-300 mb-2">Deskripsi</label>
                            <textarea id="productDescription" rows="4" placeholder="Masukkan deskripsi"
                                class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="productLink" class="block text-gray-300 mb-2">Link Produk</label>
                            <input type="url" id="productLink" placeholder="e.g., https://yourstore.com/product/xyz"
                                class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-blue-500" />
                        </div>
                    </div>
                    <div class="bg-[#29314a] rounded-lg p-6">
                        <h2 class="font-bold text-lg mb-6">Harga Jual</h2>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="productPrice" class="block text-gray-300 mb-2">Harga</label>
                                <input type="number" id="productPrice" placeholder="e.g., 150000"
                                    class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-blue-500" />
                            </div>
                            <div>
                                <label for="productCurrency" class="block text-gray-300 mb-2">Mata Uang</label>
                                <input type="text" id="productCurrency" placeholder="e.g., IDR" value="IDR"
                                    class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-blue-500" />
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="itemQuantity" class="block text-gray-300 mb-2">Item Quantity</label>
                            <input type="number" id="itemQuantity" placeholder="e.g., 100"
                                class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-blue-500" />
                        </div>
                    </div>
                </div>
                <div class="space-y-8">
                    <div class="bg-[#29314a] rounded-lg p-6">
                        <h2 class="font-bold text-lg mb-6">Option</h2>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-gray-300 font-medium">Waktu Release</p>
                                <p class="text-gray-500 text-sm">Set Waktu Release</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="releaseTimeToggle" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500">
                                </div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-gray-300 font-medium">Private atau Public</p>
                                <p class="text-gray-500 text-sm" id="privatePublicStatus">Private</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="privatePublicToggle" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500">
                                </div>
                            </label>
                        </div>
                        <div class="mb-4">
                            <p class="text-gray-300 font-medium mb-2">Harus diisi oleh pelanggan</p>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-300">Nama</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="customerNameRequired" class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500">
                                        </div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-300">Email</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="customerEmailRequired" class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500">
                                        </div>
                                    </label>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-300">Nomor Telepon</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="customerPhoneRequired" class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="customMessage" class="block text-gray-300 mb-2">Custom Message</label>
                            <textarea id="customMessage" rows="3" placeholder="Message to customer after purchase"
                                class="w-full bg-[#23293a] border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                        </div>
                    </div>
                </div>
            </form>
            <div class="flex flex-col md:flex-row justify-end gap-4 mt-8">
                <button id="deleteProductBtn"
                    class="bg-red-600 text-white px-8 py-3 rounded-lg font-semibold flex items-center gap-2 hover:bg-red-700 transition-colors"><i
                        class="fa-solid fa-trash"></i>Delete
                </button>
                <button id="cancelBtn"
                    class="bg-white text-[#23293a] font-semibold px-8 py-3 rounded-lg shadow hover:bg-gray-200 transition-colors text-center">Cancel
                </button>
                <button id="addProductBtn" class="bg-green-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors">Add Product</button>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    // Sidebar active link logic (consistent across all pages)
    document.addEventListener('DOMContentLoaded', () => {
        const currentPath = window.location.pathname;
        const sidebarLinks = document.querySelectorAll('nav a');

        sidebarLinks.forEach(link => {
            link.classList.remove('bg-gray-700', 'text-white', 'font-semibold');
            link.classList.add('text-gray-300');

            // Adjust path comparison for robustness if paths might have trailing slashes or .html
            const linkPath = link.getAttribute('href').replace(/\/$/, '').replace(/\.html$/, '');
            const currentPathClean = currentPath.replace(/\/$/, '').replace(/\.html$/, '');

            // For Add Product, highlight "My Product"
            if (currentPathClean.includes('/Add-Product-seller') || linkPath === currentPathClean) {
                if (linkPath === '/My-product-seller') { // Explicitly check for My Product link
                    link.classList.add('bg-gray-700', 'text-white', 'font-semibold');
                    link.classList.remove('text-gray-300');
                } else if (linkPath === currentPathClean) { // For other direct pages
                     link.classList.add('bg-gray-700', 'text-white', 'font-semibold');
                     link.classList.remove('text-gray-300');
                }
            }
        });

        // Form elements
        const productImageUpload = document.getElementById('productImageUpload');
        const productImagePreviewContainer = document.getElementById('productImagePreviewContainer');
        const productTitle = document.getElementById('productTitle');
        const productDescription = document.getElementById('productDescription');
        const productLink = document.getElementById('productLink');
        const productPrice = document.getElementById('productPrice');
        const productCurrency = document.getElementById('productCurrency');
        const itemQuantity = document.getElementById('itemQuantity');
        const customMessage = document.getElementById('customMessage');

        // Toggle switches
        const releaseTimeToggle = document.getElementById('releaseTimeToggle');
        const privatePublicToggle = document.getElementById('privatePublicToggle');
        const privatePublicStatus = document.getElementById('privatePublicStatus');

        // Customer required info checkboxes
        const customerNameRequired = document.getElementById('customerNameRequired');
        const customerEmailRequired = document.getElementById('customerEmailRequired');
        const customerPhoneRequired = document.getElementById('customerPhoneRequired');

        // Buttons
        const deleteProductBtn = document.getElementById('deleteProductBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const addProductBtn = document.getElementById('addProductBtn');

        let uploadedImages = []; // To store base64 or file URLs for preview

        // --- Image Upload Preview ---
        productImageUpload.addEventListener('change', (event) => {
            productImagePreviewContainer.innerHTML = `
                <div class="w-16 h-16 bg-gray-700 rounded-lg flex items-center justify-center text-gray-400 cursor-pointer"
                    onclick="document.getElementById('productImageUpload').click()">
                    <i class="fa-solid fa-plus text-xl"></i>
                </div>
            `; // Clear existing previews except the plus button
            uploadedImages = []; // Clear array for new selection

            if (event.target.files && event.target.files.length > 0) {
                Array.from(event.target.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const imgDiv = document.createElement('div');
                        imgDiv.className = 'relative w-16 h-16 rounded-lg overflow-hidden group';
                        imgDiv.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                            <button class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-white text-lg remove-image-btn" data-src="${e.target.result}">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        `;
                        productImagePreviewContainer.appendChild(imgDiv);
                        uploadedImages.push(e.target.result); // Store base64 for later use

                        // Add event listener for removing image
                        imgDiv.querySelector('.remove-image-btn').addEventListener('click', function() {
                            const srcToRemove = this.getAttribute('data-src');
                            uploadedImages = uploadedImages.filter(src => src !== srcToRemove);
                            imgDiv.remove(); // Remove the preview div
                            // If no images left, ensure a plus button is visible (it's already handled by initial clear)
                        });
                    };
                    reader.readAsDataURL(file);
                });
            }
        });

        // --- Toggle Functionality ---
        privatePublicToggle.addEventListener('change', () => {
            privatePublicStatus.textContent = privatePublicToggle.checked ? 'Public' : 'Private';
        });

        // --- Button Actions ---
        deleteProductBtn.addEventListener('click', () => {
            // In a real app, this would typically delete an existing product,
            // not an "add product" form. Here, it's just a simulation.
            if (confirm("Are you sure you want to delete this (simulated) product?")) {
                alert("Product (simulated) deleted!");
                window.location.href = '/My-product-seller.html';
            }
        });

        cancelBtn.addEventListener('click', () => {
            if (confirm("Are you sure you want to cancel and discard changes?")) {
                window.location.href = '/My-product-seller.html';
            }
        });

        addProductBtn.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent default form submission

            const newProduct = {
                id: 'prod' + Date.now(), // Simple unique ID for simulation
                images: uploadedImages,
                title: productTitle.value.trim(),
                description: productDescription.value.trim(),
                productLink: productLink.value.trim(),
                price: parseFloat(productPrice.value) || 0,
                currency: productCurrency.value.trim(),
                quantity: parseInt(itemQuantity.value) || 0,
                releaseTimeSet: releaseTimeToggle.checked,
                isPublic: privatePublicToggle.checked,
                customerInfoRequired: {
                    name: customerNameRequired.checked,
                    email: customerEmailRequired.checked,
                    phone: customerPhoneRequired.checked,
                },
                customMessage: customMessage.value.trim(),
                addedDate: new Date().toISOString().split('T')[0], // Current date
                views: 0,
                rating: 0,
                sold: 0,
                wish: 0,
                cart: 0
            };

            // Basic validation
            if (!newProduct.title || !newProduct.description || !newProduct.price || newProduct.images.length === 0) {
                alert('Please fill in at least Title, Description, Price, and upload at least one Image.');
                return;
            }

            console.log('New Product Data:', newProduct);
            alert('Product Added Successfully (simulated)! Check console for data.');
            
            // In a real application, you would send `newProduct` to your backend here.
            // After successful addition, redirect to My Products page.
            window.location.href = '/My-product-seller.html';
        });
    });
</script>