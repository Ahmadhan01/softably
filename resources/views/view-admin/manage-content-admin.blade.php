<x-header-admin title="Links" />

<body class="bg-[#0f172a] text-white font-sans">

    <div class="flex min-h-screen">

        <x-sidebar-admin />

        <main class="flex-1 p-6 space-y-6 ml-64">
            <h2 class="text-2xl font-semibold mb-10">Manajemen Link Seller</h2>



            <form method="GET" action="{{ route('admin.links.index') }}" class="flex flex-wrap gap-2 mb-4">
                <input type="text" name="user" placeholder="Cari Seller..." value="{{ request('user') }}"
                    class="bg-gray-700 text-white px-4 py-2 rounded placeholder-gray-400">

                <input type="date" name="date" value="{{ request('date') }}"
                    class="bg-gray-700 text-white px-4 py-2 rounded">

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white">
                    Filter
                </button>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-800 p-4 rounded shadow flex items-center justify-between">
                    <div>
                        <div class="text-gray-400 text-sm">Total Seller</div>
                        <div class="text-2xl font-bold">{{ $sellerCount ?? '0'}}</div>
                    </div>
                    <i class="fas fa-user-tag text-3xl text-blue-400"></i>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg shadow border border-gray-600">
                <table class="w-full text-sm text-left text-gray-300">
                    <thead class="bg-gray-700 text-gray-200">
                        <tr>
                            <th class="px-4 py-3">Seller</th>
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">URL</th>
                            <th class="px-4 py-3">Klik</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($links as $link)
                            <tr class="border-t border-gray-700 hover:bg-gray-800">
                                <td class="px-4 py-3">{{ $link->user->name }}</td>
                                <td class="px-4 py-3">{{ $link->title }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('link.redirect', $link->id) }}"
                                        class="text-blue-400 hover:underline" target="_blank">Lihat</a>
                                </td>
                                <td class="px-4 py-3">{{ $link->clicks ?? 0 }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="text-xs px-2 py-1 rounded {{ $link->status == 'active' ? 'bg-green-600' : 'bg-red-600' }}">
                                        {{ strtoupper($link->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $link->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-3 flex space-x-2">
                                    @if ($link->status === 'active')
                                        <form method="POST" action="{{ route('links.block', $link->id) }}">
                                            @csrf
                                            <button class="text-yellow-400 text-xs hover:underline">Suspend</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('links.activate', $link->id) }}">
                                            @csrf
                                            <button class="text-green-400 text-xs hover:underline">Restore</button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('links.destroy', $link->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-400 text-xs hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center px-4 py-3 text-gray-400">Tidak ada data link
                                    ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $links->withQueryString()->links() }}
            </div>

        </main>

    </div>
    <script src="js/chart.js" defer></script>

</body>

</html>
