<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#179847">
    <meta name="color-scheme" content="light dark">

    <title>{{ $title ?? config('app.name') }}</title>

    <!-- PWA Meta Tags -->
    <link rel="manifest" href="/manifest.json">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="UDA Registry">
    <link rel="apple-touch-icon" href="/icon-192x192.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/icon-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/icon-512x512.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen pb-20 lg:pb-0 transition-colors duration-200">
    <!-- Mobile Header -->
    <header class="bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 dark:from-uda-yellow-600 dark:to-uda-green-600 sticky top-0 z-50 shadow-lg dark:shadow-gray-900/50">
        <div class="px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo & Title (Clickable Home Button) -->
                <a href="@if(Auth::user()->isSuperAdmin()) {{ route('super-admin.dashboard') }} @elseif(Auth::user()->isCompanyAdmin()) {{ route('company-admin.dashboard') }} @elseif(Auth::user()->isAgent()) {{ route('agent.dashboard') }} @endif"
                   class="flex items-center space-x-3 active:opacity-70 transition">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow">
                        <svg class="w-6 h-6 text-uda-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="text-white">
                        <h1 class="font-bold text-lg leading-tight">UDA Registry</h1>
                        <p class="text-xs opacity-90">{{ Auth::user()->name }}</p>
                    </div>
                </a>

                <!-- Mobile Menu Button -->
                <button
                    onclick="toggleMobileMenu()"
                    class="lg:hidden p-2 rounded-lg bg-white/20 active:bg-white/30 transition"
                >
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Desktop User Menu -->
                <div class="hidden lg:flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <x-dark-mode-toggle />

                    <!-- Home Button -->
                    <a href="@if(Auth::user()->isSuperAdmin()) {{ route('super-admin.dashboard') }} @elseif(Auth::user()->isCompanyAdmin()) {{ route('company-admin.dashboard') }} @elseif(Auth::user()->isAgent()) {{ route('agent.dashboard') }} @endif"
                       class="flex items-center space-x-2 px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg text-sm font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Home</span>
                    </a>
                    <span class="text-white text-sm">{{ Auth::user()->email }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg text-sm font-medium transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Slide-out Menu -->
    <div id="mobileMenu" class="fixed inset-0 z-40 lg:hidden hidden">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/50 dark:bg-black/70" onclick="toggleMobileMenu()"></div>

        <!-- Menu Panel -->
        <div class="absolute right-0 top-0 bottom-0 w-72 bg-white dark:bg-gray-800 shadow-2xl transform transition-colors duration-200">
            <div class="p-6">
                <!-- User Info -->
                <div class="flex items-center space-x-3 pb-6 border-b dark:border-gray-700">
                    <div class="w-12 h-12 bg-gradient-to-br from-uda-yellow-500 to-uda-green-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 dark:text-gray-100">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ Auth::user()->email }}</p>
                        <p class="text-xs text-uda-green-600 dark:text-uda-green-400 font-medium mt-1">
                            @if(Auth::user()->isSuperAdmin()) Super Admin
                            @elseif(Auth::user()->isCompanyAdmin()) Company Admin
                            @elseif(Auth::user()->isAgent()) Agent
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="mt-6 space-y-2">
                    <!-- Dark Mode Toggle (Mobile) -->
                    <div class="flex items-center justify-between px-4 py-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Dark Mode</span>
                        </div>
                        <button
                            onclick="toggleDarkMode()"
                            class="relative inline-flex items-center h-6 rounded-full w-11 transition-colors bg-gray-300 dark:bg-uda-green-600"
                        >
                            <span class="inline-block w-4 h-4 transform transition-transform bg-white rounded-full translate-x-1 dark:translate-x-6"></span>
                        </button>
                    </div>

                    <!-- Home Link -->
                    <a href="@if(Auth::user()->isSuperAdmin()) {{ route('super-admin.dashboard') }} @elseif(Auth::user()->isCompanyAdmin()) {{ route('company-admin.dashboard') }} @elseif(Auth::user()->isAgent()) {{ route('agent.dashboard') }} @endif"
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-uda-green-50 dark:bg-uda-green-900/30 border-l-4 border-uda-green-500 dark:border-uda-green-400">
                        <svg class="w-5 h-5 text-uda-green-600 dark:text-uda-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="font-semibold text-uda-green-700 dark:text-uda-green-400">Go to Dashboard</span>
                    </a>

                    {{ $mobileMenu ?? '' }}
                </nav>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="mt-8">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white rounded-lg font-medium active:scale-95 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="lg:max-w-7xl lg:mx-auto lg:px-4 lg:py-6">
        {{ $slot }}
    </main>

    <!-- PWA Install Prompt -->
    <x-pwa-install-prompt />

    <!-- Mobile Bottom Navigation (for common actions) -->
    @if(isset($bottomNav))
        <nav class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 lg:hidden z-30 transition-colors duration-200">
            <div class="flex justify-around py-2">
                {{ $bottomNav }}
            </div>
        </nav>
    @endif

    @livewireScripts

    <!-- PWA Service Worker Registration -->
    <script>
        // Register service worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(registration => {
                        console.log('ServiceWorker registered:', registration);

                        // Check for updates periodically
                        setInterval(() => {
                            registration.update();
                        }, 60000); // Check every minute
                    })
                    .catch(error => {
                        console.log('ServiceWorker registration failed:', error);
                    });
            });

            // Handle service worker updates
            let refreshing = false;
            navigator.serviceWorker.addEventListener('controllerchange', () => {
                if (!refreshing) {
                    refreshing = true;
                    window.location.reload();
                }
            });
        }

        // Install prompt for PWA
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent the mini-infobar from appearing on mobile
            e.preventDefault();
            // Stash the event so it can be triggered later
            deferredPrompt = e;

            // You can show an install button here
            console.log('PWA install prompt available');
        });

        window.addEventListener('appinstalled', () => {
            console.log('PWA installed successfully');
            deferredPrompt = null;
        });
    </script>

    <!-- Mobile Menu Toggle Script -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Close menu when clicking outside
        document.addEventListener('DOMContentLoaded', function() {
            const menu = document.getElementById('mobileMenu');
            if (menu) {
                menu.addEventListener('click', function(e) {
                    if (e.target === this) {
                        toggleMobileMenu();
                    }
                });
            }
        });
    </script>

    <!-- Security: Blur content when app loses focus -->
    <style>
        .blur-security {
            filter: blur(10px);
            pointer-events: none;
            transition: filter 0.3s ease;
        }
    </style>

    <script>
        // Blur content when user switches away (security feature)
        document.addEventListener('visibilitychange', function() {
            const mainContent = document.querySelector('main');
            if (mainContent) {
                if (document.hidden) {
                    mainContent.classList.add('blur-security');
                } else {
                    mainContent.classList.remove('blur-security');
                }
            }
        });

        // Also blur when window loses focus (mobile app switching)
        window.addEventListener('blur', function() {
            const mainContent = document.querySelector('main');
            if (mainContent) {
                mainContent.classList.add('blur-security');
            }
        });

        window.addEventListener('focus', function() {
            const mainContent = document.querySelector('main');
            if (mainContent) {
                mainContent.classList.remove('blur-security');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
