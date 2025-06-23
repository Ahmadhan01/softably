<x-header-admin title="Table User" />

<body class="bg-[#0f172a] text-white font-sans">

    <div class="flex min-h-screen">

       <x-sidebar-admin />

        <main class="flex-1 p-6 space-y-6 ml-64">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <h1 class="text-2xl font-semibold">Table User</h1>
                <form method="GET" action="{{ route('admin.user.index') }}" class="flex flex-wrap gap-3 items-center">

                    <!-- Search Input -->
                    <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}"
                        class="bg-gray-700 text-sm rounded-lg px-4 py-2 text-white w-64 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500" />

                    <!-- Role Dropdown -->
                    <select name="role" onchange="this.form.submit()"
                        class="bg-gray-700 text-sm text-white rounded-lg px-4 pr-5 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="seller" {{ request('role') == 'seller' ? 'selected' : '' }}>Seller</option>
                        <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                    </select>

                    <!-- Filter Button -->
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Filter
                    </button>
                </form>
            </div>



            <div class="grid grid-cols-2 gap-4">

                <div class="bg-gray-800 p-4 rounded-xl flex items-center justify-between border border-blue-500">
                    <div class="flex items-center space-x-4">
                        <div
                            class="bg-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-300">Total Users</div>
                            <div class="text-xl font-semibold text-white">{{ number_format($totalUsers) }}</div>
                        </div>
                    </div>
                    <div class="text-gray-400">⋮</div>
                </div>


                <div class="bg-gray-800 p-4 rounded-xl flex items-center justify-between border border-blue-500">
                    <div class="flex items-center space-x-4">
                        <div
                            class="bg-blue-600 text-white rounded-full w-12 h-12 flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-300">New Users This Week</div>
                            <div class="text-xl font-semibold text-white">{{ number_format($newUsers) }}</div>
                        </div>
                    </div>
                    <div class="text-gray-400">⋮</div>
                </div>
            </div>

            <div class="bg-gray-800 rounded-lg overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-700 text-gray-300">
                        <tr>
                            <th class="p-3">No</th>
                            <th class="p-3">Username</th>
                            <th class="p-3">Name</th>
                            <th class="p-3">Phone</th>
                            <th class="p-3">Country</th>
                            <th class="p-3">Role</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Last Seen</th>
                            <th class="p-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-700">
                                <td class="p-3">{{ $loop->iteration }}</td>
                                <td class="p-3">{{ $user->username }}</td>
                                <td class="p-3">
                                    <div>
                                        <div class="font-semibold">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-400">{{ $user->email }}</div>
                                    </div>
                                </td>
                                <td class="p-3">{{ $user->phone ?? '-' }}</td>
                                <td class="p-3">{{ $user->country ?? '-' }}</td>
                                <td class="p-3">
                                    @php
                                        $roleColors = [
                                            'admin' => 'bg-red-600',
                                            'seller' => 'bg-blue-600',
                                            'customer' => 'bg-green-600',
                                        ];
                                    @endphp
                                    <span
                                        class="px-2 py-1 rounded text-sm text-white {{ $roleColors[$user->role] ?? 'bg-gray-500' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="p-3">
                                    @if ($user->is_banned)
                                        <span
                                            class="px-2 py-1 rounded text-sm font-semibold bg-red-600 text-white">BANNED</span>
                                    @else
                                        @if ($user->isOnline())
                                            <span
                                                class="px-2 py-1 rounded text-sm font-semibold bg-green-600 text-white">ONLINE</span>
                                        @else
                                            <span
                                                class="px-2 py-1 rounded text-sm font-semibold bg-gray-500 text-white">OFFLINE</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="p-3 text-sm text-gray-300">
                                    @if ($user->isOnline())
                                        <span class="text-green-400">Online Now</span>
                                    @elseif ($user->last_seen)
                                        {{ $user->last_seen->diffForHumans() }}
                                    @else
                                        <span class="italic text-gray-500">Never</span>
                                    @endif
                                </td>

                                <td class="p-3">
                                    <div
                                        class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-2">
                                        <!-- Button DETAIL -->
                                        <button onclick="openModal({{ $user->id }})"
                                            class="text-blue-600 hover:underline text-sm">
                                            DETAIL
                                        </button>

                                        <!-- Button BAN/UNBAN -->
                                        @if ($user->is_banned)
                                            <form method="POST" action="{{ route('users.unban', $user->id) }}">
                                                @csrf
                                                <button type="submit" class="text-green-400 hover:underline text-sm">
                                                    UNBAN
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('users.ban', $user->id) }}">
                                                @csrf
                                                <button type="submit" class="text-red-400 hover:underline text-sm">
                                                    BAN
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4 text-gray-400">
                    {{ $users->links() }}
                </div>
            </div>

            @foreach ($users as $user)
                <div id="modal-{{ $user->id }}"
                    class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 items-center justify-center">
                    <div
                        class="bg-gray-800 p-6 rounded-lg w-full max-w-md shadow-xl relative flex flex-col items-center text-center">
                        <!-- Tombol Tutup -->
                        <button onclick="closeModal({{ $user->id }})"
                            class="absolute top-2 right-4 text-white text-2xl">&times;</button>

                        <!-- Avatar -->
                        <div class="flex justify-center mb-4">
                            <img src="{{ $user->image ? url('profile/' . $user->image) . '?t=' . time() : asset('img/man.jpg') }}"
                                alt="Avatar"
                                class="w-24 h-24 rounded-full object-cover border-2 border-blue-500 shadow-lg">
                        </div>

                        <!-- Info User -->
                        <div class="space-y-2 text-gray-200 text-sm">
                            <p><strong>Username:</strong> {{ $user->username }}</p>
                            <p><strong>Name:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Phone:</strong> {{ $user->phone ?? '-' }}</p>
                            <p><strong>Country:</strong> {{ $user->country ?? '-' }}</p>
                            <p><strong>Role:</strong> {{ $user->role }}</p>
                            <p><strong>Status:</strong> {{ $user->is_banned ? 'BANNED' : 'ACTIVE' }}</p>
                        </div>

                        <div class="mt-6">
                            <button onclick="closeModal({{ $user->id }})"
                                class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded text-white">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </main>

    </div>


    <script>
        function openModal(id) {
            document.getElementById('modal-' + id).classList.remove('hidden');
            document.getElementById('modal-' + id).classList.add('flex');
        }

        function closeModal(id) {
            document.getElementById('modal-' + id).classList.add('hidden');
            document.getElementById('modal-' + id).classList.remove('flex');
        }
    </script>

</body>

</html>
