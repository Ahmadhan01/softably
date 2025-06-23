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

            {{-- Pesan Sukses/Error dari Session --}}
            @if(session('success'))
                <div class="bg-green-500 text-white p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-500 text-white p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-[#1e293b] p-4 rounded-lg shadow">
                {{-- Form untuk mengirim item yang dipilih ke checkout --}}
                <form id="processToCheckoutForm" action="{{ route('cart.processToCheckout') }}" method="POST">
                    @csrf
                    <div
                        class="flex items-center justify-between text-sm text-gray-400 border-b border-gray-600 pb-2 mb-4"
                    >
                        <div class="flex items-center space-x-2">
                            {{-- Checkbox Select All --}}
                            <input type="checkbox" id="selectAllItems" class="form-checkbox text-blue-500 rounded" />
                            <span>Product</span>
                        </div>
                        <span>Price</span>
                    </div>

                    {{-- Kontainer Item Keranjang --}}
                    <div class="space-y-4 cart-items-scrollable max-h-[60vh] overflow-y-auto" id="cartItemsContainer">
                        @forelse ($cartItems as $item)
                            <div class="cart-item flex items-center justify-between bg-[#0f172a] p-4 rounded-lg" data-cart-id="{{ $item->id }}" data-price-per-unit="{{ $item->product->price }}">
                                <div class="flex items-center space-x-4">
                                    {{-- Item Checkbox --}}
                                    <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" {{-- UBAH NAMA INI --}}
                                        class="item-checkbox form-checkbox text-blue-500 rounded"
                                        {{ in_array($item->id, $selectedCartItemIds ?? []) ? 'checked' : '' }} />
                                    <div class="w-24 h-24 bg-gray-700 rounded overflow-hidden">
                                        <img src="{{ $item->product->image_path }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="product-info-details">
                                        <p class="text-sm text-gray-300">{{ $item->product->seller->name ?? 'Toko Tidak Dikenal' }}</p>
                                        <p class="text-lg font-semibold">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-400">
                                            {{ Str::limit($item->product->description, 50) }}
                                        </p>
                                        <div class="flex items-center mt-2">
                                            <button type="button" data-id="{{ $item->id }}" data-type="minus"
                                                class="quantity-btn bg-gray-700 text-white px-2 py-1 rounded-l">-</button>
                                            <input type="number" data-id="{{ $item->id }}" value="{{ $item->quantity }}"
                                                min="1" class="quantity-input w-16 text-center bg-gray-600 text-white" />
                                            <button type="button" data-id="{{ $item->id }}" data-type="plus"
                                                class="quantity-btn bg-gray-700 text-white px-2 py-1 rounded-r">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="price-and-delete">
                                    <p class="text-[#f59e0b] font-bold">Rp. <span class="item-total-price">{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>,00</p>
                                    <button type="button" class="delete-item-btn text-red-500 hover:text-red-600" data-cart-id="{{ $item->id }}">
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
                            <button type="button" class="flex items-center text-green-500 hover:underline">
                                <i class="fa-solid fa-bookmark mr-1"></i> Add to wishlist
                            </button>
                            <button type="button" class="flex items-center text-red-500 hover:underline" id="deleteSelectedBtn">
                                <i class="fa-solid fa-trash mr-1"></i> Delete Selected
                            </button>
                        </div>
                        <div class="flex items-center space-x-6">
                            <span>Total (<span id="totalProductCount">0</span> Product) :
                                <span class="text-[#f59e0b] font-bold" id="totalPrice">Rp. 0,00</span></span
                            >
                            {{-- Tombol Checkout --}}
                            <button type="submit" id="checkoutSelectedBtn"
                                class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-400 transition">
                                Checkout
                            </button>
                        </div>
                    </div>
                </form> {{-- TUTUP FORM UNTUK CHECKOUT --}}
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let itemCheckboxes = document.querySelectorAll('.item-checkbox'); // Gunakan `let` karena akan di-re-query
            const selectAllCheckbox = document.getElementById('selectAllItems');
            const totalPriceElement = document.getElementById('totalPrice');
            const totalProductCountElement = document.getElementById('totalProductCount');
            const deleteSelectedButton = document.getElementById('deleteSelectedBtn'); // Tombol delete selected
            const checkoutSelectedButton = document.getElementById('checkoutSelectedBtn'); // Tombol checkout
            const processToCheckoutForm = document.getElementById('processToCheckoutForm'); // Form checkout
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function calculateTotal() {
                let total = 0;
                let count = 0;
                itemCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const cartItemElement = checkbox.closest('.cart-item');
                        const pricePerUnit = parseFloat(cartItemElement.dataset.pricePerUnit);
                        const quantity = parseInt(cartItemElement.querySelector('.quantity-input').value);
                        total += pricePerUnit * quantity;
                        count++;
                    }
                });
                totalPriceElement.textContent = `${total.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 0})},00`; // Format ke Rp. xxx.xxx,00
                totalProductCountElement.textContent = count;
            }

            // Fungsi untuk memperbarui semua checkbox dan total saat halaman dimuat atau item dihapus/ditambahkan
            function updateAllAndTotal() {
                itemCheckboxes = document.querySelectorAll('.item-checkbox'); // Re-query DOM untuk itemCheckboxes
                updateSelectAllStatus(); // Perbarui status select all
                calculateTotal(); // Hitung ulang total
            }

            // Checkbox "Select All"
            function updateSelectAllStatus() {
                const allChecked = Array.from(itemCheckboxes).every(checkbox => checkbox.checked);
                selectAllCheckbox.checked = allChecked;
            }

            selectAllCheckbox.addEventListener('change', function () {
                itemCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                calculateTotal(); // Hitung ulang total setelah select all/none
            });

            // Individual item checkbox change
            // Menggunakan event delegation untuk checkbox yang mungkin dinamis
            document.getElementById('cartItemsContainer').addEventListener('change', function(event) {
                if (event.target.classList.contains('item-checkbox')) {
                    calculateTotal();
                    updateSelectAllStatus();
                }
            });


            // Delete single item (menggunakan event delegation)
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
                            button.closest('.cart-item').remove(); // Hapus elemen dari DOM
                            updateAllAndTotal(); // Perbarui total dan status select all
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error: ' + error.message);
                        });
                    }
                }
            });

            // Delete selected items (menggunakan AJAX)
            deleteSelectedButton.addEventListener('click', function () {
                const selectedCartItemIds = Array.from(itemCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value); // Menggunakan checkbox.value (ID cart item)

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
                        // Hapus elemen dari DOM
                        selectedCartItemIds.forEach(id => {
                            const itemElement = document.querySelector(`.cart-item[data-cart-id="${id}"]`);
                            if (itemElement) {
                                itemElement.remove();
                            }
                        });
                        updateAllAndTotal(); // Perbarui total dan status select all
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error: ' + error.message);
                    });
                }
            });

            // Quantity Update Logic (menggunakan event delegation)
            document.getElementById('cartItemsContainer').addEventListener('click', function(event) {
                if (event.target.classList.contains('quantity-btn')) {
                    const button = event.target;
                    const cartItemElement = button.closest('.cart-item');
                    const cartId = cartItemElement.dataset.cartId;
                    const quantityInput = cartItemElement.querySelector('.quantity-input');
                    let quantity = parseInt(quantityInput.value);
                    const type = button.dataset.type;
                    const pricePerUnit = parseFloat(cartItemElement.dataset.pricePerUnit);


                    if (type === 'plus') {
                        quantity++;
                    } else if (type === 'minus' && quantity > 1) {
                        quantity--;
                    } else if (type === 'minus' && quantity === 1) {
                        if (confirm('Hapus produk ini dari keranjang?')) {
                            fetch(`/cart/${cartId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                alert(data.message);
                                cartItemElement.remove();
                                updateAllAndTotal(); // Perbarui total dan status select all
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan saat menghapus produk.');
                            });
                            return; // Stop here if item is deleted
                        }
                    }

                    fetch(`/cart/${cartId}`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ quantity: quantity })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(errorData.message || 'Gagal memperbarui kuantitas.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        quantityInput.value = quantity;
                        const itemTotalPriceElement = cartItemElement.querySelector('.item-total-price');
                        itemTotalPriceElement.textContent = (pricePerUnit * quantity).toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 0});
                        calculateTotal(); // Hitung ulang total keseluruhan
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error: ' + error.message);
                    });
                }
            });

            // Initial calculation and status update on DOMContentLoaded
            updateAllAndTotal(); // Panggil ini sekali saat halaman dimuat
        });
    </script>
</body>
</html>
@endsection