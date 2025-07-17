@extends('layouts.sidebar')

@section('isi')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cart Customer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Custom scrollbar for cart items */
        .cart-items-scrollable::-webkit-scrollbar {
            width: 6px;
        }
        .cart-items-scrollable::-webkit-scrollbar-thumb {
            background-color: #60A5FA; /* Biru terang untuk scrollbar thumb */
            border-radius: 3px;
        }

        /* Memastikan harga sejajar */
        .cart-item {
            align-items: center; /* Menggunakan items-center untuk penyelarasan vertikal */
        }
        .cart-item .product-info-details {
            display: flex;
            flex-direction: column;
            justify-content: center; /* Memastikan konten info berada di tengah jika space bervariasi */
        }
        .cart-item .price-and-delete {
            display: flex;
            align-items: center; /* Menyelaraskan harga dan tombol hapus */
            margin-left: auto; /* Mendorong ke kanan */
            gap: 1rem; /* Jarak antara harga dan tombol hapus */
        }
    </style>
</head>

<body class="bg-[#F8FAFC] text-[#333333]"> <div class="flex min-h-screen">
        <main class="flex-1 p-6 space-y-6 ml-64 bg-[#   ]"> <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-gray-800">Cart</h1> <div class="flex items-center space-x-2">
                    {{-- Filter icon dihapus di sini --}}
                    {{-- Form Pencarian Produk di Keranjang --}}
                    <form action="{{ route('cart-customer.index') }}" method="GET" class="flex items-center">
                        <input
                            type="text"
                            name="search"
                            placeholder="Search product"
                            class="bg-gray-100 border border-gray-300 text-gray-800 text-sm px-3 py-2 rounded w-64 focus:outline-none" value="{{ request('search') }}"
                        />
                        <button type="submit" class="ml-2 px-3 py-2 bg-[#2563EB] rounded text-white hover:bg-[#3B82F6]"> <i class="fa-solid fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Pesan Sukses/Error dari Session --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4 border border-green-300"> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4 border border-red-300"> {{ session('error') }}
                </div>
            @endif

            <div class="bg-white p-4 rounded-lg shadow-md"> {{-- Form untuk mengirim item yang dipilih ke checkout --}}
                <form id="processToCheckoutForm" action="{{ route('cart.processToCheckout') }}" method="POST">
                    @csrf
                    <div
                        class="flex items-center justify-between text-sm text-gray-600 border-b border-gray-300 pb-2 mb-4" >
                        <div class="flex items-center space-x-2">
                            {{-- Checkbox Select All Dikembalikan --}}
                            <input type="checkbox" id="selectAllItems" class="form-checkbox text-[#2563EB] rounded" /> <span>Product</span>
                        </div>
                        <span>Price</span>
                    </div>

                    {{-- Kontainer Item Keranjang --}}
                    <div class="space-y-4 cart-items-scrollable max-h-[60vh] overflow-y-auto" id="cartItemsContainer">
                        @forelse ($cartItems as $item)
                            <div class="cart-item flex items-center justify-between bg-white p-4 rounded-lg border border-gray-200 shadow-sm" data-cart-id="{{ $item->id }}" data-price-per-unit="{{ $item->product->price }}"> <div class="flex items-center space-x-4">
                                    {{-- Item Checkbox --}}
                                    <input type="checkbox" name="selected_items[]" value="{{ $item->id }}"
                                        class="item-checkbox form-checkbox text-[#2563EB] rounded" {{ in_array($item->id, $selectedCartItemIds ?? []) ? 'checked' : '' }} />
                                    <div class="w-24 h-24 bg-gray-100 rounded overflow-hidden"> {{-- Gunakan accessor getImageUrlAttribute() dari model Product --}}
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="product-info-details">
                                        <p class="text-sm text-gray-600">{{ $item->product->user->name ?? 'Toko Tidak Dikenal' }}</p> <p class="text-lg font-semibold text-gray-800">{{ $item->product->name }}</p> <p class="text-sm text-gray-500">
                                            {{ Str::limit($item->product->description, 50) }}
                                        </p>
                                        {{-- Menampilkan kuantitas saja tanpa kontrol --}}
                                        <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p> </div>
                                </div>
                                <div class="price-and-delete">
                                    <p class="text-[#2563EB] font-bold">Rp. <span class="item-total-price">{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>,00</p> <button type="button" class="delete-item-btn text-red-500 hover:text-red-600" data-cart-id="{{ $item->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-600">Keranjang Anda kosong.</p> @endforelse
                    </div>

                    {{-- Footer --}}
                    <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-300 text-sm"> <div class="flex items-center space-x-4">
                            <button type="button" class="flex items-center text-blue-600 hover:underline"> <i class="fa-solid fa-bookmark mr-1"></i> Add to wishlist
                            </button>
                            <button type="button" class="flex items-center text-red-600 hover:underline" id="deleteSelectedBtn"> <i class="fa-solid fa-trash mr-1"></i> Delete Selected
                            </button>
                        </div>
                        <div class="flex items-center space-x-6">
                            <span class="text-gray-800">Total (<span id="totalProductCount">0</span> Product) : <span class="text-[#2563EB] font-bold" id="totalPrice">Rp. 0,00</span></span >
                            {{-- Tombol Checkout --}}
                            <button type="submit" id="checkoutSelectedBtn"
                                class="bg-[#2563EB] text-white px-4 py-2 rounded hover:bg-[#3B82F6] transition"> Checkout
                            </button>
                        </div>
                    </div>
                </form> {{-- TUTUP FORM UNTUK CHECKOUT --}}
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const selectAllCheckbox = document.getElementById('selectAllItems');
            const totalPriceElement = document.getElementById('totalPrice');
            const totalProductCountElement = document.getElementById('totalProductCount');
            const deleteSelectedButton = document.getElementById('deleteSelectedBtn');
            const checkoutSelectedButton = document.getElementById('checkoutSelectedBtn');
            const processToCheckoutForm = document.getElementById('processToCheckoutForm');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function calculateTotal() {
                let total = 0;
                let count = 0;
                itemCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const cartItemElement = checkbox.closest('.cart-item');
                        const pricePerUnit = parseFloat(cartItemElement.dataset.pricePerUnit);
                        const quantityText = cartItemElement.querySelector('.product-info-details p:last-of-type').textContent;
                        const quantityMatch = quantityText.match(/Quantity: (\d+)/);
                        const quantity = quantityMatch ? parseInt(quantityMatch[1]) : 1; 
                        
                        total += pricePerUnit * quantity;
                        count++;
                    }
                });
                totalPriceElement.textContent = `Rp. ${total.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 0})},00`;
                totalProductCountElement.textContent = count;
            }

            function updateAllAndTotal() {
                itemCheckboxes = document.querySelectorAll('.item-checkbox');
                updateSelectAllStatus();
                calculateTotal();
            }

            function updateSelectAllStatus() {
                const allChecked = Array.from(itemCheckboxes).every(checkbox => checkbox.checked);
                selectAllCheckbox.checked = allChecked;
            }

            selectAllCheckbox.addEventListener('change', function () {
                itemCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                calculateTotal();
            });

            document.getElementById('cartItemsContainer').addEventListener('change', function(event) {
                if (event.target.classList.contains('item-checkbox')) {
                    calculateTotal();
                    updateSelectAllStatus();
                }
            });

            document.getElementById('cartItemsContainer').addEventListener('click', function(event) {
                if (event.target.closest('.delete-item-btn')) {
                    const button = event.target.closest('.delete-item-btn');
                    const cartId = button.dataset.cartId;
                    if (confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
                        fetch(`/cart/${cartId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(errorData => {
                                    throw new Error(errorData.message || 'Gagal menghapus produk.');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            alert(data.message);
                            button.closest('.cart-item').remove();
                            updateAllAndTotal();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error: ' + error.message);
                        });
                    }
                }
            });

            deleteSelectedButton.addEventListener('click', function () {
                const selectedCartItemIds = Array.from(itemCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedCartItemIds.length === 0) {
                    alert('Pilih setidaknya satu produk untuk dihapus.');
                    return;
                }

                if (confirm(`Apakah Anda yakin ingin menghapus ${selectedCartItemIds.length} produk yang dipilih?`)) {
                    fetch('{{ route('cart.destroy.multiple') }}', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            cart_item_ids: selectedCartItemIds
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(errorData.message || 'Gagal menghapus produk yang dipilih.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        alert(data.message);
                        selectedCartItemIds.forEach(id => {
                            const itemElement = document.querySelector(`.cart-item[data-cart-id="${id}"]`);
                            if (itemElement) {
                                itemElement.remove();
                            }
                        });
                        updateAllAndTotal();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error: ' + error.message);
                    });
                }
            });

            // LOGIKA BARU: Mencegah checkout lebih dari 1 produk
            processToCheckoutForm.addEventListener('submit', function(event) {
                const selectedItems = Array.from(itemCheckboxes).filter(checkbox => checkbox.checked);

                if (selectedItems.length > 1) {
                    event.preventDefault(); // Mencegah form disubmit
                    alert('Harap pilih 1 produk saja untuk checkout.');
                } else if (selectedItems.length === 0) {
                    event.preventDefault(); // Mencegah form disubmit jika tidak ada yang dipilih
                    alert('Pilih setidaknya 1 produk untuk checkout.');
                }
                // Jika selectedItems.length === 1, form akan disubmit secara normal
            });

            // Initial calculation and status update on DOMContentLoaded
            updateAllAndTotal();
        });
    </script>
</body>
</html>
@endsection