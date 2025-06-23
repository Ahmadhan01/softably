<x-header-admin title="Setting" />

<body class="bg-[#0f172a] text-white font-sans">
    <div class="flex min-h-screen">
        <x-sidebar-admin />

        <main class="flex-1 p-6 space-y-6 ml-64">
            <h2 class="text-2xl font-semibold mb-10">Settings</h2>

            <div class="flex bg-[#111C2E] rounded-md overflow-hidden">
                <x-settingbar-admin />

                <div class="w-3/4 p-6">
                    <h3 class="text-xl font-semibold mb-1">Personal Info</h3>
                    <p class="text-gray-400 text-sm mb-6">Update your personal details</p>

                    <form method="POST" action="{{ route('admin.setting.update') }}" enctype="multipart/form-data"
                        class="space-y-5">
                        @csrf
                        @method('PUT')

                        <!-- Foto profil + upload -->
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-10 h-10 rounded-full overflow-hidden bg-white">
                                @php
                                $imagePath = Auth::user()->profile_picture
                                ? url('storage/profile/' . Auth::user()->profile_picture)
                                : asset('img/man.jpg');
                                @endphp
                                <img src="{{ url('profile/' . Auth::user()->profile_picture) . '?t=' . time() }}">

                            </div>

                            <label
                                class="px-4 py-1 bg-[#1E293B] text-white text-sm rounded border border-gray-500 cursor-pointer">
                                Upload Image
                                <input type="file" name="profile_picture" accept="profile_picture/*" class="hidden">
                            </label>
                            <span class="text-xs text-gray-400">JPG or PNG. 1MB Max</span>
                        </div>

                        <!-- Nama -->
                        <div>
                            <label class="block text-sm mb-1">Full name</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                                class="w-full bg-[#0E1A2B] border border-gray-700 rounded px-4 py-2 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm mb-1">Username</label>
                            <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}"
                                class="w-full bg-[#0E1A2B] border border-gray-700 rounded px-4 py-2 text-sm">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                class="w-full bg-[#0E1A2B] border border-gray-700 rounded px-4 py-2 text-sm">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm mb-1">Phone number</label>
                            <input type="text" name="phone_number"
                                value="{{ old('phone_number', Auth::user()->phone_number) }}"
                                class="w-full bg-[#0E1A2B] border border-gray-700 rounded px-4 py-2 text-sm">
                        </div>

                        <!-- Tanggal lahir -->
                        <div>
                            <label class="block text-sm mb-1">Date of birth</label>
                            <input type="date" name="date_of_birth"
                                value="{{ old('date_of_birth', Auth::user()->date_of_birth) }}"
                                class="w-full bg-[#0E1A2B] border border-gray-700 rounded px-4 py-2 text-sm text-white">
                        </div>

                        <!-- Negara -->
                        <div>
                            <label class="block text-sm mb-1">Country</label>
                            <input type="text" name="country" value="Indonesia"
                                class="w-full bg-[#0E1A2B] border border-gray-700 rounded px-4 py-2 text-sm " disabled>
                        </div>

                        <div class="flex justify-end gap-4 mt-6">
                            <button type="reset" class="px-6 py-2 bg-red-600 text-white rounded">Cancel</button>
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>