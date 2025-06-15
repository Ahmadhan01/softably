<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0E1A2B] min-h-screen flex items-center justify-center font-sans">

    <div class="bg-[#111C2E] text-white rounded-xl shadow-lg w-full max-w-4xl p-8 flex">

        <!-- Gambar -->
        <div class="md:w-1/2 relative h-64 md:h-auto overflow-hidden rounded-lg">
            <img src="img/lennon.jpg" alt="Register Illustration"
                class="absolute inset-0 w-full h-full object-cover" />
        </div>

        <!-- Form -->
        <div class="w-1/2 flex flex-col justify-center px-4">
            <h2 class="text-2xl font-semibold mb-1">Create an account</h2>
            <p class="text-sm text-gray-400 mb-4">
                Already have an account?
                <a href="/login-admin" class="text-white hover:underline">Log in</a>
            </p>

            <input type="text" placeholder="Username"
                class="w-full mb-3 px-4 py-2 rounded border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-blue-500" />

            <input type="email" placeholder="Email"
                class="w-full mb-3 px-4 py-2 rounded border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-blue-500" />

            <input type="password" placeholder="Password"
                class="w-full mb-3 px-4 py-2 rounded border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-blue-500" />

            <label class="flex items-center text-sm text-gray-300 mb-4">
                <input type="checkbox" class="mr-2 accent-blue-600">
                I agree to the <a href="#" class="underline ml-1">Terms & Conditions</a>
            </label>

            <a class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded mb-4 w-full text-center"
                href="/login-admin">
                Create account
            </a>

            <p class="text-center text-sm text-gray-400 mb-2">Or register with</p>

            <div class="flex justify-center gap-4 mb-4">
                <button class="flex items-center gap-2 px-4 py-2 bg-white text-blue-700 border border-gray-300 rounded">
                    <img src="img/facebook-new.png" alt="fb" class="w-4 h-4" />
                    Facebook
                </button>
                <button class="flex items-center gap-2 px-4 py-2 bg-white text-red-600 border border-gray-300 rounded">
                    <img src="img/google-logo.png" alt="google" class="w-4 h-4" />
                    Google
                </button>
            </div>

            <p class="text-sm text-center text-gray-400">
                Have an account?
                <a href="/login-admin" class="text-red-500 hover:underline">Sign in now</a>
            </p>
        </div>
    </div>

</body>

</html>
