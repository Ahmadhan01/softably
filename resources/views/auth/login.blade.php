<x-header-admin title="Login"/>

<body class="bg-[#0E1A2B] min-h-screen flex items-center justify-center font-sans">

    <div class="bg-[#111C2E] text-white rounded-xl shadow-lg w-full max-w-4xl p-8 flex flex-col md:flex-row gap-6">

        <!-- Gambar -->
        <div class="md:w-1/2 w-full p-4 flex items-center justify-center">
            <img src="{{ asset('img/softably-baru.png') }}" alt="Login Illustration"
                class="max-h-60 w-auto object-contain" />
        </div>

        <!-- Form login -->
        <div class="md:w-1/2 p-4 flex flex-col justify-center">

            <h2 class="text-2xl font-bold mb-6">Login</h2>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <input type="email" name="login" placeholder="Email" value="{{ old('email') }}" required autofocus
                    class="w-full mb-4 px-4 py-2 rounded border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('login')
                    <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                @enderror

                <!-- Password -->
                <input type="password" name="password" placeholder="Password" required
                    class="w-full mb-4 px-4 py-2 rounded border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('password')
                    <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                @enderror

                <!-- Remember me -->
                <label class="inline-flex items-center mb-4">
                    <input type="checkbox" name="remember"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                    <span class="ms-2 text-sm text-gray-300">Remember me</span>
                </label>

                <!-- Login button -->
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded mb-4">
                    LOGIN
                </button>

                <!-- Forgot password -->
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="block text-sm text-center text-gray-400 hover:text-white">
                        Forgot your password?
                    </a>
                @endif
            </form>

            <!-- Other login options -->
            <p class="text-center text-sm text-gray-400 my-4">Or login with</p>

            <div class="flex justify-center gap-4 mb-6">
                <button class="flex items-center gap-2 px-4 py-2 bg-white text-blue-700 border border-gray-300 rounded">
                    <img src="{{ asset('img/facebook-new.png') }}" alt="Facebook" class="w-5 h-5" />
                    Facebook
                </button>
                <button class="flex items-center gap-2 px-4 py-2 bg-white text-red-600 border border-gray-300 rounded">
                    <img src="{{ asset('img/google-logo.png') }}" alt="Google" class="w-5 h-5" />
                    Google
                </button>
            </div>

            <p class="text-center text-sm text-gray-400">
                Not have account?
                <a href="{{ route('register') }}" class="text-red-500 hover:underline">Sign up now</a>
            </p>

        </div>
    </div>

</body>

</html>
