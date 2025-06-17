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
            background-color: #4b5563;
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

<body class="bg-[#0f172a] text-white font-sans">
    <div class="flex min-h-screen">
        <main class="flex-1 p-6 space-y-6 ml-64">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold">Cart</h1>
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-filter"></i>
                    {{-- Form Pencarian Produk di Keranjang --}}
                    <form action="{{ route('cart-customer.index') }}" method="GET" class="flex items-center">
                        <input
                            type="text"
                            name="search"
                            placeholder="Search product"
                            class="bg-[#1e293b] border border-gray-600 text-sm text-white px-3 py-2 rounded w-64 focus:outline-none"
                            value="{{ request('search') }}"
                        />
                        <button type="submit" class="ml-2 px-3 py-2 bg-blue-500 rounded text-white hover:bg-blue-600">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-[#1e293b] p-4 rounded-lg shadow">
                <div
                    class="flex items-center justify-between text-sm text-gray-400 border-b border-gray-600 pb-2 mb-4"
                >
                    <div class="flex items-center space-x-2">
                        <span>Product</span>
                    </div>
                    <span>Price</span>
                </div>

                {{-- Kontainer Item Keranjang --}}
                <div class="space-y-4 cart-items-scrollable max-h-[60vh] overflow-y-auto" id="cartItemsContainer">
                    @forelse ($cartItems as $item)
                        <div class="cart-item flex items-center justify-between bg-[#0f172a] p-4 rounded-lg" data-cart-id="{{ $item->id }}" data-price="{{ $item->product->price * $item->quantity }}">
                            <div class="flex items-center space-x-4">
                                <input type="checkbox" class="item-checkbox" data-price="{{ $item->product->price * $item->quantity }}" />
                                <div class="w-24 h-24 bg-gray-700 rounded overflow-hidden">
                                    <img src="{{ $item->product->image_path }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="product-info-details">
                                    <p class="text-sm text-gray-300">Toko Ahmad</p>
                                    <p class="text-lg font-semibold">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-400">
                                        {{ Str::limit($item->product->description, 50) }}
                                    </p>
                                </div>
                            </div>
                            <div class="price-and-delete">
                                <p class="text-[#f59e0b] font-bold">Rp. {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }},00</p>
                                <button class="delete-item-btn text-red-500 hover:text-red-600" data-cart-id="{{ $item->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-400">Keranjang Anda kosong.</p>
                    @endforelse
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-600 text-sm">
                    <div class="flex items-center space-x-4">
                        <button class="flex items-center text-green-500 hover:underline">
                            <i class="fa-solid fa-bookmark mr-1"></i> Add to wishlist
                        </button>
                        <button class="flex items-center text-red-500 hover:underline" id="deleteSelectedBtn">
                            <i class="fa-solid fa-trash mr-1"></i> Delete
                        </button>
                    </div>
                    <div class="flex items-center space-x-6">
                        <span>Total (<span id="totalProductCount">0</span> Product) :
                            <span class="text-[#f59e0b] font-bold" id="totalPrice">Rp. 0,00</span></span
                        >
                        <a href="{{ route('checkout-customer') }}"
                            class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-400 transition">
                            Checkout
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const totalPriceElement = document.getElementById('totalPrice');
            const totalProductCountElement = document.getElementById('totalProductCount');
            const deleteItemButtons = document.querySelectorAll('.delete-item-btn');
            const deleteSelectedButton = document.getElementById('deleteSelectedBtn');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function calculateTotal() {
                let total = 0;
                let count = 0;
                itemCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        total += parseFloat(checkbox.dataset.price);
                        count++;
                    }
                });
                totalPriceElement.textContent = `Rp. ${total.toLocaleString('id-ID')},00`;
                totalProductCountElement.textContent = count;
            }

            calculateTotal();

            // Individual item checkbox change
            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    calculateTotal();
                });
            });

            // Delete single item
            // Delegasi event untuk tombol hapus individu (jika tombol dihapus/ditambahkan dinamis)
            document.getElementById('cartItemsContainer').addEventListener('click', function(event) {
                if (event.target.closest('.delete-item-btn')) {
                    const button = event.target.closest('.delete-item-btn');
                    if (confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
                        const cartId = button.dataset.cartId;
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
                            // Re-query itemCheckboxes after DOM manipulation
                            itemCheckboxes = document.querySelectorAll('.item-checkbox');
                            calculateTotal();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error: ' + error.message);
                        });
                    }
                }
            });


            // Delete selected items
            deleteSelectedButton.addEventListener('click', function () {
                const selectedCartItemIds = Array.from(itemCheckboxes)
                                                .filter(checkbox => checkbox.checked)
                                                .map(checkbox => checkbox.closest('.cart-item').dataset.cartId);

                if (selectedCartItemIds.length === 0) {
                    alert('Pilih setidaknya satu produk untuk dihapus.');
                    return;
                }

                if (confirm(`Apakah Anda yakin ingin menghapus ${selectedCartItemIds.length} produk yang dipilih?`)) {
                    fetch('/cart/multiple', {
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
                            if (itemElement) { // Pastikan elemen masih ada sebelum dihapus
                                itemElement.remove();
                            }
                        });
                        itemCheckboxes = document.querySelectorAll('.item-checkbox'); // Re-query checkboxes
                        calculateTotal();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error: ' + error.message);
                    });
                }
            });

            // Ensure all checkboxes are unchecked on initial load
            itemCheckboxes.forEach(checkbox => checkbox.checked = false);

            // Re-calculate total after all initial setup
            calculateTotal();
        });
    </script>
</body>
</html>
@endsection