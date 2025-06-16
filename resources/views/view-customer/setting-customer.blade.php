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
      <aside
        class="w-64 bg-[#1e293b] flex flex-col justify-between fixed top-0 left-0 h-full"
      >
        <div>
          <div class="p-4 text-xl font-bold border-b border-gray-700">
            <img src="img/logo-softably.png" alt="" width="120px" />
          </div>
          <nav class="p-4 space-y-2 text-sm text-gray-300">
            <a
              href="/produk_customer"
              class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded"
            >
              <i class="fa-solid fa-box" style="color: #ffffff"></i
              ><span>Product</span>
            </a>
            <a
              href="/cart_customer"
              class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded"
            >
              <i class="fa-solid fa-cart-shopping"></i><span>Cart</span>
            </a>
            <a
              href="/order_customer"
              class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded"
            >
              <i class="fa-solid fa-list-ul"></i><span>My Orders</span>
            </a>
            <a
              href="/notif_customer"
              class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded"
            >
              <i class="fa-solid fa-bell"></i><span>Notification</span>
              <span
                class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full"
                >4</span
              >
            </a>
            <a
              href="/chat_customer"
              class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded"
            >
              <i class="fa-solid fa-comments"></i><span>Chat</span>
              <span
                class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full"
                >10</span
              >
            </a>
            <a
              href="/faq_customer"
              class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded"
            >
              <i class="fa-solid fa-circle-question"></i><span>FAQ</span>
            </a>
          </nav>
          <div class="p-4 border-t border-gray-700">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 rounded-full overflow-hidden">
                <img
                  src="img/man.jpg"
                  alt=""
                  class="w-full h-full object-cover"
                />
              </div>
              <div>
                <div class="font-medium">Fuad Pharaoh</div>
                <div class="text-sm text-gray-400">
                  <a href="setting_customer.html">Account settings</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="p-4 space-y-2">
          <a
            href="/setting_customer"
            class="flex items-center space-x-2 text-gray-400 hover:text-white"
          >
            <span>⚙️</span><span>Settings</span>
          </a>
          <a
            href="/login"
            class="flex items-center space-x-2 text-gray-400 hover:text-white"
          >
            <span>🚪</span><span>Log Out</span>
          </a>
        </div>
      </aside>
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
