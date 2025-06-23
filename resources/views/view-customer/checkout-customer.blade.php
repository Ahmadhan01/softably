@extends('layouts.sidebar')

@section('isi')
    {{-- HAPUS TAG <!DOCTYPE html>, <html>, <head>, dan <body> DARI SINI --}}
    {{-- Tag-tag tersebut sudah ada di layouts/sidebar.blade.php --}}

    <div class="flex min-h-screen">
        <main class="flex-1 p-6 space-y-6 ml-64">
            <div class="text-white">
                <a href="{{ route('cart-customer.index') }}" class="text-sm text-white hover:underline ">
                    <i class="fa-solid fa-arrow-left"></i>&nbsp; Checkout
                </a>

                {{-- FORM CHECKOUT UTAMA --}}
                <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST" onsubmit="console.log('Form is submitting!');">
                    @csrf

                    {{-- KIRIM ID ITEM KERANJANG YANG DIPILIH DARI CART SEBAGAI HIDDEN INPUTS --}}
                    @foreach($checkoutItems as $item)   
                        <input type="hidden" name="selected_cart_items[]" value="{{ $item->id }}">  
                    @endforeach

                    <div class="bg-[#1e293b] rounded-lg p-6 shadow-md mb-6 mt-4">
                        <h2 class="text-xl font-semibold mb-4">Product</h2>
                        @forelse ($checkoutItems as $item)
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex">
                                <div
                                    class="w-28 h-28 bg-white rounded-md mr-4 overflow-hidden flex items-center justify-center">
                                    <img src="{{ $item->product->image_path }}" alt="{{ $item->product->name }}"
                                        class="object-cover w-full h-full">
                                </div>
                                <div>
                                    <h3 class="text-md font-semibold">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-400">
                                        {{ Str::limit($item->product->description, 100) }}
                                    </p>
                                    <p class="text-sm text-gray-400">Quantity: {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <div class="flex items-start ml-6 self-start text-md font-bold space-x-1 mt-6">
                                <span>Rp</span>
                                <span>{{ number_format($item->quantity * $item->product->price, 2, ',', '.') }}</span>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-400">Tidak ada produk yang dipilih untuk checkout.</p>
                        @endforelse
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-[#1e293b] rounded-lg p-6 shadow-md">
                            <h2 class="text-xl font-semibold mb-4">Buyer info</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block mb-1 text-sm">Email</label>
                                    <input type="email" name="email"
                                        value="{{ old('email', $buyerInfo['email'] ?? '') }}"
                                        class="w-full px-4 py-2 rounded-md text-black" required />
                                    @error('email')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block mb-1 text-sm">Name</label>
                                    <input type="text" name="name" value="{{ old('name', $buyerInfo['name'] ?? '') }}"
                                        class="w-full px-4 py-2 rounded-md text-black" required />
                                    @error('name')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block mb-1 text-sm">Phone Number</label>
                                    <input type="text" name="phone_number"
                                        value="{{ old('phone_number', $buyerInfo['phone'] ?? '') }}"
                                        class="w-full px-4 py-2 rounded-md text-black" required />
                                    @error('phone_number')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="bg-[#1e293b] rounded-lg p-6 shadow-md">
                            <h2 class="text-xl font-semibold mb-4">Payment detail</h2>
                            <div class="text-sm text-gray-300 space-y-2">
                                <div class="flex justify-between">
                                    <span>Sub total</span>
                                    <span>Rp. {{ number_format($subtotal, 2, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Discount</span>
                                    <span>Rp. {{ number_format($discount, 2, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Convenience fee</span>
                                    <span>Rp. {{ number_format($convenienceFee, 2, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center mt-4 text-xl font-bold">
                                <span>Total</span>
                                <span class="text-orange-400">Rp. {{ number_format($totalAmount, 2, ',', '.') }}</span>
                            </div>

                            <div class="mt-4">
                                <label for="payment_method" class="block mb-1 text-sm">Select payment method</label>
                                <div class="relative">
                                    <select id="payment_method" name="payment_method"
                                        class="w-full bg-[#334155] border border-gray-600 text-white py-2 px-4 rounded-lg appearance-none focus:outline-none focus:border-green-500 pr-10"
                                        required>
                                        <option value="">Choose payment method</option>
                                        @foreach ($paymentMethods as $method)
                                        <option value="{{ $method }}">{{ $method }}</option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                @error('payment_method')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center mt-4">
                                <input type="checkbox" id="terms" name="agree_terms"
                                    class="form-checkbox text-green-500 mr-2" value="1"
                                    {{ old('agree_terms') ? 'checked' : '' }} required />
                                <label for="terms" class="text-sm text-gray-300">I agree to the Terms of Use</label>
                                @error('agree_terms')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" id="buyNowBtn"
                                class="w-full mt-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg">
                                Buy Now
                            </button>
                        </div>
                    </div>
                </form> {{-- AKHIR DARI FORM CHECKOUT --}}
            </div>
        </main>
    </div>

    {{-- MODAL SUKSES (Tampil saat ada session 'success_modal_data' setelah redirect) --}}
    <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-[#1e293b] text-white rounded-lg w-full max-w-md p-6 shadow-lg text-center">
            <h2 class="text-xl font-bold mb-2">Your purchase was successful</h2>
            <p class="text-sm text-gray-400 mb-4" id="modalEmailReceipt">
                We sent the receipt to your email.
            </p>

            <div class="text-left space-y-3 mb-4" id="modalProductList">
                {{-- Products akan diisi secara dinamis oleh JavaScript jika modal ditampilkan --}}
            </div>

            <div class="flex justify-between text-sm text-gray-300">
                <span>Payment method</span><span id="modalPaymentMethod"></span>
            </div>
            <div class="flex justify-between text-sm text-gray-300">
                <span>Discount</span><span id="modalDiscount"></span>
            </div>
            <div class="flex justify-between text-sm text-gray-300">
                <span>Convenience fee</span><span id="modalConvenienceFee"></span>
            </div>
            <div class="flex justify-between text-lg font-bold">
                <span>Total</span>
                <span class="text-orange-400" id="modalTotalAmount"></span>
            </div>

            <div class="flex justify-between space-x-4 mt-4">
                <button onclick="closeModalAndRedirect()" class="w-full py-2 bg-white text-[#1e293b] font-bold rounded-lg">
                    Close
                </button>
                <button class="w-full py-2 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg"
                    onclick="downloadReceipt()">
                    Download
                </button>
            </div>
        </div>
    </div>

    @push('scripts') {{-- Pastikan ini di dalam @section('isi') dan akan di-push ke @stack('scripts') di sidebar.blade.php --}}
    <script> 
        // Fungsi untuk menutup modal dan redirect ke halaman My Orders
        function closeModalAndRedirect() {
            document.getElementById("successModal").classList.add("hidden");
            // Hapus sesi selected_cart_items_for_checkout di sini agar halaman bersih setelah modal ditutup
            fetch('{{ route('clear.checkout.session') }}', { // Menggunakan route() helper
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
                window.location.href = "{{ route('order-customer') }}"; // Arahkan ke My Orders
            })
            .catch(error => {
                console.error('Error clearing session:', error);
                window.location.href = "{{ route('order-customer') }}"; // Tetap arahkan meskipun ada error
            });
        }

        // Fungsi placeholder untuk download receipt
        function downloadReceipt() {
            alert('Fungsi download receipt belum diimplementasikan.');
        }

        // PENTING: Tampilkan modal jika ada pesan sukses dari redirect (melalui data session)
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success_modal_data'))
                const modalData = @json(session('success_modal_data'));

                // Isi detail transaksi ke dalam modal
                document.getElementById('modalEmailReceipt').textContent = `We sent the receipt to ${modalData.email}`;

                const productListDiv = document.getElementById('modalProductList');
                productListDiv.innerHTML = ''; // Kosongkan daftar produk sebelumnya
                modalData.products.forEach(product => {
                    const productHtml = `
                        <div class="flex items-center w-full">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-white rounded-md overflow-hidden flex items-center justify-center">
                                    <img src="${product.image || 'https://via.placeholder.com/64x64'}" alt="${product.name}" class="object-cover w-full h-full">
                                </div>
                                <div>
                                    <p class="font-semibold text-sm">${product.name}</p>
                                    <p class="text-xs">x${product.quantity}</p>
                                </div>
                            </div>
                            <div class="ml-auto font-bold">Rp. ${product.price}</div>
                        </div>
                    `;
                    productListDiv.insertAdjacentHTML('beforeend', productHtml);
                });

                document.getElementById('modalPaymentMethod').textContent = modalData.payment_method;
                document.getElementById('modalDiscount').textContent = `Rp. ${modalData.discount}`;
                document.getElementById('modalConvenienceFee').textContent = `Rp. ${modalData.convenience_fee}`;
                document.getElementById('modalTotalAmount').textContent = `Rp. ${modalData.total_amount}`;

                // Tampilkan modal
                document.getElementById('successModal').classList.remove('hidden');

                // Opsional: Hapus sesi success_modal_data setelah ditampilkan agar tidak muncul lagi saat refresh
                {{ session()->forget('success_modal_data') }}; 
            @endif
        });
    </script>
    @endpush
@endsection