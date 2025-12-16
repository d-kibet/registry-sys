<div class="p-4 max-w-2xl mx-auto space-y-4">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">Manage Companies</h1>
            <p class="text-gray-600 dark:text-gray-400">Total: {{ $companies->total() }} companies</p>
        </div>
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

    <!-- Search Bar and Create Button -->
    <div class="flex gap-3 mb-4">
        <div class="relative flex-1">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search companies..."
                class="w-full px-4 py-4 pl-12 text-lg bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-xl focus:border-uda-yellow-500 dark:focus:border-uda-yellow-400 focus:ring-2 focus:ring-uda-yellow-200 dark:focus:ring-uda-yellow-500/30 transition placeholder:text-gray-400 dark:placeholder:text-gray-500"
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
    </div>

    <!-- Create Company Button -->
    <button
        wire:click="openCreateModal"
        class="w-full py-4 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 hover:from-uda-yellow-600 hover:to-uda-green-600 text-white font-bold text-lg rounded-xl shadow-lg active:scale-95 transition transform flex items-center justify-center space-x-2"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        <span>Create New Company</span>
    </button>

    <!-- Companies List -->
    @if($companies->count() > 0)
        <div class="space-y-3">
            @foreach($companies as $company)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/50 p-5 border-l-4 {{ $company->is_active ? 'border-uda-green-500 dark:border-uda-green-400' : 'border-gray-400 dark:border-gray-600' }} transition-colors duration-200">
                    <!-- Company Header -->
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">{{ $company->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">ID: #{{ $company->id }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($company->is_active)
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">Active</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">Suspended</span>
                            @endif
                        </div>
                    </div>

                    <!-- Company Details -->
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $company->email }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $company->phone }}</p>
                        </div>
                        @if($company->address)
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $company->address }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-3 mb-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $company->agents->count() }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Agents</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $company->users_count - $company->agents->count() }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Admins</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $company->members_count }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Members</p>
                        </div>
                    </div>

                    <!-- Assigned Constituencies -->
                    @if($company->constituencies->count() > 0)
                        <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <p class="text-xs font-semibold text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Assigned Constituencies ({{ $company->constituencies->count() }})
                            </p>
                            <div class="flex flex-wrap gap-1">
                                @foreach($company->constituencies as $constituency)
                                    <span class="inline-block px-2 py-1 text-xs bg-white border border-blue-300 text-blue-700 rounded">
                                        {{ $constituency->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="mb-4 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                            <p class="text-xs text-yellow-800">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                No constituencies assigned - agents cannot register members
                            </p>
                        </div>
                    @endif

                    <!-- Company Agents -->
                    @if($company->agents->count() > 0)
                        <div class="mb-4 p-3 bg-green-50 rounded-lg border border-green-200">
                            <p class="text-xs font-semibold text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Company Agents ({{ $company->agents->count() }})
                            </p>
                            <div class="space-y-2">
                                @foreach($company->agents as $agent)
                                    <div class="flex items-center justify-between p-2 bg-white rounded border border-green-300">
                                        <div class="flex items-center space-x-2 flex-1">
                                            <div class="w-8 h-8 bg-gradient-to-br from-uda-yellow-500 to-uda-green-500 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                                {{ substr($agent->name, 0, 1) }}
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-gray-800">{{ $agent->name }}</p>
                                                <p class="text-xs text-gray-600">{{ $agent->email }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <div class="text-right">
                                                <p class="text-sm font-bold text-gray-800">{{ $agent->registered_members_count }}</p>
                                                <p class="text-xs text-gray-600">Members</p>
                                            </div>
                                            @if($agent->is_active)
                                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                            @else
                                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inactive</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-600">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                No agents assigned to this company yet
                            </p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <button
                            wire:click="openEditModal({{ $company->id }})"
                            class="flex-1 py-3 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white font-semibold rounded-lg transition"
                        >
                            Edit
                        </button>
                        <button
                            wire:click="toggleStatus({{ $company->id }})"
                            wire:confirm="Are you sure you want to {{ $company->is_active ? 'suspend' : 'activate' }} this company?"
                            class="flex-1 py-3 {{ $company->is_active ? 'bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700' : 'bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700' }} text-white font-semibold rounded-lg transition"
                        >
                            {{ $company->is_active ? 'Suspend' : 'Activate' }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $companies->links() }}
        </div>

    @else
        <!-- Empty State -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/50 p-12 text-center transition-colors duration-200">
            <svg class="w-20 h-20 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>

            @if($search)
                <p class="text-gray-600 dark:text-gray-300 font-medium text-lg mb-2">No companies found</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Try searching with different keywords</p>
                <button wire:click="clearSearch" class="px-6 py-3 bg-uda-green-500 hover:bg-uda-green-600 dark:bg-uda-green-600 dark:hover:bg-uda-green-700 text-white font-semibold rounded-lg transition">
                    Clear Search
                </button>
            @else
                <p class="text-gray-600 dark:text-gray-300 font-medium text-lg mb-2">No companies yet</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Create your first company to start</p>
                <button wire:click="openCreateModal" class="px-6 py-3 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 dark:from-uda-yellow-600 dark:to-uda-green-600 hover:from-uda-yellow-600 hover:to-uda-green-600 dark:hover:from-uda-yellow-700 dark:hover:to-uda-green-700 text-white font-semibold rounded-lg transition">
                    Create Company
                </button>
            @endif
        </div>
    @endif

    <!-- Create Company Modal -->
    @if($showCreateModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-white">Create New Company</h2>
                    <button wire:click="closeCreateModal" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="createCompany" class="p-6 space-y-4">
                    <h3 class="font-bold text-gray-800 text-lg border-b pb-2">Company Information</h3>

                    <!-- Company Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Company Name <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            wire:model="name"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition text-gray-900 @error('name') border-red-500 bg-red-50 @enderror"
                            placeholder="Enter company name"
                        >
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Company Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Company Email <span class="text-red-500">*</span></label>
                        <input
                            type="email"
                            wire:model="email"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition text-gray-900 @error('email') border-red-500 bg-red-50 @enderror"
                            placeholder="company@example.com"
                        >
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Company Phone -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Company Phone <span class="text-red-500">*</span></label>
                        <input
                            type="tel"
                            wire:model="phone"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition text-gray-900 @error('phone') border-red-500 bg-red-50 @enderror"
                            placeholder="0712345678"
                        >
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Company Address -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Address</label>
                        <textarea
                            wire:model="address"
                            rows="2"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition text-gray-900 @error('address') border-red-500 bg-red-50 @enderror"
                            placeholder="Company address (optional)"
                        ></textarea>
                        @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <h3 class="font-bold text-gray-800 text-lg border-b pb-2 pt-4">Admin User</h3>

                    <!-- Admin Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Admin Name <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            wire:model="admin_name"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-green-500 focus:ring-2 focus:ring-uda-green-200 transition text-gray-900 @error('admin_name') border-red-500 bg-red-50 @enderror"
                            placeholder="Enter admin name"
                        >
                        @error('admin_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Admin Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Admin Email <span class="text-red-500">*</span></label>
                        <input
                            type="email"
                            wire:model="admin_email"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-green-500 focus:ring-2 focus:ring-uda-green-200 transition text-gray-900 @error('admin_email') border-red-500 bg-red-50 @enderror"
                            placeholder="admin@example.com"
                        >
                        @error('admin_email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Admin Phone -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Admin Phone <span class="text-red-500">*</span></label>
                        <input
                            type="tel"
                            wire:model="admin_phone"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-green-500 focus:ring-2 focus:ring-uda-green-200 transition text-gray-900 @error('admin_phone') border-red-500 bg-red-50 @enderror"
                            placeholder="0712345678"
                        >
                        @error('admin_phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Admin Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Admin Password <span class="text-red-500">*</span></label>
                        <input
                            type="password"
                            wire:model="admin_password"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-green-500 focus:ring-2 focus:ring-uda-green-200 transition text-gray-900 @error('admin_password') border-red-500 bg-red-50 @enderror"
                            placeholder="Minimum 8 characters"
                        >
                        @error('admin_password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password <span class="text-red-500">*</span></label>
                        <input
                            type="password"
                            wire:model="admin_password_confirmation"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-green-500 focus:ring-2 focus:ring-uda-green-200 transition text-gray-900"
                            placeholder="Re-enter password"
                        >
                    </div>

                    <h3 class="font-bold text-gray-800 text-lg border-b pb-2 pt-4">Assigned Constituencies</h3>

                    <!-- Constituencies Selection -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Select Constituencies</label>
                        <p class="text-xs text-gray-600 mb-3">Choose constituencies where this company's agents can register members</p>
                        <div class="max-h-64 overflow-y-auto bg-gray-50 border-2 border-gray-300 rounded-lg p-3 space-y-2">
                            @php
                                $groupedConstituencies = $constituencies->groupBy('county');
                            @endphp
                            @foreach($groupedConstituencies as $county => $countyConstituencies)
                                <div class="mb-3">
                                    <p class="font-bold text-gray-800 text-sm mb-2 px-2">{{ $county }}</p>
                                    @foreach($countyConstituencies as $constituency)
                                        <div class="flex items-center space-x-2 px-2 py-1 hover:bg-white rounded">
                                            <input
                                                type="checkbox"
                                                wire:model="selectedConstituencies"
                                                value="{{ $constituency->id }}"
                                                id="create_constituency_{{ $constituency->id }}"
                                                class="w-4 h-4 text-uda-green-600 rounded"
                                            >
                                            <label for="create_constituency_{{ $constituency->id }}" class="text-sm text-gray-700 cursor-pointer flex-1">
                                                {{ $constituency->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            Selected: <span class="font-semibold">{{ count($selectedConstituencies) }}</span> constituency(ies)
                        </p>
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center space-x-3">
                        <input
                            type="checkbox"
                            wire:model="is_active"
                            id="create_is_active"
                            class="w-5 h-5 text-uda-green-600 rounded"
                        >
                        <label for="create_is_active" class="text-sm font-medium text-gray-700">Company is active</label>
                    </div>

                    @error('create') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

                    <!-- Form Actions -->
                    <div class="flex gap-3 pt-4">
                        <button
                            type="button"
                            wire:click="closeCreateModal"
                            class="flex-1 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="flex-1 py-3 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 hover:from-uda-yellow-600 hover:to-uda-green-600 disabled:opacity-50 text-white font-semibold rounded-lg transition"
                        >
                            <span wire:loading.remove>Create Company</span>
                            <span wire:loading>Creating...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Edit Company Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-white">Edit Company</h2>
                    <button wire:click="closeEditModal" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="updateCompany" class="p-6 space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Company Name <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            wire:model="name"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition text-gray-900 @error('name') border-red-500 bg-red-50 @enderror"
                        >
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input
                            type="email"
                            wire:model="email"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition text-gray-900 @error('email') border-red-500 bg-red-50 @enderror"
                        >
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number <span class="text-red-500">*</span></label>
                        <input
                            type="tel"
                            wire:model="phone"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition text-gray-900 @error('phone') border-red-500 bg-red-50 @enderror"
                        >
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Address</label>
                        <textarea
                            wire:model="address"
                            rows="2"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition text-gray-900 @error('address') border-red-500 bg-red-50 @enderror"
                        ></textarea>
                        @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <h3 class="font-bold text-gray-800 text-lg border-b pb-2 pt-4">Assigned Constituencies</h3>

                    <!-- Constituencies Selection -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Select Constituencies</label>
                        <p class="text-xs text-gray-600 mb-3">Choose constituencies where this company's agents can register members</p>
                        <div class="max-h-64 overflow-y-auto bg-gray-50 border-2 border-gray-300 rounded-lg p-3 space-y-2">
                            @php
                                $groupedConstituencies = $constituencies->groupBy('county');
                            @endphp
                            @foreach($groupedConstituencies as $county => $countyConstituencies)
                                <div class="mb-3">
                                    <p class="font-bold text-gray-800 text-sm mb-2 px-2">{{ $county }}</p>
                                    @foreach($countyConstituencies as $constituency)
                                        <div class="flex items-center space-x-2 px-2 py-1 hover:bg-white rounded">
                                            <input
                                                type="checkbox"
                                                wire:model="selectedConstituencies"
                                                value="{{ $constituency->id }}"
                                                id="edit_constituency_{{ $constituency->id }}"
                                                class="w-4 h-4 text-uda-green-600 rounded"
                                            >
                                            <label for="edit_constituency_{{ $constituency->id }}" class="text-sm text-gray-700 cursor-pointer flex-1">
                                                {{ $constituency->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            Selected: <span class="font-semibold">{{ count($selectedConstituencies) }}</span> constituency(ies)
                        </p>
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center space-x-3">
                        <input
                            type="checkbox"
                            wire:model="is_active"
                            id="edit_is_active"
                            class="w-5 h-5 text-uda-green-600 rounded"
                        >
                        <label for="edit_is_active" class="text-sm font-medium text-gray-700">Company is active</label>
                    </div>

                    @error('update') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

                    <!-- Form Actions -->
                    <div class="flex gap-3 pt-4">
                        <button
                            type="button"
                            wire:click="closeEditModal"
                            class="flex-1 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="flex-1 py-3 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 hover:from-uda-yellow-600 hover:to-uda-green-600 disabled:opacity-50 text-white font-semibold rounded-lg transition"
                        >
                            <span wire:loading.remove>Update Company</span>
                            <span wire:loading>Updating...</span>
                        </button>
                    </div>
                </form>
            </div>
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
