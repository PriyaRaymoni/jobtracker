<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Job Tracker - Manage Your Applications</title> {{-- Updated Title --}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" /> {{-- Added font
    weight 700 --}}

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Removed inline styles as Vite should handle them --}}
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 font-sans antialiased">
    <div class="relative min-h-screen flex flex-col">
        <header class="absolute top-0 right-0 p-6 text-right z-10 w-full">
            @if (Route::has('login'))
                <nav class="flex justify-end gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="rounded-md px-4 py-2 text-gray-700 dark:text-gray-300 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="rounded-md px-4 py-2 text-gray-700 dark:text-gray-300 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="rounded-md px-4 py-2 text-gray-700 dark:text-gray-300 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main class="flex-grow flex items-center justify-center px-6 lg:px-8">
            <div class="max-w-4xl w-full text-center py-20">
                {{-- Hero Section --}}
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                    Track Your Job Applications <span class="text-indigo-600 dark:text-indigo-400">Effortlessly</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 mb-10 max-w-2xl mx-auto">
                    Stay organized and manage your job search process with our intuitive job tracking application. Never
                    miss an opportunity again.
                </p>
                <div class="flex justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-md transition duration-300 ease-in-out text-lg">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-md transition duration-300 ease-in-out text-lg">
                            Get Started Free
                        </a>
                        <a href="{{ route('login') }}"
                            class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white font-semibold py-3 px-8 rounded-md transition duration-300 ease-in-out text-lg">
                            Log In
                        </a>
                    @endauth
                </div>
            </div>
        </main>

        {{-- Features Section (Optional - Add more details if needed) --}}
        <section class="bg-white dark:bg-gray-800 py-16">
            <div class="max-w-6xl mx-auto px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Key Features</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <svg class="w-12 h-12 mx-auto mb-4 text-indigo-600 dark:text-indigo-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Centralized Tracking</h3>
                        <p class="text-gray-600 dark:text-gray-400">Keep all your job application details, notes, and
                            statuses in one organized place.</p>
                    </div>
                    <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <svg class="w-12 h-12 mx-auto mb-4 text-indigo-600 dark:text-indigo-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Status Updates</h3>
                        <p class="text-gray-600 dark:text-gray-400">Easily update and monitor the status of each
                            application throughout the hiring process.</p>
                    </div>
                    <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <svg class="w-12 h-12 mx-auto mb-4 text-indigo-600 dark:text-indigo-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Simple Interface</h3>
                        <p class="text-gray-600 dark:text-gray-400">A clean, intuitive design makes managing your job
                            search a breeze.</p>
                    </div>
                </div>
            </div>
        </section>

        <footer class="py-6 text-center text-sm text-gray-500 dark:text-gray-400">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}) &copy; {{ date('Y') }}
            Job Tracker
        </footer>
    </div>
</body>

</html>