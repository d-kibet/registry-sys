<div class="p-4 max-w-2xl mx-auto space-y-4">

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">All Agents</h1>
        <p class="text-gray-600 dark:text-gray-400">Total: {{ $agents->total() }} agents</p>
    </div>

    <!-- Success Message -->
    @if(session()->has('success'))
        <div class="mb-4 p-4 bg-green-500 dark:bg-green-600 text-white rounded-xl shadow-lg dark:shadow-gray-900/50">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Search and Filter -->
    <div class="space-y-3">
        <!-- Search Bar -->
        <div class="relative">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search agents by name, email, or phone..."
                class="w-full px-4 py-4 pl-12 pr-12 text-lg bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-xl focus:border-uda-yellow-500 dark:focus:border-uda-yellow-400 focus:ring-2 focus:ring-uda-yellow-200 dark:focus:ring-uda-yellow-500/30 transition placeholder:text-gray-400 dark:placeholder:text-gray-500"
            >
            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            @if($search)
                <button wire:click="clearSearch" class="absolute right-4 top-1/2 transform -translate-y-1/2 p-1 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-full transition">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            @endif
        </div>

        <!-- Company Filter -->
        <div class="relative">
            <select
                wire:model.live="companyFilter"
                class="w-full px-4 py-4 pl-12 text-lg bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-xl focus:border-uda-yellow-500 dark:focus:border-uda-yellow-400 focus:ring-2 focus:ring-uda-yellow-200 dark:focus:ring-uda-yellow-500/30 transition appearance-none"
            >
                <option value="">All Companies</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            @if($companyFilter)
                <button wire:click="clearCompanyFilter" class="absolute right-4 top-1/2 transform -translate-y-1/2 p-1 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-full transition">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            @endif
        </div>
    </div>

    <!-- Results Info -->
    @if($search || $companyFilter)
        <div class="flex items-center justify-between text-sm">
            <p class="text-gray-600 dark:text-gray-400">
                Found {{ $agents->total() }} result{{ $agents->total() !== 1 ? 's' : '' }}
                @if($search) for "<span class="font-semibold">{{ $search }}</span>" @endif
                @if($companyFilter) in selected company @endif
            </p>
        </div>
    @endif

    <!-- Agents List -->
    @if($agents->count() > 0)
        <div class="space-y-3">
            @foreach($agents as $agent)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/50 p-5 border-l-4 {{ $agent->is_active ? 'border-uda-green-500 dark:border-uda-green-400' : 'border-gray-400 dark:border-gray-600' }} transition-colors duration-200">
                    <!-- Agent Header -->
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">{{ $agent->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">ID: #{{ $agent->id }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($agent->is_active)
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">Active</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">Inactive</span>
                            @endif
                        </div>
                    </div>

                    <!-- Company Badge -->
                    @if($agent->company)
                        <div class="mb-3 inline-block px-3 py-1 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span class="text-sm font-semibold text-blue-800 dark:text-blue-400">{{ $agent->company->name }}</span>
                            </div>
                        </div>
                    @else
                        <div class="mb-3 inline-block px-3 py-1 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg">
                            <span class="text-sm font-semibold text-red-800 dark:text-red-400">No Company Assigned</span>
                        </div>
                    @endif

                    <!-- Agent Details -->
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $agent->email }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $agent->phone }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm text-gray-700 dark:text-gray-300">Joined: {{ $agent->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg mb-4">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $agent->registered_members_count }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Members Registered</p>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div>
                        <button
                            wire:click="toggleStatus({{ $agent->id }})"
                            wire:confirm="Are you sure you want to {{ $agent->is_active ? 'deactivate' : 'activate' }} this agent?"
                            class="w-full py-3 {{ $agent->is_active ? 'bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700' : 'bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700' }} text-white font-semibold rounded-lg transition"
                        >
                            {{ $agent->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $agents->links() }}
        </div>

    @else
        <!-- Empty State -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/50 p-12 text-center transition-colors duration-200">
            <svg class="w-20 h-20 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>

            @if($search || $companyFilter)
                <p class="text-gray-600 dark:text-gray-300 font-medium text-lg mb-2">No agents found</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Try adjusting your search or filters</p>
                <div class="flex gap-3 justify-center">
                    @if($search)
                        <button wire:click="clearSearch" class="px-6 py-3 bg-uda-green-500 hover:bg-uda-green-600 dark:bg-uda-green-600 dark:hover:bg-uda-green-700 text-white font-semibold rounded-lg transition">
                            Clear Search
                        </button>
                    @endif
                    @if($companyFilter)
                        <button wire:click="clearCompanyFilter" class="px-6 py-3 bg-uda-green-500 hover:bg-uda-green-600 dark:bg-uda-green-600 dark:hover:bg-uda-green-700 text-white font-semibold rounded-lg transition">
                            Clear Filter
                        </button>
                    @endif
                </div>
            @else
                <p class="text-gray-600 dark:text-gray-300 font-medium text-lg mb-2">No agents yet</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Agents will appear here once companies create them</p>
            @endif
        </div>
    @endif

    <!-- Loading Indicator -->
    <div wire:loading class="fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-gray-800 dark:bg-gray-700 text-white px-6 py-3 rounded-full shadow-lg dark:shadow-gray-900/50">
        <div class="flex items-center space-x-3">
            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Loading...</span>
        </div>
    </div>

</div>
