<aside class="w-64 bg-[#1e293b] flex flex-col justify-between fixed top-0 left-0 h-full">
    <div>
        <div class="p-4 text-xl font-bold border-b border-gray-700">
            <img src="{{ asset('img/softably-baru.png') }}" alt="" width="120px" />
        </div>
        <nav class="p-4 space-y-2 text-sm text-gray-300">
            <a href="/admin/dashboard" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                <i class="fa-solid fa-gauge"></i><span>Dashboard</span>
            </a>
            <a href="/admin/products" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                <i class="fa-solid fa-cart-shopping"></i><span>Product</span>
            </a>
            <a href="/admin/links" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                <i class="fa-solid fa-link"></i><span>Links</span>
            </a>
            <a href="/table-user" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                <i class="fa-solid fa-user"></i><span>Table User</span>
            </a>
            <a href="/manage-complain" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                <i class="fa-solid fa-comments"></i><span>Chat</span>
                <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">10</span>
            </a>
            <a href="/notif-admin" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                <i class="fa-solid fa-bell"></i><span>Notification</span>
                <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">4</span>
            </a>
            <a href="/helpcenter-admin" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                <i class="fa-solid fa-question"></i><span>Help Center</span>
            </a>
        </nav>
        <div class="p-4 border-t border-gray-700">
            <div class="flex items-center space-x-3">
                <div class="relative w-10 h-10">
                    @php
                    $profile_picture = Auth::user()->profile_picture ? url('profile/' . Auth::user()->profile_picture) :
                    asset('img/man.jpg');
                    @endphp

                    <div class="rounded-full overflow-hidden w-full h-full z-0">
                        <img src="{{ $profile_picture . '?t=' . time() }}" alt="photo"
                            class="object-cover w-full h-full">
                    </div>

                    {{-- Badge status di atas avatar --}}
                    <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 rounded-full border-2 border-[#1e293b]
        {{ Auth::user()->isOnline() ? 'bg-green-500' : 'bg-gray-400' }} z-10">
                    </span>
                </div>
                <div>
                    <div class="font-medium">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-gray-400"><a href="/setting-admin">Account settings</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="p-4 space-y-2">
        <a href="/setting-admin" class="flex items-center space-x-2 text-gray-400 hover:text-white">
            <i class="fa-solid fa-gear"></i><span>Settings</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center space-x-2 text-gray-400 hover:text-white">
                <i class="fa-solid fa-door-open"></i><span>Log Out</span>
            </button>
        </form>
    </div>
</aside>