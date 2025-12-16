<div class="p-4 space-y-4">

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

    <!-- Agents Table -->
    @if($agents->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Agent</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Company</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Members Registered</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($agents as $agent)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <!-- Agent Name & ID -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $agent->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">ID: #{{ $agent->id }}</div>
                                    </div>
                                </td>

                                <!-- Company -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($agent->company)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">
                                            {{ $agent->company->name }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400">
                                            Unassigned
                                        </span>
                                    @endif
                                </td>

                                <!-- Contact -->
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-3 h-3 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-xs text-gray-700 dark:text-gray-300">{{ $agent->email }}</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-3 h-3 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            <span class="text-xs text-gray-700 dark:text-gray-300">{{ $agent->phone }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Members Registered -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $agent->registered_members_count }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">members</div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($agent->is_active)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                            <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <!-- Action -->
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <button
                                        wire:click="toggleStatus({{ $agent->id }})"
                                        wire:confirm="Are you sure you want to {{ $agent->is_active ? 'deactivate' : 'activate' }} this agent?"
                                        class="inline-flex items-center px-3 py-2 {{ $agent->is_active ? 'bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700' : 'bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700' }} text-white font-semibold rounded-lg transition"
                                    >
                                        @if($agent->is_active)
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                            Deactivate
                                        @else
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Activate
                                        @endif
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
