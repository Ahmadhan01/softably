@extends('layouts.sidebar')

@section('isi')
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
@endsection