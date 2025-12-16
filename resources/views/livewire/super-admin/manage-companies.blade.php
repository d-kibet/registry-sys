<div class="p-4 space-y-4">

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

    <!-- Companies Table -->
    @if($companies->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Company</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Constituencies</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Stats</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($companies as $company)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <!-- Company Name & ID -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $company->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">ID: #{{ $company->id }}</div>
                                    </div>
                                </td>

                                <!-- Phone -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $company->phone }}</span>
                                    </div>
                                </td>

                                <!-- Constituencies -->
                                <td class="px-6 py-4">
                                    @if($company->constituencies->count() > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">
                                            {{ $company->constituencies->count() }} assigned
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400">
                                            None
                                        </span>
                                    @endif
                                </td>

                                <!-- Stats -->
                                <td class="px-6 py-4">
                                    <div class="flex space-x-4 text-sm">
                                        <div class="text-center">
                                            <div class="font-bold text-gray-900 dark:text-gray-100">{{ $company->agents->count() }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Agents</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="font-bold text-gray-900 dark:text-gray-100">{{ $company->users_count - $company->agents->count() }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Admins</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="font-bold text-gray-900 dark:text-gray-100">{{ $company->members_count }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Members</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($company->is_active)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                            <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                                            Suspended
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        <button
                                            wire:click="openAdminsModal({{ $company->id }})"
                                            class="inline-flex items-center px-3 py-2 bg-purple-500 hover:bg-purple-600 dark:bg-purple-600 dark:hover:bg-purple-700 text-white font-semibold rounded-lg transition"
                                        >
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            Admins
                                        </button>
                                        <button
                                            wire:click="openEditModal({{ $company->id }})"
                                            class="inline-flex items-center px-3 py-2 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white font-semibold rounded-lg transition"
                                        >
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </button>
                                        <button
                                            wire:click="toggleStatus({{ $company->id }})"
                                            wire:confirm="Are you sure you want to {{ $company->is_active ? 'suspend' : 'activate' }} this company?"
                                            class="inline-flex items-center px-3 py-2 {{ $company->is_active ? 'bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700' : 'bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700' }} text-white font-semibold rounded-lg transition"
                                        >
                                            @if($company->is_active)
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                </svg>
                                                Suspend
                                            @else
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Activate
                                            @endif
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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

                    <!-- Admin ID Number -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">ID Number <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            wire:model="admin_id_number"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-green-500 focus:ring-2 focus:ring-uda-green-200 transition text-gray-900 @error('admin_id_number') border-red-500 bg-red-50 @enderror"
                            placeholder="Enter ID number"
                        >
                        @error('admin_id_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Admin First Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">First Name <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            wire:model="admin_first_name"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-green-500 focus:ring-2 focus:ring-uda-green-200 transition text-gray-900 @error('admin_first_name') border-red-500 bg-red-50 @enderror"
                            placeholder="Enter first name"
                        >
                        @error('admin_first_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Admin Second Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Second Name</label>
                        <input
                            type="text"
                            wire:model="admin_second_name"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-green-500 focus:ring-2 focus:ring-uda-green-200 transition text-gray-900 @error('admin_second_name') border-red-500 bg-red-50 @enderror"
                            placeholder="Enter second name (optional)"
                        >
                        @error('admin_second_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Admin Last Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Last Name <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            wire:model="admin_last_name"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-green-500 focus:ring-2 focus:ring-uda-green-200 transition text-gray-900 @error('admin_last_name') border-red-500 bg-red-50 @enderror"
                            placeholder="Enter last name"
                        >
                        @error('admin_last_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Admin Phone -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number <span class="text-red-500">*</span></label>
                        <input
                            type="tel"
                            wire:model="admin_phone"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-green-500 focus:ring-2 focus:ring-uda-green-200 transition text-gray-900 @error('admin_phone') border-red-500 bg-red-50 @enderror"
                            placeholder="0712345678"
                        >
                        @error('admin_phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Admin PIN -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">PIN <span class="text-red-500">*</span></label>
                        <input
                            type="password"
                            wire:model="admin_pin"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-green-500 focus:ring-2 focus:ring-uda-green-200 transition text-gray-900 @error('admin_pin') border-red-500 bg-red-50 @enderror"
                            placeholder="4-6 digit PIN"
                            maxlength="6"
                        >
                        @error('admin_pin') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Confirm PIN -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm PIN <span class="text-red-500">*</span></label>
                        <input
                            type="password"
                            wire:model="admin_pin_confirmation"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-300 rounded-lg focus:bg-white focus:border-uda-green-500 focus:ring-2 focus:ring-uda-green-200 transition text-gray-900"
                            placeholder="Re-enter PIN"
                            maxlength="6"
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

    <!-- Manage Admins Modal -->
    @if($showAdminsModal && $managingCompany)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-gradient-to-r from-purple-500 to-indigo-500 px-6 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-white">Manage Company Admins</h2>
                        <p class="text-purple-100 text-sm">{{ $managingCompany->name }}</p>
                    </div>
                    <button wire:click="closeAdminsModal" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6">
                    <!-- Current Admins List -->
                    <div class="mb-6">
                        <h3 class="font-bold text-gray-800 dark:text-gray-100 text-lg mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Current Admins ({{ count($companyAdmins) }})
                        </h3>

                        @if(count($companyAdmins) > 0)
                            <div class="bg-white dark:bg-gray-900 rounded-lg overflow-hidden border-2 border-gray-200 dark:border-gray-700">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Admin</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Contact</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Status</th>
                                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($companyAdmins as $admin)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                                <td class="px-4 py-3">
                                                    <div>
                                                        <div class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $admin->name }}</div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $admin->id_number }}</div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="text-sm text-gray-700 dark:text-gray-300">{{ $admin->phone }}</div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    @if($admin->is_active)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                                            Active
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                                            <span class="w-1.5 h-1.5 bg-gray-500 rounded-full mr-1.5"></span>
                                                            Suspended
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-right">
                                                    <button
                                                        wire:click="toggleAdminStatus({{ $admin->id }})"
                                                        wire:confirm="Are you sure you want to {{ $admin->is_active ? 'suspend' : 'activate' }} this admin?"
                                                        class="inline-flex items-center px-3 py-1.5 text-xs {{ $admin->is_active ? 'bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700' : 'bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700' }} text-white font-semibold rounded transition"
                                                    >
                                                        {{ $admin->is_active ? 'Suspend' : 'Activate' }}
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-8 text-center border-2 border-dashed border-gray-300 dark:border-gray-700">
                                <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p class="text-gray-600 dark:text-gray-400 font-medium">No admins yet</p>
                                <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Add the first admin using the form below</p>
                            </div>
                        @endif
                    </div>

                    <!-- Add New Admin Form -->
                    <div class="border-t-2 border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="font-bold text-gray-800 dark:text-gray-100 text-lg mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add New Admin
                        </h3>

                        <form wire:submit.prevent="addAdmin" class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <!-- ID Number -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">ID Number <span class="text-red-500">*</span></label>
                                    <input
                                        type="text"
                                        wire:model="admin_id_number"
                                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-purple-500 dark:focus:border-purple-400 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-500/30 transition text-gray-900 dark:text-gray-100 @error('admin_id_number') border-red-500 bg-red-50 dark:bg-red-900/20 @enderror"
                                        placeholder="Enter ID number"
                                    >
                                    @error('admin_id_number') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                                </div>

                                <!-- Phone Number -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Phone Number <span class="text-red-500">*</span></label>
                                    <input
                                        type="tel"
                                        wire:model="admin_phone"
                                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-purple-500 dark:focus:border-purple-400 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-500/30 transition text-gray-900 dark:text-gray-100 @error('admin_phone') border-red-500 bg-red-50 dark:bg-red-900/20 @enderror"
                                        placeholder="0712345678"
                                    >
                                    @error('admin_phone') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <!-- First Name -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">First Name <span class="text-red-500">*</span></label>
                                    <input
                                        type="text"
                                        wire:model="admin_first_name"
                                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-purple-500 dark:focus:border-purple-400 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-500/30 transition text-gray-900 dark:text-gray-100 @error('admin_first_name') border-red-500 bg-red-50 dark:bg-red-900/20 @enderror"
                                        placeholder="First name"
                                    >
                                    @error('admin_first_name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                                </div>

                                <!-- Second Name -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Second Name</label>
                                    <input
                                        type="text"
                                        wire:model="admin_second_name"
                                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-purple-500 dark:focus:border-purple-400 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-500/30 transition text-gray-900 dark:text-gray-100 @error('admin_second_name') border-red-500 bg-red-50 dark:bg-red-900/20 @enderror"
                                        placeholder="Second name"
                                    >
                                    @error('admin_second_name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                                </div>

                                <!-- Last Name -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Last Name <span class="text-red-500">*</span></label>
                                    <input
                                        type="text"
                                        wire:model="admin_last_name"
                                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-purple-500 dark:focus:border-purple-400 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-500/30 transition text-gray-900 dark:text-gray-100 @error('admin_last_name') border-red-500 bg-red-50 dark:bg-red-900/20 @enderror"
                                        placeholder="Last name"
                                    >
                                    @error('admin_last_name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- PIN -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">PIN <span class="text-red-500">*</span></label>
                                    <input
                                        type="password"
                                        wire:model="admin_pin"
                                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-purple-500 dark:focus:border-purple-400 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-500/30 transition text-gray-900 dark:text-gray-100 @error('admin_pin') border-red-500 bg-red-50 dark:bg-red-900/20 @enderror"
                                        placeholder="4-6 digit PIN"
                                        maxlength="6"
                                    >
                                    @error('admin_pin') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                                </div>

                                <!-- Confirm PIN -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Confirm PIN <span class="text-red-500">*</span></label>
                                    <input
                                        type="password"
                                        wire:model="admin_pin_confirmation"
                                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-purple-500 dark:focus:border-purple-400 focus:ring-2 focus:ring-purple-200 dark:focus:ring-purple-500/30 transition text-gray-900 dark:text-gray-100"
                                        placeholder="Re-enter PIN"
                                        maxlength="6"
                                    >
                                </div>
                            </div>

                            @error('add_admin') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror

                            <!-- Form Actions -->
                            <div class="flex gap-3 pt-4">
                                <button
                                    type="button"
                                    wire:click="closeAdminsModal"
                                    class="flex-1 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-lg transition"
                                >
                                    Close
                                </button>
                                <button
                                    type="submit"
                                    wire:loading.attr="disabled"
                                    class="flex-1 py-3 bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 disabled:opacity-50 text-white font-semibold rounded-lg transition"
                                >
                                    <span wire:loading.remove>Add Admin</span>
                                    <span wire:loading>Adding...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
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
