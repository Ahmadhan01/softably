@extends('layouts.sidebar')

@section('isi')
    <div class="flex min-h-screen">
        <main class="flex-1 p-6 space-y-6 ml-64">
            <div class="text-white">
                <a href="{{ route('cart-customer.index') }}" class="text-sm text-white hover:underline ">
                    <i class="fa-solid fa-arrow-left"></i>&nbsp; Checkout
                </a>

                {{-- FORM CHECKOUT UTAMA --}}
                <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST">
                    @csrf

                    {{-- KIRIM ID ITEM KERANJANG YANG DIPILIH DARI CART SEBAGAI HIDDEN INPUTS --}}
                    {{-- UBAH $cartItems MENJADI $checkoutItems DI SINI --}}
                    @foreach($checkoutItems as $item)
                        <input type="hidden" name="selected_cart_items[]" value="{{ $item->id }}">
                    @endforeach

                    {{-- Kontainer utama untuk mengatur tata letak produk dan detail pembayaran --}}
                    {{-- Menggunakan grid dengan 2 kolom untuk layar medium ke atas --}}
                    <div class="grid md:grid-cols-2 gap-6 mt-4">

                        {{-- KOLOM KIRI: PRODUK & BUYER INFO --}}
                        <div>
                            {{-- BAGIAN PRODUK (Disesuaikan ukurannya) --}}
                            <div class="bg-[#1e293b] rounded-lg p-6 shadow-md mb-6 {{-- max-w-md --}}"> {{-- Hapus mb-6 jika ingin rapat --}}
                                <h2 class="text-xl font-semibold mb-4">Product</h2>
                                {{-- UBAH $cartItems MENJADI $checkoutItems DI SINI --}}
                                @forelse ($checkoutItems as $item)
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex">
                                        <div
                                            class="w-28 h-28 bg-white rounded-md mr-4 overflow-hidden flex items-center justify-center">
                                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
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
                                        <span>{{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                @empty
                                <p class="text-gray-400">Tidak ada produk yang dipilih untuk checkout.</p>
                                @endforelse
                            </div>

                            {{-- BAGIAN BUYER INFO --}}
                            <div class="bg-[#1e293b] rounded-lg p-6 shadow-md">
                                <h2 class="text-xl font-semibold mb-4">Buyer info</h2>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block mb-1 text-sm">Email</label>
                                        <input type="email" name="email"
                                            value="{{ old('email', $buyerInfo['email'] ?? Auth::user()->email ?? '') }}"
                                            class="w-full px-4 py-2 rounded-md text-black" required />
                                        @error('email')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block mb-1 text-sm">Name</label>
                                        <input type="text" name="name" value="{{ old('name', $buyerInfo['name'] ?? Auth::user()->name ?? '') }}"
                                            class="w-full px-4 py-2 rounded-md text-black" required />
                                        @error('name')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block mb-1 text-sm">Phone Number</label>
                                        <input type="text" name="phone_number"
                                            value="{{ old('phone_number', $buyerInfo['phone'] ?? Auth::user()->phone_number ?? '') }}"
                                            class="w-full px-4 py-2 rounded-md text-black" required />
                                        @error('phone_number')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div> {{-- AKHIR KOLOM KIRI --}}

                        {{-- KOLOM KANAN: PAYMENT DETAIL --}}
                        <div>
                            <div class="bg-[#1e293b] rounded-lg p-6 shadow-md">
                                <h2 class="text-xl font-semibold mb-4">Payment detail</h2>
                                <div class="text-sm text-gray-300 space-y-2">
                                    <div class="flex justify-between">
                                        <span>Sub total</span>
                                        <span id="subtotalDisplay">Rp. {{ number_format($subtotal, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Discount</span>
                                        <span id="discountDisplay">Rp. {{ number_format($discount, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Convenience fee</span>
                                        <span id="convenienceFeeDisplay">Rp. {{ number_format($initialConvenienceFee, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mt-4 text-xl font-bold">
                                    <span>Total</span>
                                    <span class="text-orange-400" id="totalAmountDisplay">Rp. {{ number_format($initialTotalAmount, 0, ',', '.') }}</span>
                                </div>

                                <div class="mt-4">
                                    <label for="payment_method_radio_group" class="block mb-2 text-sm">Select payment method</label>
                                    <div class="space-y-3">
                                        {{-- SoftPay Option --}}
                                        <label for="payment_softpay" class="flex items-center p-4 rounded-lg border border-gray-600 cursor-pointer hover:bg-[#2D3A4F]">
                                            <input type="radio" id="payment_softpay" name="payment_method" value="SoftPay" class="form-radio h-5 w-5 text-blue-600" checked>
                                            <div class="ml-4 flex-1">
                                                <span class="font-semibold text-lg">SoftPay</span>
                                                <p class="text-sm text-gray-400">Saldo Anda: <span class="font-bold text-yellow-400">Rp {{ number_format($softpayBalance ?? 0, 0, ',', '.') }}</span></p>
                                                <p class="text-xs text-gray-400 mt-1">Convenience fee: Rp 0</p>
                                                @if(($softpayBalance ?? 0) < $initialTotalAmount)
                                                    <p class="text-xs text-red-400 mt-1">Saldo SoftPay tidak cukup. Anda membutuhkan Rp {{ number_format($initialTotalAmount - ($softpayBalance ?? 0), 0, ',', '.') }} lagi.</p>
                                                @endif
                                            </div>
                                            <i class="fa-solid fa-wallet text-2xl text-green-400"></i>
                                        </label>

                                        {{-- QRIS Option --}}
                                        <label for="payment_qris" class="flex items-center p-4 rounded-lg border border-gray-600 cursor-pointer hover:bg-[#2D3A4F]">
                                            <input type="radio" id="payment_qris" name="payment_method" value="QRIS" class="form-radio h-5 w-5 text-blue-600">
                                            <div class="ml-4 flex-1">
                                                <span class="font-semibold text-lg">QRIS</span>
                                                <p class="text-sm text-gray-400">Pembayaran melalui QRIS.</p>
                                                <p class="text-xs text-gray-400 mt-1">Convenience fee: Rp {{ number_format($qrisFee ?? 5000, 0, ',', '.') }}</p>
                                            </div>
                                            <i class="fa-solid fa-qrcode text-2xl text-blue-400"></i>
                                        </label>

                                        {{-- Bank Transfer Option (digabung) --}}
                                        <label for="payment_bank_transfer" class="flex items-center p-4 rounded-lg border border-gray-600 cursor-pointer hover:bg-[#2D3A4F]">
                                            <input type="radio" id="payment_bank_transfer" name="payment_method" value="Bank Transfer" class="form-radio h-5 w-5 text-blue-600">
                                            <div class="ml-4 flex-1">
                                                <span class="font-semibold text-lg">Bank Transfer</span>
                                                <p class="text-sm text-gray-400">Pembayaran melalui transfer bank (BCA/Mandiri).</p>
                                                <p class="text-xs text-gray-400 mt-1">Convenience fee: Rp {{ number_format($bankTransferFee ?? 10000, 0, ',', '.') }}</p>
                                            </div>
                                            <i class="fa-solid fa-bank text-2xl text-blue-400"></i>
                                        </label>

                                        {{-- Other Payment Methods (dihapus dari loop atau dikomentari jika ada) --}}
                                        {{-- @foreach ($paymentMethods as $method)
                                            <label for="payment_method_{{ Str::slug($method) }}" class="flex items-center p-4 rounded-lg border border-gray-600 cursor-pointer hover:bg-[#2D3A4F]">
                                                <input type="radio" id="payment_method_{{ Str::slug($method) }}" name="payment_method" value="{{ $method }}" class="form-radio h-5 w-5 text-blue-600">
                                                <div class="ml-4 flex-1">
                                                    <span class="font-semibold text-lg">{{ $method }}</span>
                                                    <p class="text-sm text-gray-400">Pembayaran melalui {{ strtolower($method) }}.</p>
                                                </div>
                                                <i class="fa-solid fa-credit-card text-2xl text-blue-400"></i>
                                            </label>
                                        @endforeach --}}
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
                                    class="w-full mt-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg
                                    {{ ($softpayBalance ?? 0) < $initialTotalAmount && old('payment_method', 'SoftPay') === 'SoftPay' ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ ($softpayBalance ?? 0) < $initialTotalAmount && old('payment_method', 'SoftPay') === 'SoftPay' ? 'disabled' : '' }}
                                    >
                                    Bayar Sekarang
                                </button>
                            </div>
                        </div> {{-- AKHIR KOLOM KANAN --}}
                    </div> {{-- AKHIR GRID UTAMA --}}
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

            // --- LOGIKA PEMBAYARAN & UPDATE BIAYA ---
            const checkoutForm = document.getElementById('checkoutForm');
            const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
            const softpayRadio = document.getElementById('payment_softpay');
            const buyNowBtn = document.getElementById('buyNowBtn');
            const subtotal = parseFloat({{ $subtotal ?? 0 }});
            const discount = parseFloat({{ $discount ?? 0 }});
            const softpayBalance = parseFloat({{ $softpayBalance ?? 0 }});
            const qrisFee = parseFloat({{ $qrisFee ?? 5000 }}); // Ambil dari Controller
            const bankTransferFee = parseFloat({{ $bankTransferFee ?? 10000 }}); // Ambil dari Controller

            const convenienceFeeDisplay = document.getElementById('convenienceFeeDisplay');
            const totalAmountDisplay = document.getElementById('totalAmountDisplay');

            function formatRupiah(amount) {
                return `Rp. ${amount.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 0})}`;
            }

            // Fungsi untuk memperbarui total dan status tombol "Bayar Sekarang"
            function updatePaymentDetailsAndButton() {
                const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
                let currentConvenienceFee = 0;
                let currentTotalAmount = subtotal - discount;

                if (selectedMethod === 'QRIS') {
                    currentConvenienceFee = qrisFee;
                    checkoutForm.action = "{{ route('checkout.process') }}"; // Asumsi QRIS diproses oleh checkout.process
                } else if (selectedMethod === 'Bank Transfer') {
                    currentConvenienceFee = bankTransferFee;
                    checkoutForm.action = "{{ route('checkout.process') }}"; // Asumsi Bank Transfer diproses oleh checkout.process
                } else if (selectedMethod === 'SoftPay') {
                    currentConvenienceFee = 0; // SoftPay fee is 0
                    checkoutForm.action = "{{ route('checkout.softpay') }}"; // Arahkan ke rute SoftPay
                }

                currentTotalAmount += currentConvenienceFee;

                convenienceFeeDisplay.textContent = formatRupiah(currentConvenienceFee);
                totalAmountDisplay.textContent = formatRupiah(currentTotalAmount);

                // Logika disable tombol untuk SoftPay jika saldo tidak cukup
                if (selectedMethod === 'SoftPay' && softpayBalance < currentTotalAmount) {
                    buyNowBtn.disabled = true;
                    buyNowBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    buyNowBtn.disabled = false;
                    buyNowBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

            // Panggil fungsi saat halaman dimuat untuk inisialisasi status tombol dan biaya
            updatePaymentDetailsAndButton();

            // Tambahkan event listener untuk setiap radio button pembayaran
            paymentRadios.forEach(radio => {
                radio.addEventListener('change', updatePaymentDetailsAndButton);
            });
            // --- AKHIR LOGIKA PEMBAYARAN & UPDATE BIAYA ---
        });
    </script>
    @endpush
@endsection