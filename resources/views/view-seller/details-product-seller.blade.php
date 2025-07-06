@extends('layouts.sidebar-seller')

@section('isi')
<div class="flex min-h-screen bg-[#0f172a] text-white">
    <main class="flex-1 p-8 ml-64">
        <div class="flex items-center mb-6">
            <a href="javascript:history.back()" class="text-gray-400 hover:text-white mr-4">
                <i class="fa-solid fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-2xl font-bold">Details Product</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            {{-- Product Image Section --}}
            <div>
                <div class="bg-[#1e293b] rounded-lg p-4 flex items-center justify-center relative overflow-hidden w-full mx-auto"
                    style="padding-top: 56.25%;"> {{-- Mengatur rasio tinggi:lebar sekitar 9:16 --}}
                    @if($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                        class="absolute inset-0 w-full h-full object-cover rounded-lg mb-4">
                    @else
                    <div
                        class="absolute inset-0 w-full h-full bg-gray-700 rounded-lg flex items-center justify-center text-gray-400 text-2xl">
                        No Image
                    </div>
                    @endif
                </div>

                {{-- Product Sold, Wishlist, Cart Section --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8 w-full mx-auto">
                    <div class="bg-green-600 rounded-lg p-4 flex flex-col items-center justify-center text-center">
                        <div class="flex items-center justify-between w-full mb-2">
                            <span class="text-lg font-semibold">Product Sold</span>
                            <button class="text-white">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                        </div>
                        <p class="text-3xl font-bold">{{ $productSold }}</p>
                    </div>
                    <div class="bg-orange-500 rounded-lg p-4 flex flex-col items-center justify-center text-center">
                        <div class="flex items-center justify-between w-full mb-2">
                            <span class="text-lg font-semibold">Product Wishlist</span>
                            <button class="text-white">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                        </div>
                        <p class="text-3xl font-bold">{{ $productWishlistCount }}</p>
                    </div>
                    <div class="bg-purple-600 rounded-lg p-4 flex flex-col items-center justify-center text-center">
                        <div class="flex items-center justify-between w-full mb-2">
                            <span class="text-lg font-semibold">Product Cart</span>
                            <button class="text-white">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                        </div>
                        <p class="text-3xl font-bold">{{ $productCartCount }}</p>
                    </div>
                </div>
            </div>


            {{-- Product Details Section --}}
            <div class="bg-[#1e293b] rounded-lg p-6 flex flex-col"> {{-- Tambahkan flex flex-col --}}
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-600 flex-shrink-0">
                            {{-- Menampilkan gambar profil seller --}}
                            <img src="{{ $product->user->profile_picture_url }}" alt="Seller Profile"
                                class="w-full h-full object-cover">
                        </div>
                        <div>
                            {{-- Menampilkan nama seller --}}
                            <h2 class="text-xl font-semibold">{{ $product->user->name }}</h2>
                        </div>
                    </div>
                    <a href="{{ route('seller.products.edit', $product->id) }}"
                        class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">
                        Edit
                    </a>
                </div>

                <h3 class="text-xl font-bold mb-2">{{ $product->name }}</h3>
                <p class="text-gray-400 mb-4 text-sm flex-1"> {{-- Tambahkan flex-1 agar push harga ke bawah --}}
                    {{ $product->description }}
                </p>

                {{-- PERUBAHAN DI SINI: Pindahkan harga ke bawah --}}
                <p class="text-right text-3xl font-bold text-white mt-auto"> {{-- Tambahkan mt-auto --}}
                    {{ $product->currency }} {{ number_format($product->price, 0, ',', '.') }}
                </p>
            </div>
        </div>

        {{-- Recent Transaction Section --}}
        <div class="bg-[#1e293b] rounded-lg p-6 mb-8">
            <h3 class="text-xl font-bold mb-4">Recent Transaction</h3>
            <div class="space-y-4">
                @forelse($transactions as $transaction)
                <div class="flex items-center justify-between py-2 border-b border-gray-700 last:border-b-0">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-handshake text-green-500"></i> {{-- Icon untuk transaksi --}}
                        <span>{{ $transaction['user_name'] }}</span>
                    </div>
                    <span class="text-gray-400 text-sm">{{ $transaction['user_email'] }}</span>
                    <span class="text-gray-400 text-sm">{{ $transaction['user_phone'] }}</span>
                </div>
                @empty
                <p class="text-gray-400 text-center">Belum ada transaksi untuk produk ini.</p>
                @endforelse
            </div>
        </div>

        {{-- Comment Section --}}
        <div class="bg-[#1e293b] rounded-lg p-6">
            <h3 class="text-xl font-bold mb-4">Comment</h3>
            <div class="space-y-6">
                @forelse($product->comments as $comment) {{-- Looping hanya komentar utama --}}
                <div class="flex space-x-4">
                    <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-600 flex-shrink-0">
                        <img src="{{ $comment->user->profile_picture_url }}" alt="User Profile"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-white">{{ $comment->user->name }}</p>
                        <p class="text-gray-400 text-sm mb-2">
                            {{ $comment->content }}
                        </p>
                        <div class="flex items-center space-x-4 text-sm">
                            {{-- Tombol Delete (hanya jika seller adalah pemilik produk ATAU pemilik komentar) --}}
                            @if(Auth::id() == $product->user_id || Auth::id() == $comment->user_id)
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400">
                                    <i class="fa-solid fa-trash-can mr-1"></i>Delete
                                </button>
                            </form>
                            @endif
                            <button class="text-gray-400 hover:text-white"
                                onclick="showReplyForm({{ $comment->id }})">Reply</button>
                        </div>

                        {{-- Form Balas Komentar --}}
                        <div id="reply-form-{{ $comment->id }}" class="hidden mt-4 pl-10">
                            <form action="{{ route('comments.reply', $comment->id) }}" method="POST">
                                @csrf
                                <textarea name="content" rows="2"
                                    class="w-full bg-[#1e293b] border border-gray-600 text-white p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Balas komentar..."></textarea>
                                <button type="submit"
                                    class="mt-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                                    Kirim Balasan
                                </button>
                                <button type="button" onclick="hideReplyForm({{ $comment->id }})"
                                    class="mt-2 ml-2 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">
                                    Batal
                                </button>
                            </form>
                        </div>

                        {{-- Balasan Komentar --}}
                        @foreach($comment->replies as $reply)
                        <div class="flex space-x-4 ml-14 mt-4"> {{-- Indent untuk balasan --}}
                            <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-600 flex-shrink-0">
                                <img src="{{ $reply->user->profile_picture_url }}" alt="User Profile"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-white">{{ $reply->user->name }}</p>
                                <p class="text-gray-400 text-sm mb-2">
                                    {{ $reply->content }}
                                </p>
                                <div class="flex items-center space-x-4 text-sm">
                                    {{-- Tombol Delete untuk balasan (hanya jika seller adalah pemilik produk ATAU pemilik balasan) --}}
                                    @if(Auth::id() == $product->user_id || Auth::id() == $reply->user_id)
                                    <form action="{{ route('comments.destroy', $reply->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus balasan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400">
                                            <i class="fa-solid fa-trash-can mr-1"></i>Delete
                                        </button>
                                    </form>
                                    @endif
                                    {{-- Tidak ada tombol reply untuk balasan dari balasan --}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <p class="text-gray-400 text-center">Belum ada komentar untuk produk ini.</p>
                @endforelse

                {{-- Form Komentar Baru dari Seller/User --}}
                <div class="mt-8 pt-6 border-t border-gray-700">
                    <h4 class="text-lg font-semibold mb-3">Tinggalkan Komentar Baru</h4>
                    <form action="{{ route('comments.store', $product->id) }}" method="POST">
                        @csrf
                        <textarea name="content" rows="4"
                            class="w-full bg-[#1e293b] border border-gray-600 text-white p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Tulis komentar baru Anda di sini..."></textarea>
                        <button type="submit"
                            class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                            Kirim Komentar
                        </button>
                    </form>
                </div>
            </div>
    </main>
</div>

<script>
function showReplyForm(commentId) {
    document.querySelectorAll('[id^="reply-form-"]').forEach(form => {
        form.classList.add('hidden'); // Sembunyikan semua form balasan yang mungkin terbuka
    });
    document.getElementById('reply-form-' + commentId).classList.remove('hidden');
}

function hideReplyForm(commentId) {
    document.getElementById('reply-form-' + commentId).classList.add('hidden');
}
</script>
@endsection