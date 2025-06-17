@extends('layouts.sidebar')

@section('isi')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/1531486bb6.js" crossorigin="anonymous"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-bg': '#23293a',
                        'dark-card': '#23293a',
                        'dark-hover': '#374151',
                        'sidebar': '#23293a',
                        'sidebar-active': '#fff',
                        'sidebar-inactive': '#23293a',
                        'sidebar-text': '#fff',
                        'sidebar-hover': '#2d3748',
                        'main-bg': '#23293a',
                        'main-card': '#23293a',
                        'main-border': '#23293a',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-[#23293a] text-white min-h-screen font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 b flex flex-col justify-between relative z-10">
            
        </div>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <div class="border-l flex justify-between items-center border-b border-gray-700 px-8 py-6">
                <h1 class="text-2xl font-bold">Help Center</h1>
                <span class="text-lg font-light">Talk with Softably</span>
            </div>
            <div class="flex flex-1 overflow-hidden">
                <!-- Left: Topics -->
                <div class="border-l w-80 bg-transparent border-r border-gray-700 p-6 flex flex-col">
                    <div class="mb-4">
                        <div class="relative">
                            <input type="text" placeholder="Search topic"
                                class="w-full bg-gray-800 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pl-10" />
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                        </div>
                    </div>
                    <ul class="space-y-2 text-gray-200 text-base">
                        <li
                            class="ml-2 hover:bg-gray-700 rounded-lg transition-colors cursor-pointer flex items-center gap-2">
                            <i class="fa-solid fa-house"></i> Home</li>
                        <li
                            class="ml-2 hover:bg-gray-700 rounded-lg transition-colors cursor-pointer flex items-center gap-2">
                            <i class="fa-solid fa-rocket"></i> Get Started</li>
                        <li
                            class="ml-2 hover:bg-gray-700 rounded-lg transition-colors cursor-pointer flex items-center gap-2">
                            <i class="fa-solid fa-circle-info"></i> What is Softably</li>
                        <li
                            class="ml-2 hover:bg-gray-700 rounded-lg transition-colors cursor-pointer flex items-center gap-2">
                            <i class="fa-solid fa-question"></i> FAQ</li>
                    </ul>
                </div>
                <!-- Right: Chat Area -->
                <div class="flex-1 flex flex-col bg-[#23293a] p-6 relative">
                    <div class="flex justify-center mb-4">
                        <button class="bg-gray-800 text-white px-6 py-2 rounded-lg font-semibold">Hari ini</button>
                    </div>
                    <div class="space-y-4 flex-1 overflow-y-auto">
                        <div class="bg-gray-800 rounded-lg p-4 text-sm">
                            Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas suspendisse lorem. Mauris neque
                            amet purus commodo nulla tellus massa. Amet nisi nibh fermentum cras tincidunt feugiat leo
                            id. A odio leo gravida lectus ipsum.
                        </div>
                        <div class="bg-gray-800 rounded-lg p-4 text-sm">
                            Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas suspendisse lorem. Mauris neque
                            amet purus commodo nulla tellus massa. Amet nisi nibh fermentum cras tincidunt feugiat leo
                            id. A odio leo gravida lectus ipsum.
                        </div>
                    </div>
                    <!-- Chat Input -->
                    <form class="flex items-center mt-6" onsubmit="event.preventDefault();">
                        <input type="text" placeholder="Type your message..."
                            class="flex-1 bg-white text-gray-900 px-4 py-3 rounded-l-lg focus:outline-none" />
                        <button type="submit"
                            class="bg-white px-6 py-6 w-4 h-4 border-l bg-black-900 rounded-r-lg flex items-center justify-center">
                            <i class="fa-solid fa-paper-plane text-2xl text-[#23293a]"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Responsive Sidebar Toggle (Mobile) -->
    <script>
        // Add your responsive sidebar toggle logic here if needed
    </script>
</body>
</html>
@endsection