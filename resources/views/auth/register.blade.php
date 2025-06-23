<x-header-admin title="Register" />

<body class="bg-[#0E1A2B] min-h-screen flex items-center justify-center font-sans">

    <div class="bg-[#111C2E] text-white rounded-xl shadow-lg w-full max-w-4xl p-8 flex flex-col md:flex-row gap-6">

        <!-- Gambar -->
        <div class="md:w-1/2 w-full p-4 flex items-center justify-center">
            <img src="{{ asset('img/softably-baru.png') }}" alt="Register Illustration"
                class="max-h-60 w-auto object-contain" />
        </div>

        <!-- Form -->
        <div class="md:w-1/2 w-full flex flex-col justify-center px-4">
            <h2 class="text-2xl font-semibold mb-1">Create an account</h2>
            <p class="text-sm text-gray-400 mb-4">
                Already have an account?
                <a href="{{ route('login') }}" class="text-white hover:underline">Log in</a>
            </p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required
                    class="w-full mb-3 px-4 py-2 rounded border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('name')
                    <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                @enderror

                <!-- Username -->
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Username" required
                    class="w-full mb-3 px-4 py-2 rounded border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('username')
                    <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                @enderror

                <!-- Email -->
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required
                    class="w-full mb-3 px-4 py-2 rounded border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('email')
                    <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                @enderror

                <!-- Password -->
                <input type="password" name="password" placeholder="Password" required
                    class="w-full mb-3 px-4 py-2 rounded border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('password')
                    <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                @enderror

                <!-- Confirm Password -->
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required
                    class="w-full mb-3 px-4 py-2 rounded border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('password_confirmation')
                    <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                @enderror

                <!-- Role -->
                <select name="role" required
                    class="w-full mb-4 px-4 py-2 rounded border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="seller" {{ old('role') == 'seller' ? 'selected' : '' }}>Seller</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                @enderror

                <!-- Terms -->
                <label class="flex items-center text-sm text-gray-300 mb-4">
                    <input type="checkbox" name="terms" class="mr-2 accent-blue-600">
                    I agree to the <a href="#" class="underline ml-1">Terms & Conditions</a>
                </label>

                <!-- Submit -->
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded mb-4 w-full text-center">
                    Create Account
                </button>
            </form>

            <!-- Divider -->
            <p class="text-center text-sm text-gray-400 mb-2">Or register with</p>

            <!-- Social Buttons -->
            <div class="flex justify-center gap-4 mb-4">
                <button class="flex items-center gap-2 px-4 py-2 bg-white text-blue-700 border border-gray-300 rounded">
                    <img src="{{ asset('img/facebook-new.png') }}" alt="fb" class="w-4 h-4" />
                    Facebook
                </button>
                <button class="flex items-center gap-2 px-4 py-2 bg-white text-red-600 border border-gray-300 rounded">
                    <img src="{{ asset('img/google-logo.png') }}" alt="google" class="w-4 h-4" />
                    Google
                </button>
            </div>

            <!-- Login redirect -->
            <p class="text-sm text-center text-gray-400">
                Have an account?
                <a href="{{ route('login') }}" class="text-red-500 hover:underline">Sign in now</a>
            </p>
        </div>
    </div>

</body>

</html>
