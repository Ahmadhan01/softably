<x-header-admin title="Login"/>

<body class="bg-[#0E1A2B] min-h-screen flex items-center justify-center font-sans">

    <div class="bg-[#111C2E] text-white rounded-xl shadow-lg w-full max-w-4xl p-8 flex flex-col md:flex-row gap-6">

        <div class="md:w-1/2 w-full p-4 flex items-center justify-center">
            <img src="{{ asset('img/softably-baru.png') }}" alt="Login Illustration"
                class="max-h-60 w-auto object-contain" />
        </div>

        <div class="md:w-1/2 p-4 flex flex-col justify-center">

            <h2 class="text-2xl font-bold mb-6">Login</h2>

            @if (session('status'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Tambahkan ID pada form --}}
            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf

                <input type="text" name="login" placeholder="Email or Username" value="{{ old('login') }}" required autofocus
                    class="w-full mb-4 px-4 py-2 rounded border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('login')
                    <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                @enderror

                <input type="password" name="password" placeholder="Password" required
                    class="w-full mb-4 px-4 py-2 rounded border border-gray-300 text-black focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('password')
                    <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                @enderror

                <label class="inline-flex items-center mb-4">
                    <input type="checkbox" name="remember"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                    <span class="ms-2 text-sm text-gray-300">Remember me</span>
                </label>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded mb-4">
                    LOGIN
                </button>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="block text-sm text-center text-gray-400 hover:text-white">
                        Forgot your password?
                    </a>
                @endif
            </form>

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

    {{-- Tambahkan script Axios jika belum ada di header atau layout utama --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        // Fungsi showToast sederhana (jika tidak ada dari app.js atau tempat lain)
        function showToast(message, type = 'info') {
            const toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                const div = document.createElement('div');
                div.id = 'toast-container';
                div.style.position = 'fixed';
                div.style.top = '20px';
                div.style.right = '20px';
                div.style.zIndex = '9999';
                document.body.appendChild(div);
            }

            const toast = document.createElement('div');
            toast.className = `p-3 rounded-md shadow-md text-white mb-3 flex items-center gap-2`;
            if (type === 'success') {
                toast.classList.add('bg-green-500');
                toast.innerHTML = `<i class="fas fa-check-circle"></i> <span>${message}</span>`;
            } else if (type === 'error') {
                toast.classList.add('bg-red-500');
                toast.innerHTML = `<i class="fas fa-times-circle"></i> <span>${message}</span>`;
            } else {
                toast.classList.add('bg-blue-500');
                toast.innerHTML = `<i class="fas fa-info-circle"></i> <span>${message}</span>`;
            }

            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.5s ease-in-out';
            requestAnimationFrame(() => {
                toast.style.opacity = '1';
            });

            document.getElementById('toast-container').prepend(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.addEventListener('transitionend', () => toast.remove());
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', function () {
            const loginForm = document.getElementById('loginForm');

            if (loginForm) {
                // Set CSRF token untuk Axios (penting untuk setiap permintaan POST/PUT/DELETE)
                axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                axios.defaults.withCredentials = true; // Penting untuk mengirim cookie

                loginForm.addEventListener('submit', function (e) {
                    e.preventDefault(); // Mencegah submit form default browser

                    const formData = new FormData(this); // Ambil data dari form

                    axios.post(this.action, formData, {
                        headers: {
                            'Accept': 'application/json', // Memberitahu server kita ingin respons JSON
                        }
                    })
                    .then(response => {
                        // Jika login berhasil (status 200 OK)
                        if (response.status === 200) {
                            const data = response.data;
                            showToast(data.message || 'Login berhasil!', 'success');
                            if (data.redirect_url) {
                                window.location.href = data.redirect_url; // Lakukan redirect via JS
                            } else {
                                // Fallback jika tidak ada redirect_url (misal hanya 204 No Content dari backend)
                                window.location.href = '/dashboard'; // Redirect ke dashboard default
                            }
                        }
                    })
                    .catch(error => {
                        // Tangani error (misal, menampilkan pesan error dari backend)
                        console.error("Login Error:", error.response);
                        let errorMessage = 'Terjadi kesalahan saat login.';
                        if (error.response && error.response.data) {
                            if (error.response.data.errors) {
                                // Error validasi Laravel
                                const errors = error.response.data.errors;
                                errorMessage = '';
                                for (const key in errors) {
                                    errorMessage += errors[key].join(', ') + '\n';
                                }
                            } else if (error.response.data.message) {
                                // Pesan error umum dari backend (misal 'Email atau password salah.')
                                errorMessage = error.response.data.message;
                            }
                        }
                        showToast(errorMessage, 'error');
                    });
                });
            }
        });
    </script>

</body>

</html>