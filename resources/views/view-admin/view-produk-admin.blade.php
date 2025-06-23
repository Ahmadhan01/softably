<x-header-admin title="Product" />

<body class="bg-[#0f172a] text-white font-sans">
    <div class="flex min-h-screen">

        <x-sidebar-admin />

        <main class="flex-1 p-6 ml-64 space-y-6">
            <!-- Header Section -->
            <!-- Header & Search -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <h1 class="text-2xl font-bold">Manajemen Produk</h1>

                <form method="GET" action="{{ route('admin.products.index') }}" class="flex gap-2 w-full md:w-auto">
                    <input type="text" name="search" placeholder="Cari nama produk..."
                        class="bg-[#1e293b] text-white rounded px-4 py-2 w-full md:w-72 focus:outline-none"
                        value="{{ request('search') }}">

                    {{-- pertahankan filter kategori dan sort --}}
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">

                    <button class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white" type="submit">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Filter Kategori & Sort -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

                <!-- Filter Kategori -->
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-gray-400">Kategori:</span>

                    <a href="{{ route('admin.products.index', array_merge(request()->except('category'), ['category' => null])) }}"
                        class="px-3 py-1 rounded-full text-sm {{ request('category') == null ? 'bg-blue-600 text-white' : 'bg-[#334155] text-white' }}">
                        Semua
                    </a>

                    @php
                        $categories = ['Desain Grafis', 'Applications', 'Digital Content', 'Online Courses'];
                    @endphp

                    @foreach ($categories as $cat)
                        <a href="{{ route('admin.products.index', array_merge(request()->except('category'), ['category' => $cat])) }}"
                            class="px-3 py-1 rounded-full text-sm
                {{ request('category') == $cat ? 'bg-blue-600 text-white' : 'bg-[#334155] text-white' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>

                <!-- Sort -->
                <form method="GET" action="{{ route('admin.products.index') }}" class="flex items-center gap-2">
                    <span class="text-gray-400">Urutkan:</span>

                    <select name="sort" onchange="this.form.submit()"
                        class="bg-[#1e293b] text-white px-3 py-1 rounded">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Harga Terendah
                        </option>
                        <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Harga Tertinggi
                        </option>
                        <option value="bestseller" disabled>Terlaris</option>
                    </select>

                    {{-- pertahankan search dan kategori saat submit --}}
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                </form>
            </div>


            <!-- Produk Table -->
            <div class="overflow-x-auto bg-[#1e293b] rounded shadow">
                <table class="min-w-full text-sm text-white">
                    <thead>
                        <tr class="bg-[#334155] text-left text-sm uppercase">
                            <th class="px-4 py-3">Nama Produk</th>
                            <th class="px-4 py-3">Harga</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Seller</th>
                            <th class="px-4 py-3">Gambar</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse ($products as $product)
                            <tr class="hover:bg-[#1e2539]">
                                <td class="px-4 py-3">{{ $product->name }}</td>
                                <td class="px-4 py-3">Rp {{ number_format($product->price) }}</td>
                                <td class="px-4 py-3">{{ $product->category }}</td>
                                <td class="px-4 py-3">{{ $product->seller->name ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <img src="{{ $product->image_url }}" class="w-16 h-16 object-cover rounded"
                                        alt="gambar">
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 rounded text-xs {{ $product->status === 'active' ? 'bg-green-600' : 'bg-red-600' }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 space-x-1">
                                    <a href="javascript:void(0)" onclick="openEditModal({{ $product }})"
                                        class="text-blue-400 hover:underline">Edit</a>

                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-400">Tidak ada produk ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>


                <!-- Edit Modal -->
                <!-- Edit Modal -->
                <div id="editModal"
                    class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden items-center justify-center">
                    <div class="bg-[#1e293b] text-white rounded-lg w-full max-w-2xl p-6 relative shadow-lg">
                        <!-- Tombol Tutup -->
                        <button onclick="closeModal()"
                            class="absolute top-3 right-4 text-gray-300 hover:text-white text-xl">✖</button>

                        <h2 class="text-2xl font-semibold mb-4">Edit Produk</h2>

                        <form method="POST" action="" id="editForm"
                            class="space-y-4 md:grid md:grid-cols-2 md:gap-4">
                            @csrf
                            @method('PUT')

                            <!-- Kolom Kiri -->
                            <div class="col-span-1">
                                <label for="editName" class="block text-sm font-medium mb-1">Nama Produk</label>
                                <input type="text" name="name" id="editName"
                                    class="w-full p-2 rounded bg-gray-700 border border-gray-600">

                                <label for="editPrice" class="block text-sm font-medium mt-4 mb-1">Harga</label>
                                <input type="number" name="price" id="editPrice"
                                    class="w-full p-2 rounded bg-gray-700 border border-gray-600">

                                <label for="editCategory" class="block text-sm font-medium mt-4 mb-1">Kategori</label>
                                <input type="text" name="category" id="editCategory"
                                    class="w-full p-2 rounded bg-gray-700 border border-gray-600">

                                <label for="editStatus" class="block text-sm font-medium mt-4 mb-1">Status</label>
                                <select name="status" id="editStatus"
                                    class="w-full p-2 rounded bg-gray-700 border border-gray-600">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Nonaktif</option>
                                    <option value="blocked">Diblokir</option>
                                </select>
                            </div>

                            <!-- Kolom Kanan: Gambar Produk -->
                            <div class="col-span-1 flex flex-col items-center justify-center mt-4 md:mt-0">
                                <div class="w-40 h-40 rounded overflow-hidden shadow border border-gray-500">
                                    <img id="editImage" src="{{ asset('img/default-product.jpg') }}"
                                        alt="Gambar Produk" class="object-cover w-full h-full">
                                </div>
                                <p class="text-xs mt-2 text-gray-400 text-center">Preview gambar produk</p>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="col-span-2 flex justify-end pt-4">
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <div class="flex justify-between items-center mt-4 text-sm text-gray-400">
                <div>
                    Menampilkan {{ $products->firstItem() }} sampai {{ $products->lastItem() }} dari total
                    {{ $products->total() }} data
                </div>
                <div class="ml-4">
                    {{ $products->links() }}
                </div>
            </div>


        </main>
    </div>

    <script>
        function openEditModal(product) {
            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Set form action
            const form = document.getElementById('editForm');
            form.action = `/admin/products/${product.id}`;

            // Prefill data
            document.getElementById('editName').value = product.name;
            document.getElementById('editPrice').value = product.price;
            document.getElementById('editCategory').value = product.category ?? '';
            document.getElementById('editStatus').value = product.status ?? 'active';

            // Set gambar
            const image = document.getElementById('editImage');
            image.src = product.image_url ?? '{{ asset('img/default-product.jpg') }}';
        }

        function closeModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

</body>

</html>
