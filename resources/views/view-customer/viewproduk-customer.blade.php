@extends('layouts.sidebar')

@section('isi')
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />

    <style>
      .scrollable::-webkit-scrollbar {
        width: 6px;
      }

      .scrollable::-webkit-scrollbar-thumb {
        background-color: #4b5563;
        border-radius: 3px;
      }
    </style>
  </head>

  <body class="bg-[#10172A] text-white font-sans">
    
    <main class="flex-1 px-6 py-8 ml-64 bg-[#10172A] min-h-screen">
      <div class="max-w-5xl mx-auto space-y-6">
        <a
          href="produk_customer.html"
          class="text-sm text-white hover:underline"
          ><i class="fa-solid fa-arrow-left"></i> View Product</a
        >

        <div class="bg-[#1C2438] p-6 rounded-xl shadow-md space-y-8">
          <!-- Top Section: Image & Info -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Product Image -->
            <div class="space-y-4">
              <div class="relative w-full aspect-square bg-white rounded-md">
                <div
                  class="overflow-hidden rounded-lg border-2 border-white mb-3"
                >
                  <img
                    src="img/download.jpeg"
                    alt="Template CapCut"
                    class="w-full object-cover"
                  />
                </div>
                <div
                  class="absolute top-3 right-3 w-8 h-8 bg-orange-400 text-white rounded-full flex items-center justify-center shadow-lg ring-2 ring-white"
                >
                  <i class="fa-solid fa-bookmark text-sm"></i>
                </div>
              </div>
              <div class="flex gap-2 justify-center">
                <div class="w-16 h-16 bg-white rounded-md">
                  <div
                    class="overflow-hidden rounded-lg border-2 border-white mb-3"
                  >
                    <img
                      src="img/download.jpeg"
                      alt="Template CapCut"
                      class="w-full object-cover"
                    />
                  </div>
                </div>
                <div class="w-16 h-16 bg-white rounded-md">
                  <div
                    class="overflow-hidden rounded-lg border-2 border-white mb-3"
                  >
                    <img
                      src="img/download.jpeg"
                      alt="Template CapCut"
                      class="w-full object-cover"
                    />
                  </div>
                </div>
                <div class="w-16 h-16 bg-white rounded-md">
                  <div
                    class="overflow-hidden rounded-lg border-2 border-white mb-3"
                  >
                    <img
                      src="img/download.jpeg"
                      alt="Template CapCut"
                      class="w-full object-cover"
                    />
                  </div>
                </div>
                <div class="w-16 h-16 bg-white rounded-md">
                  <div
                    class="overflow-hidden rounded-lg border-2 border-white mb-3"
                  >
                    <img
                      src="img/download.jpeg"
                      alt="Template CapCut"
                      class="w-full object-cover"
                    />
                  </div>
                </div>
                <div class="w-16 h-16 bg-white rounded-md">
                  <div
                    class="overflow-hidden rounded-lg border-2 border-white mb-3"
                  >
                    <img
                      src="img/download.jpeg"
                      alt="Template CapCut"
                      class="w-full object-cover"
                    />
                  </div>
                </div>
              </div>
            </div>

            <!-- Product Info -->
            <div class="flex flex-col justify-between">
              <div class="space-y-4">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gray-400 rounded-full">
                      <img src="img/man.jpg" alt="" class="rounded-full" />
                    </div>
                    <span class="font-semibold">Toko Ahmad</span>
                  </div>
                  <button
                    class="bg-gray-700 px-3 py-1 text-sm rounded-md hover:bg-gray-600"
                  >
                    View Store
                  </button>
                </div>

                <h2 class="text-2xl font-bold">Template Canva</h2>

                <div
                  class="text-sm text-gray-400 max-h-64 overflow-y-auto pr-2 scrollable"
                >
                  <p>
                    Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                    suspendisse lorem. Massa neque amet porta convallis nullam
                    nisl est. Amet risus fermentum sed tincidunt feugiat leo id
                    a ante lacus tincidunt. Lorem ipsum dolor sit amet,
                    consectetur adipisicing elit. Mollitia, atque officia!
                    Reprehenderit, corporis mollitia voluptatem assumenda
                    dolorem id? Aliquid magni, minus eveniet eaque dolores
                    deserunt sint. Odit at dolore aperiam. Lorem ipsum dolor sit
                    amet consectetur adipisicing elit. Ex id possimus et
                    corrupti vitae recusandae inventore asperiores incidunt
                    cumque soluta fugiat repellat ducimus molestiae nihil
                    doloribus obcaecati, porro repudiandae eum? Lorem ipsum
                    dolor sit amet consectetur. Pulvinar sed egestas suspendisse
                    lorem. Massa neque amet porta convallis nullam nisl est.
                    Amet risus fermentum sed tincidunt feugiat leo id a ante
                    lacus tincidunt. Lorem ipsum dolor sit amet, consectetur
                    adipisicing elit. Mollitia, atque officia! Reprehenderit,
                    corporis mollitia voluptatem assumenda dolorem id? Aliquid
                    magni, minus eveniet eaque dolores deserunt sint. Odit at
                    dolore aperiam. Lorem ipsum dolor sit amet consectetur
                    adipisicing elit. Ex id possimus et corrupti vitae
                    recusandae inventore asperiores incidunt cumque soluta
                    fugiat repellat ducimus molestiae nihil doloribus obcaecati,
                    porro repudiandae eum?
                  </p>
                </div>
                <br />
                <span class="text-2xl font-bold text-yellow-400"
                  >Rp. 59.999,00</span
                >
              </div>

              <div class="mt-6 flex items-center justify-end">
                <div class="flex gap-3">
                  <button
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-500"
                  >
                    Add to cart
                  </button>
                  <button
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-400"
                  >
                    Buy Now
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Comments -->
          <div class="space-y-6">
            <h3 class="text-lg font-semibold">Comments</h3>

            <div class="space-y-4">
              <!-- Example Comment -->
              <div class="flex gap-3">
                <div class="w-10 h-10 bg-gray-400 rounded-full">
                  <img src="img/man.jpg" alt="" class="rounded-full" />
                </div>
                <div class="bg-[#1F2A40] p-3 rounded-md flex-1">
                  <p class="font-semibold">Fajar Baisal</p>
                  <p class="text-sm text-gray-300">
                    Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                    suspendisse lorem...
                  </p>
                </div>
              </div>
              <!-- Duplicate as needed -->
            </div>
            <div class="space-y-4">
              <!-- Example Comment -->
              <div class="flex gap-3">
                <div class="w-10 h-10 bg-gray-400 rounded-full">
                  <img src="img/man.jpg" alt="" class="rounded-full" />
                </div>
                <div class="bg-[#1F2A40] p-3 rounded-md flex-1">
                  <p class="font-semibold">Fajar Baisal</p>
                  <p class="text-sm text-gray-300">
                    Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                    suspendisse lorem...
                  </p>
                </div>
              </div>
              <!-- Duplicate as needed -->
            </div>
            <div class="space-y-4">
              <!-- Example Comment -->
              <div class="flex gap-3">
                <div class="w-10 h-10 bg-gray-400 rounded-full">
                  <img src="img/man.jpg" alt="" class="rounded-full" />
                </div>
                <div class="bg-[#1F2A40] p-3 rounded-md flex-1">
                  <p class="font-semibold">Fajar Baisal</p>
                  <p class="text-sm text-gray-300">
                    Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                    suspendisse lorem...
                  </p>
                </div>
              </div>
              <!-- Duplicate as needed -->
            </div>
            <div class="space-y-4">
              <!-- Example Comment -->
              <div class="flex gap-3">
                <div class="w-10 h-10 bg-gray-400 rounded-full">
                  <img src="img/man.jpg" alt="" class="rounded-full" />
                </div>
                <div class="bg-[#1F2A40] p-3 rounded-md flex-1">
                  <p class="font-semibold">Fajar Baisal</p>
                  <p class="text-sm text-gray-300">
                    Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                    suspendisse lorem...
                  </p>
                </div>
              </div>
              <!-- Duplicate as needed -->
            </div>
            <div class="space-y-4">
              <!-- Example Comment -->
              <div class="flex gap-3">
                <div class="w-10 h-10 bg-gray-400 rounded-full">
                  <img src="img/man.jpg" alt="" class="rounded-full" />
                </div>
                <div class="bg-[#1F2A40] p-3 rounded-md flex-1">
                  <p class="font-semibold">Fajar Baisal</p>
                  <p class="text-sm text-gray-300">
                    Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                    suspendisse lorem...
                  </p>
                </div>
              </div>
              <!-- Duplicate as needed -->
            </div>
            <div class="space-y-4">
              <!-- Example Comment -->
              <div class="flex gap-3">
                <div class="w-10 h-10 bg-gray-400 rounded-full">
                  <img src="img/man.jpg" alt="" class="rounded-full" />
                </div>
                <div class="bg-[#1F2A40] p-3 rounded-md flex-1">
                  <p class="font-semibold">Fajar Baisal</p>
                  <p class="text-sm text-gray-300">
                    Lorem ipsum dolor sit amet consectetur. Pulvinar sed egestas
                    suspendisse lorem...
                  </p>
                </div>
              </div>
              <!-- Duplicate as needed -->
            </div>

            <!-- Comment Input -->
            <div class="flex items-center gap-2">
              <input
                type="text"
                placeholder="Write a comment..."
                class="flex-1 p-3 rounded-md bg-[#1F2A40] text-white border border-gray-600 focus:outline-none"
              />
              <button
                class="bg-green-500 px-4 py-2 rounded-md hover:bg-green-400"
              >
                <i class="fa-solid fa-paper-plane"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>
@endsection