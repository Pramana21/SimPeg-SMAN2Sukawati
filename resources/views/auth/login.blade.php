<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <div class="hidden w-1/2 items-center justify-center bg-blue-600 px-12 md:flex">
            <img src="{{ asset('images/VektorAwal.png') }}" alt="Ilustrasi login" class="w-3/4 max-w-lg">
        </div>

        <div class="flex w-full items-center justify-center bg-gray-100 px-6 py-12 md:w-1/2">
            <div class="w-full max-w-md">
                <h1 class="mb-7 text-center text-3xl font-bold text-gray-900">Selamat datang kembali!</h1>
                <h2 class="mb-4 text-xl font-semibold text-gray-900">Masuk</h2>

                @if (session('status'))
                    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-5">
                        <label for="username" class="mb-2 block text-sm font-medium text-gray-900">Username</label>
                        <input id="username"
                               type="text"
                               name="username"
                               value="{{ old('username') }}"
                               class="w-full rounded-lg border border-blue-100 bg-white px-4 py-3 text-gray-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                               required
                               autofocus
                               autocomplete="username">
                        @error('username')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-7">
                        <label for="password" class="mb-2 block text-sm font-medium text-gray-900">Kata sandi</label>
                        <div class="flex items-center rounded-lg border border-blue-100 bg-white px-4 py-3 transition focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500">
                            <input id="password"
                                   type="password"
                                   name="password"
                                   class="w-full bg-transparent text-gray-900 outline-none"
                                   required
                                   autocomplete="current-password">
                            <button type="button"
                                    onclick="togglePassword()"
                                    class="ml-2 text-gray-500 transition hover:text-blue-600"
                                    aria-label="Tampilkan atau sembunyikan kata sandi">
                                <svg id="passwordToggleIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.75 12s3.5-6.25 9.25-6.25S21.25 12 21.25 12 17.75 18.25 12 18.25 2.75 12 2.75 12Z" />
                                    <circle cx="12" cy="12" r="2.75" stroke-width="1.8" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full rounded-lg bg-blue-600 py-3 text-lg font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Masuk
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('passwordToggleIcon');

            if (!password || !icon) {
                return;
            }

            const isHidden = password.type === 'password';
            password.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 3.75l16.5 16.5M10.58 10.58a2 2 0 0 0 2.84 2.84M8.35 5.98A9.4 9.4 0 0 1 12 5.25c5.75 0 9.25 6.75 9.25 6.75a18 18 0 0 1-2.52 3.42M6.11 7.67A18.4 18.4 0 0 0 2.75 12s3.5 6.75 9.25 6.75a9.5 9.5 0 0 0 4.72-1.25" />'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.75 12s3.5-6.25 9.25-6.25S21.25 12 21.25 12 17.75 18.25 12 18.25 2.75 12 2.75 12Z" /><circle cx="12" cy="12" r="2.75" stroke-width="1.8" />';
        }
    </script>
</body>
</html>
