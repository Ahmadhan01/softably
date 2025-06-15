<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0E1A2B] min-h-screen flex items-center justify-center font-sans">

    <div
        class="bg-[#111C2E] text-white rounded-xl shadow-lg w-full max-w-4xl p-8 flex">

         <div class="md:w-1/2 relative h-64 md:h-auto overflow-hidden rounded-lg">
            <img src="img/lennon.jpg" alt="Register Illustration"
                class="absolute inset-0 w-full h-full object-cover" />
        </div>

        <!-- Form login -->
        <div class="md:w-1/2 p-8 flex flex-col justify-center">
            <h2 class="text-2xl font-bold mb-6">Login</h2>

            <input type="text" placeholder="Email or Username"
                class="w-full mb-4 px-4 py-2 rounded border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-blue-500" />

            <input type="password" placeholder="Password"
                class="w-full mb-6 px-4 py-2 rounded border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-blue-500" />

            <a href="/dashboard-admin"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded text-center mb-6 block">
                LOGIN
            </a>

            <p class="text-center text-sm text-gray-400 mb-3">Or login with</p>

            <div class="flex justify-center gap-4 mb-6">
                <button class="flex items-center gap-2 px-4 py-2 bg-white text-blue-700 border border-gray-300 rounded">
                    <img src="img/facebook-new.png" alt="Facebook" class="w-5 h-5" />
                    Facebook
                </button>
                <button class="flex items-center gap-2 px-4 py-2 bg-white text-red-600 border border-gray-300 rounded">
                    <img src="img/google-logo.png" alt="Google" class="w-5 h-5" />
                    Google
                </button>
            </div>

            <p class="text-center text-sm text-gray-400">
                Not have account?
                <a href="/register-admin" class="text-red-500 hover:underline">Sign up now</a>
            </p>
        </div>
    </div>

</body>

</html>