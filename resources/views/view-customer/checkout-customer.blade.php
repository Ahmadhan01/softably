<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CheckOut Customer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
  </head>

  <body class="bg-[#0f172a] text-white font-sans">
    <div class="flex min-h-screen">
       <aside class="w-64 bg-[#1e293b] flex flex-col justify-between fixed top-0 left-0 h-full">
            <div>
                <div class="p-4 text-xl font-bold border-b border-gray-700"><img src="img/logo-softably.png" alt="" width="120px"></div>
                <nav class="p-4 space-y-2 text-sm text-gray-300">

                    <a href="/produk_customer"
                        class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fa-solid fa-box" style="color: #ffffff;"></i><span>Product</span>
                    </a>
                    <a href="/cart_customer" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fa-solid fa-cart-shopping"></i><span>Cart</span>
                    </a>
                    <a href="/order_customer" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fa-solid fa-list-ul"></i><span>My Orders</span>
                    </a>
                    <a href="/notif_customer" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fa-solid fa-bell"></i><span>Notification</span>
                        <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">4</span>
                    </a>
                    <a href="/chat_customer" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fa-solid fa-comments"></i><span>Chat</span>
                        <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full">10</span>
                    </a>
                    <a href="/faq_customer" class="flex items-center space-x-2 hover:bg-white/10 px-3 py-2 rounded">
                        <i class="fa-solid fa-circle-question"></i><span>FAQ</span>
                    </a>
                </nav>
                <div class="p-4 border-t border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full overflow-hidden">
                            <img src="img/man.jpg" alt="" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <div class="font-medium">Fuad Pharaoh</div>
                            <div class="text-sm text-gray-400"><a href="setting_customer.html">Account settings</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 space-y-2">
                <a href="setting_customer.html" class="flex items-center space-x-2 text-gray-400 hover:text-white">
                    <span>⚙️</span><span>Settings</span>
                </a>
                <a href="login.html" class="flex items-center space-x-2 text-gray-400 hover:text-white">
                    <span>🚪</span><span>Log Out</span>
                </a>
            </div>
        </aside>

      <main class="flex-1 p-6 space-y-6 ml-64">
        <div class="text-white">
          <a href="cart_customer.html" class="text-sm text-white hover:underline "><i
                    class="fa-solid fa-arrow-left"></i>&nbsp; Checkout</a>

          <!-- Product List -->
          <div class="bg-[#1e293b] rounded-lg p-6 shadow-md mb-6 mt-4">
            <h2 class="text-xl font-semibold mb-4">Product</h2>

            <!-- Product Item -->
            <div class="flex items-start justify-between mb-4">
              <div class="flex">
                <div class="w-28 h-28 bg-white rounded-md mr-4"></div>
                <div>
                  <h3 class="text-md font-semibold">Template canva</h3>
                  <p class="text-sm text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                    suspendisse lorem. Mauris in quam amet purus commodo nulla
                    tellus massa.
                  </p>
                </div>
              </div>
              <div
                class="flex items-start ml-6 self-start text-md font-bold space-x-1 mt-6"
              >
                <span>Rp</span>
                <span>57.999,00</span>
              </div>
            </div>

            <!-- Product Item -->
            <div class="flex items-start justify-between">
              <div class="flex">
                <div class="w-28 h-28 bg-white rounded-md mr-4"></div>
                <div>
                  <h3 class="text-md font-semibold">Template canva</h3>
                  <p class="text-sm text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                    suspendisse lorem. Mauris in quam amet purus commodo nulla
                    tellus massa.
                  </p>
                </div>
              </div>
              <div
                class="flex items-start ml-6 self-start text-md font-bold space-x-1 mt-6"
              >
                <span>Rp</span>
                <span>57.999,00</span>
              </div>
            </div>
          </div>

          <!-- Buyer + Payment Info -->
          <div class="grid md:grid-cols-2 gap-6">
            <!-- Buyer Info -->
            <div class="bg-[#1e293b] rounded-lg p-6 shadow-md">
              <h2 class="text-xl font-semibold mb-4">Buyer info</h2>
              <div class="space-y-4">
                <div>
                  <label class="block mb-1 text-sm">Email</label>
                  <input
                    type="email"
                    placeholder="ahmad@gmail.com"
                    class="w-full px-4 py-2 rounded-md text-black"
                    disabled
                  />
                </div>
                <div>
                  <label class="block mb-1 text-sm">Name</label>
                  <input
                    type="text"
                    placeholder="Ahmadhan"
                    class="w-full px-4 py-2 rounded-md text-black"
                    disabled
                  />
                </div>
                <div>
                  <label class="block mb-1 text-sm">Phone Number</label>
                  <input
                    type="text"
                    placeholder="0893847593489"
                    class="w-full px-4 py-2 rounded-md text-black"
                    disabled
                  />
                </div>
              </div>
            </div>

            <!-- Payment Detail -->
            <div class="bg-[#1e293b] rounded-lg p-6 shadow-md">
              <h2 class="text-xl font-semibold mb-4">Payment detail</h2>
              <div class="text-sm text-gray-300 space-y-2">
                <div class="flex justify-between">
                  <span>Sub total</span>
                  <span>Rp. 59.999,00</span>
                </div>
                <div class="flex justify-between">
                  <span>Discount</span>
                  <span>0</span>
                </div>
                <div class="flex justify-between">
                  <span>Convenience fee</span>
                  <span>Rp. 15.000,00</span>
                </div>
              </div>

              <div
                class="flex justify-between items-center mt-4 text-xl font-bold"
              >
                <span>Total</span>
                <span class="text-orange-400">Rp. 113.000,00</span>
              </div>

              <button
                class="w-full bg-transparent border border-green-500 text-green-500 hover:bg-green-500 hover:text-white flex items-center justify-center space-x-2 py-2 px-4 rounded-lg mt-4"
              >
                <i class="fa-solid fa-wallet"></i>
                <span>Select payment method</span>
                <i class="fa-solid fa-chevron-right ml-auto"></i>
              </button>

              <div class="flex items-center mt-4">
                <input
                  type="checkbox"
                  id="terms"
                  checked
                  class="form-checkbox text-green-500 mr-2"
                />
                <label for="terms" class="text-sm text-gray-300"
                  >I agree to the Terms of Use</label
                >
              </div>

              <button
                id="buyNowBtn"
                class="w-full mt-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg"
              >
                Buy Now
              </button>
            </div>
          </div>
        </div>
      </main>
    </div>
    <!-- Modal -->
    <div
      id="successModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden"
    >
      <div
        class="bg-[#1e293b] text-white rounded-lg w-full max-w-md p-6 shadow-lg text-center"
      >
        <h2 class="text-xl font-bold mb-2">Your purchase was successful</h2>
        <p class="text-sm text-gray-400 mb-4">
          We sent the receipt to maman@gmail.com
        </p>

        <div class="text-left space-y-3 mb-4">
          <div class="flex items-center w-full">
            <div class="flex items-center space-x-4">
              <div class="w-16 h-16 bg-white rounded-md"></div>
              <div>
                <p class="font-semibold text-sm">Template canva</p>
                <p class="text-xs">x2</p>
              </div>
            </div>
            <div class="ml-auto font-bold">Rp. 59.999,00</div>
          </div>

          <div class="flex justify-between text-sm text-gray-300">
            <span>Payment method</span><span>QRIS</span>
          </div>
          <div class="flex justify-between text-sm text-gray-300">
            <span>Discount</span><span>0</span>
          </div>
          <div class="flex justify-between text-sm text-gray-300">
            <span>Convenience fee</span><span>Rp. 15.000,00</span>
          </div>
          <div class="flex justify-between text-lg font-bold">
            <span>Total</span
            ><span class="text-orange-400">Rp. 113.000,00</span>
          </div>
        </div>

        <div class="flex justify-between space-x-4">
          <button
            onclick="closeModal()"
            class="w-full py-2 bg-white text-[#1e293b] font-bold rounded-lg"
          >
            Close
          </button>
          <button
            class="w-full py-2 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg"
          >
            Download
          </button>
        </div>
      </div>
    </div>

    <script>
      document
        .getElementById("buyNowBtn")
        .addEventListener("click", function () {
          document.getElementById("successModal").classList.remove("hidden");
        });

      function closeModal() {
        document.getElementById("successModal").classList.add("hidden");
      }
    </script>
  </body>
</html>
