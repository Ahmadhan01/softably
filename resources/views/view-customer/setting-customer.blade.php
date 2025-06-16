@extends('layouts.sidebar')

@section('isi')
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Setting Customer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
  </head>
  <body class="bg-[#0f172a] text-white font-sans">
    <div class="flex min-h-screen">
      <main class="flex-1 p-6 space-y-6 ml-64">
        <div class="text-white space-y-6">
          <h1 class="text-2xl font-semibold">Settings</h1>
          <div class="flex space-x-10">
            <!-- Sidebar Settings -->
            <div class="w-1/6 text-sm space-y-6">
              <div class="space-y-4">
                <div class="text-gray-300">Apps settings</div>
                <div class="text-blue-400 font-semibold">Account</div>
                <div class="text-gray-300">Language & Region</div>
              </div>
            </div>

            <!-- Form Section -->
            <div class="w-5/6">
              <div class="bg-[#1e293b] p-6 rounded-md space-y-6">
                <!-- Title and Buttons -->
                <div class="flex justify-between items-center">
                  <div>
                    <h2 class="text-lg font-bold">Personal Info</h2>
                    <p class="text-sm text-gray-400">
                      Update your personal details
                    </p>
                  </div>
                  <div class="space-x-2">
                    <button
                      class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-1 rounded"
                    >
                      Cancel
                    </button>
                    <button
                      class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-1 rounded"
                    >
                      Save
                    </button>
                  </div>
                </div>

                <!-- Photo Upload -->
                <div class="flex items-center space-x-4">
                  <div class="w-12 h-12 rounded-full bg-white">
                    <img
                      src="img/man.jpg"
                      alt=""
                      width="100"
                      class="rounded-full"
                    />
                  </div>
                  <div class="space-y-1">
                    <button
                      class="bg-[#334155] hover:bg-[#475569] text-white text-xs px-3 py-1 rounded"
                    >
                      Upload image
                    </button>
                    <p class="text-[10px] text-gray-400">JPG or PNG. 1MB Max</p>
                  </div>
                </div>

                <!-- Form Inputs -->
                <form class="space-y-4 text-sm">
                  <!-- Full Name -->
                  <div>
                    <label class="block text-gray-400 mb-1">Full name</label>
                    <input
                      type="text"
                      value="Fuad Pharaoh"
                      class="w-full px-3 py-2 bg-[#0f172a] border border-[#334155] rounded text-white"
                    />
                  </div>

                  <!-- Email -->
                  <div>
                    <label class="block text-gray-400 mb-1">Email</label>
                    <input
                      type="email"
                      value="fuad3@gmail.com"
                      class="w-full px-3 py-2 bg-[#0f172a] border border-[#334155] rounded text-white"
                    />
                  </div>

                  <!-- Phone Number -->
                  <div>
                    <label class="block text-gray-400 mb-1">Phone number</label>
                    <div class="flex space-x-2">
                      <input
                        type="text"
                        value="08765 2324 2342"
                        class="flex-1 px-3 py-2 bg-[#0f172a] border border-[#334155] rounded text-white"
                      />
                    </div>
                  </div>

                  <!-- Date of Birth -->
                  <div>
                    <label class="block text-gray-400 mb-1"
                      >Date of birth</label
                    >
                    <input
                      type="date"
                      value="2001-02-21"
                      class="w-full px-3 py-2 bg-[#0f172a] border border-[#334155] rounded text-white"
                    />
                  </div>

                  <!-- Country -->
                  <div>
                    <label class="block text-gray-400 mb-1">Country</label>
                    <input
                      type="text"
                      value="Indonesia"
                      class="w-full px-3 py-2 bg-[#0f172a] border border-[#334155] rounded text-white"
                      disabled
                    />
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <script src="js/index.js" defer></script>
  </body>
</html>
@endsection