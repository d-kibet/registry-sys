<!-- Desktop Navigation Tabs -->
<nav class="hidden lg:block bg-white dark:bg-gray-800 shadow-sm dark:shadow-gray-900/50 mb-6 rounded-xl overflow-hidden transition-colors duration-200">
    <div class="flex border-b border-gray-200 dark:border-gray-700">
        <a href="{{ route('super-admin.dashboard') }}"
           class="flex-1 flex items-center justify-center space-x-2 px-6 py-4 font-medium transition-colors {{ request()->routeIs('super-admin.dashboard') ? 'bg-uda-green-50 dark:bg-uda-green-900/30 text-uda-green-700 dark:text-uda-green-400 border-b-2 border-uda-green-500 dark:border-uda-green-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('super-admin.companies.index') }}"
           class="flex-1 flex items-center justify-center space-x-2 px-6 py-4 font-medium transition-colors {{ request()->routeIs('super-admin.companies.*') ? 'bg-uda-green-50 dark:bg-uda-green-900/30 text-uda-green-700 dark:text-uda-green-400 border-b-2 border-uda-green-500 dark:border-uda-green-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <span>Companies</span>
        </a>

        <a href="{{ route('super-admin.agents.index') }}"
           class="flex-1 flex items-center justify-center space-x-2 px-6 py-4 font-medium transition-colors {{ request()->routeIs('super-admin.agents.*') ? 'bg-uda-green-50 dark:bg-uda-green-900/30 text-uda-green-700 dark:text-uda-green-400 border-b-2 border-uda-green-500 dark:border-uda-green-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span>All Agents</span>
        </a>

        <a href="{{ route('super-admin.registrations.index') }}"
           class="flex-1 flex items-center justify-center space-x-2 px-6 py-4 font-medium transition-colors {{ request()->routeIs('super-admin.registrations.*') ? 'bg-uda-green-50 dark:bg-uda-green-900/30 text-uda-green-700 dark:text-uda-green-400 border-b-2 border-uda-green-500 dark:border-uda-green-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span>All Registrations</span>
        </a>
    </div>
</nav>
