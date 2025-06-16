<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notification Customer</title>
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
              class="flex items-center space-x-2 text-white bg-white/10 px-3 py-2 rounded"
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
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-2xl font-bold">Notification</h1>
          <button class="text-sm text-gray-300 hover:text-white">
            Mark as read
          </button>
        </div>

        <!-- Notification Card -->
        <div class="space-y-4">
          <!-- Notification Item (Unread) -->
          <div
            class="bg-[#1e293b] border border-gray-700 rounded-lg p-4 flex justify-between items-start"
          >
            <div class="flex items-start space-x-4">
              <div class="w-20 h-20 bg-gray-700 rounded-lg flex-shrink-0"></div>
              <div>
                <h2 class="font-semibold text-white">Transaction Successful</h2>
                <p class="text-sm text-gray-400">
                  Lorem ipsum dolor sit amet consectetur. Interdum quis urna
                  orci mollis lacus. Ac id id nullam interdum. Adipiscing urna
                  ligula et gravida ipsum nunc at consequat quis. Lorem risus
                  sed in amet lorem lobortis habitant quam.
                </p>
              </div>
            </div>
            <div class="flex items-center">
              <button
                class="bg-white text-xs text-black font-semibold px-3 py-1 rounded hover:bg-gray-300 transition"
              >
                Check
              </button>
            </div>
          </div>

          <!-- Repeat this for the other (read) notifications -->
          <div
            class="bg-[#1e293b] border border-gray-700 rounded-lg p-4 flex justify-between items-start opacity-60"
          >
            <div class="flex items-start space-x-4">
              <div class="w-20 h-20 bg-gray-700 rounded-lg flex-shrink-0"></div>
              <div>
                <h2 class="font-semibold text-white">Transaction Successful</h2>
                <p class="text-sm text-gray-400">
                  Lorem ipsum dolor sit amet consectetur. Interdum quis urna
                  orci mollis lacus. Ac id id nullam interdum. Adipiscing urna
                  ligula et gravida ipsum nunc at consequat quis. Lorem risus
                  sed in amet lorem lobortis habitant quam.
                </p>
              </div>
            </div>
            <div class="flex items-center">
              <button
                class="bg-white text-xs text-black font-semibold px-3 py-1 rounded hover:bg-gray-300 transition"
              >
                Check
              </button>
            </div>
          </div>
          <div
            class="bg-[#1e293b] border border-gray-700 rounded-lg p-4 flex justify-between items-start opacity-60"
          >
            <div class="flex items-start space-x-4">
              <div class="w-20 h-20 bg-gray-700 rounded-lg flex-shrink-0"></div>
              <div>
                <h2 class="font-semibold text-white">Transaction Successful</h2>
                <p class="text-sm text-gray-400">
                  Lorem ipsum dolor sit amet consectetur. Interdum quis urna
                  orci mollis lacus. Ac id id nullam interdum. Adipiscing urna
                  ligula et gravida ipsum nunc at consequat quis. Lorem risus
                  sed in amet lorem lobortis habitant quam.
                </p>
              </div>
            </div>
            <div class="flex items-center">
              <button
                class="bg-white text-xs text-black font-semibold px-3 py-1 rounded hover:bg-gray-300 transition"
              >
                Check
              </button>
            </div>
          </div>
          <div
            class="bg-[#1e293b] border border-gray-700 rounded-lg p-4 flex justify-between items-start opacity-60"
          >
            <div class="flex items-start space-x-4">
              <div class="w-20 h-20 bg-gray-700 rounded-lg flex-shrink-0"></div>
              <div>
                <h2 class="font-semibold text-white">Transaction Successful</h2>
                <p class="text-sm text-gray-400">
                  Lorem ipsum dolor sit amet consectetur. Interdum quis urna
                  orci mollis lacus. Ac id id nullam interdum. Adipiscing urna
                  ligula et gravida ipsum nunc at consequat quis. Lorem risus
                  sed in amet lorem lobortis habitant quam.
                </p>
              </div>
            </div>
            <div class="flex items-center">
              <button
                class="bg-white text-xs text-black font-semibold px-3 py-1 rounded hover:bg-gray-300 transition"
              >
                Check
              </button>
            </div>
          </div>

          <!-- Copy more blocks if needed -->
        </div>
      </main>
    </div>
  </body>
</html>
