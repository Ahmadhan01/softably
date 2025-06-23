<x-header-admin title="Apps Setting" />

<body class="bg-[#0f172a] text-white font-sans">
    <div class="flex min-h-screen">
        <x-sidebar-admin />

        <main class="flex-1 p-6 space-y-6 ml-64">
            <h2 class="text-2xl font-semibold mb-10">Settings</h2>

            <div class="flex bg-[#111C2E] rounded-md overflow-hidden">
                <x-settingbar-admin />

                <div class="w-3/4 p-6">

                    <h2 class="text-xl font-semibold mb-4">Apps Settings</h2>
                    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf
                        <div>
                            <label class="block mb-1 text-sm">App Name</label>
                            <input type="text" name="app_name"
                                value="{{ old('app_name', $settings['app_name']->value ?? '') }}"
                                class="bg-gray-700 text-white px-4 py-2 rounded w-full" />
                        </div>

                        <div>
                            <label class="block mb-1 text-sm">Logo</label>
                            <input type="file" name="app_logo"
                                class="bg-gray-700 text-white px-4 py-2 rounded w-full file:bg-blue-600 file:text-white" />
                        </div>

                        <div>
                            <label class="block mb-1 text-sm">Favicon</label>
                            <input type="file" name="favicon"
                                class="bg-gray-700 text-white px-4 py-2 rounded w-full file:bg-blue-600 file:text-white" />
                        </div>



                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white">Save
                            Settings</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
