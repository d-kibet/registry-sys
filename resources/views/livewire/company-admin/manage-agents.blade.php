<div class="p-4 max-w-7xl mx-auto space-y-4 relative">

    <!-- Security Watermark -->
    <div class="fixed inset-0 pointer-events-none z-10 flex items-center justify-center" style="opacity: 0.08;">
        <div class="transform -rotate-45 text-center">
            <p class="text-6xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ Auth::user()->name }}</p>
            <p class="text-4xl font-semibold text-gray-700 dark:text-gray-300">ID: {{ Auth::user()->id_number }}</p>
            <p class="text-3xl text-gray-600 dark:text-gray-400 mt-2">{{ Auth::user()->phone }}</p>
        </div>
    </div>

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">Manage Agents</h1>
            <p class="text-gray-600 dark:text-gray-400">Total: {{ $agents->total() }} agents</p>
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
                placeholder="Search agents..."
                class="w-full px-4 py-4 pl-12 text-lg border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-xl focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition"
            >
            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            @if($search)
                <button wire:click="clearSearch" class="absolute right-4 top-1/2 transform -translate-y-1/2 p-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            @endif
        </div>
    </div>

    <!-- Create Agent Button -->
    <button
        wire:click="openCreateModal"
        class="w-full py-4 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 hover:from-uda-yellow-600 hover:to-uda-green-600 text-white font-bold text-lg rounded-xl shadow-lg dark:shadow-gray-900/50 active:scale-95 transition transform flex items-center justify-center space-x-2"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        <span>Create New Agent</span>
    </button>

    <!-- Agents Table -->
    @if($agents->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/50 overflow-hidden">
            <!-- Table Container with Horizontal Scroll -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead class="bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 text-white">
                        <tr>
                            <th class="px-4 py-4 text-left text-sm font-bold uppercase tracking-wider">#</th>
                            <th class="px-4 py-4 text-left text-sm font-bold uppercase tracking-wider">Full Name</th>
                            <th class="px-4 py-4 text-left text-sm font-bold uppercase tracking-wider">ID Number</th>
                            <th class="px-4 py-4 text-left text-sm font-bold uppercase tracking-wider">Phone</th>
                            <th class="px-4 py-4 text-left text-sm font-bold uppercase tracking-wider">Registrations</th>
                            <th class="px-4 py-4 text-left text-sm font-bold uppercase tracking-wider">Status</th>
                            <th class="px-4 py-4 text-center text-sm font-bold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($agents as $index => $agent)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                <!-- Row Number -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                        {{ $agents->firstItem() + $index }}
                                    </span>
                                </td>

                                <!-- Full Name -->
                                <td class="px-4 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $agent->name }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            Agent #{{ $agent->id }}
                                        </span>
                                    </div>
                                </td>

                                <!-- ID Number -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-700 dark:text-gray-300 font-mono">
                                        {{ $agent->id_number }}
                                    </span>
                                </td>

                                <!-- Phone Number -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-700 dark:text-gray-300 font-mono">
                                        {{ $agent->phone }}
                                    </span>
                                </td>

                                <!-- Registrations Count -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $agent->registered_members_count }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if($agent->is_active)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                            Suspended
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button
                                            wire:click="openEditModal({{ $agent->id }})"
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-colors duration-150"
                                            title="Edit Agent"
                                        >
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </button>
                                        <button
                                            wire:click="toggleStatus({{ $agent->id }})"
                                            wire:confirm="Are you sure you want to {{ $agent->is_active ? 'suspend' : 'activate' }} this agent?"
                                            class="inline-flex items-center px-3 py-1.5 {{ $agent->is_active ? 'bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700' : 'bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700' }} text-white text-xs font-medium rounded-lg transition-colors duration-150"
                                            title="{{ $agent->is_active ? 'Suspend' : 'Activate' }} Agent"
                                        >
                                            @if($agent->is_active)
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
            {{ $agents->links() }}
        </div>

    @else
        <!-- Empty State -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/50 p-12 text-center transition-colors duration-200">
            <svg class="w-20 h-20 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>

            @if($search)
                <p class="text-gray-600 dark:text-gray-300 font-medium text-lg mb-2">No agents found</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Try searching with different keywords</p>
                <button wire:click="clearSearch" class="px-6 py-3 bg-uda-green-500 hover:bg-uda-green-600 text-white font-semibold rounded-lg transition">
                    Clear Search
                </button>
            @else
                <p class="text-gray-600 dark:text-gray-300 font-medium text-lg mb-2">No agents yet</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Create your first agent to start</p>
                <button wire:click="openCreateModal" class="px-6 py-3 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 text-white font-semibold rounded-lg hover:from-uda-yellow-600 hover:to-uda-green-600 transition">
                    Create Agent
                </button>
            @endif
        </div>
    @endif

    <!-- Create Agent Modal -->
    @if($showCreateModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto transition-colors duration-200">
                <div class="sticky top-0 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 dark:from-uda-yellow-600 dark:to-uda-green-600 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-white">Create New Agent</h2>
                    <button wire:click="closeCreateModal" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="createAgent" class="p-6 space-y-4">
                    <!-- ID Number -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">ID Number <span class="text-red-500 dark:text-red-400">*</span></label>
                        <input
                            type="text"
                            wire:model="id_number"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('id_number') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Enter ID number (numbers only)"
                            inputmode="numeric"
                            pattern="[0-9]*"
                        >
                        @error('id_number') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- First Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">First Name <span class="text-red-500 dark:text-red-400">*</span></label>
                        <input
                            type="text"
                            wire:model="first_name"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('first_name') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Enter first name"
                        >
                        @error('first_name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Second Name (Optional) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Second Name <span class="text-xs text-gray-500 dark:text-gray-400">(Optional)</span></label>
                        <input
                            type="text"
                            wire:model="second_name"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('second_name') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Enter second name (optional)"
                        >
                        @error('second_name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Last Name <span class="text-red-500 dark:text-red-400">*</span></label>
                        <input
                            type="text"
                            wire:model="last_name"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('last_name') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Enter last name"
                        >
                        @error('last_name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Phone Number <span class="text-red-500 dark:text-red-400">*</span></label>
                        <input
                            type="tel"
                            wire:model="phone"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('phone') border-red-500 dark:border-red-400 @enderror"
                            placeholder="0712345678"
                            inputmode="tel"
                        >
                        @error('phone') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- PIN -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">PIN <span class="text-red-500 dark:text-red-400">*</span></label>
                        <input
                            type="password"
                            wire:model="pin"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('pin') border-red-500 dark:border-red-400 @enderror"
                            placeholder="4-digit PIN"
                            inputmode="numeric"
                            pattern="[0-9]{4}"
                            maxlength="4"
                        >
                        @error('pin') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Must be exactly 4 digits</p>
                    </div>

                    <!-- Confirm PIN -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Confirm PIN <span class="text-red-500 dark:text-red-400">*</span></label>
                        <input
                            type="password"
                            wire:model="pin_confirmation"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition"
                            placeholder="Re-enter 4-digit PIN"
                            inputmode="numeric"
                            pattern="[0-9]{4}"
                            maxlength="4"
                        >
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center space-x-3">
                        <input
                            type="checkbox"
                            wire:model="is_active"
                            id="create_is_active"
                            class="w-5 h-5 text-uda-green-600 rounded"
                        >
                        <label for="create_is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Agent is active</label>
                    </div>

                    @error('create') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror

                    <!-- Form Actions -->
                    <div class="flex gap-3 pt-4">
                        <button
                            type="button"
                            wire:click="closeCreateModal"
                            class="flex-1 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 font-semibold rounded-lg transition"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="flex-1 py-3 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 hover:from-uda-yellow-600 hover:to-uda-green-600 disabled:opacity-50 text-white font-semibold rounded-lg transition"
                        >
                            <span wire:loading.remove>Create Agent</span>
                            <span wire:loading>Creating...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Edit Agent Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto transition-colors duration-200">
                <div class="sticky top-0 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 dark:from-uda-yellow-600 dark:to-uda-green-600 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-white">Edit Agent</h2>
                    <button wire:click="closeEditModal" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="updateAgent" class="p-6 space-y-4">
                    <!-- ID Number -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">ID Number <span class="text-red-500 dark:text-red-400">*</span></label>
                        <input
                            type="text"
                            wire:model="id_number"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('id_number') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Enter ID number (numbers only)"
                            inputmode="numeric"
                            pattern="[0-9]*"
                        >
                        @error('id_number') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- First Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">First Name <span class="text-red-500 dark:text-red-400">*</span></label>
                        <input
                            type="text"
                            wire:model="first_name"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('first_name') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Enter first name"
                        >
                        @error('first_name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Second Name (Optional) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Second Name <span class="text-xs text-gray-500 dark:text-gray-400">(Optional)</span></label>
                        <input
                            type="text"
                            wire:model="second_name"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('second_name') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Enter second name (optional)"
                        >
                        @error('second_name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Last Name <span class="text-red-500 dark:text-red-400">*</span></label>
                        <input
                            type="text"
                            wire:model="last_name"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('last_name') border-red-500 dark:border-red-400 @enderror"
                            placeholder="Enter last name"
                        >
                        @error('last_name') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Phone Number <span class="text-red-500 dark:text-red-400">*</span></label>
                        <input
                            type="tel"
                            wire:model="phone"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('phone') border-red-500 dark:border-red-400 @enderror"
                            placeholder="0712345678"
                            inputmode="tel"
                        >
                        @error('phone') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Change PIN (Optional) -->
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Change PIN <span class="text-xs text-gray-500 dark:text-gray-400">(Leave blank to keep current PIN)</span></label>
                        <input
                            type="password"
                            wire:model="pin"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('pin') border-red-500 dark:border-red-400 @enderror"
                            placeholder="New 4-digit PIN (optional)"
                            inputmode="numeric"
                            pattern="[0-9]{4}"
                            maxlength="4"
                        >
                        @error('pin') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <!-- Confirm PIN (if changing) -->
                    @if($pin)
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Confirm New PIN <span class="text-red-500 dark:text-red-400">*</span></label>
                        <input
                            type="password"
                            wire:model="pin_confirmation"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition"
                            placeholder="Re-enter new 4-digit PIN"
                            inputmode="numeric"
                            pattern="[0-9]{4}"
                            maxlength="4"
                        >
                    </div>
                    @endif

                    <!-- Active Status -->
                    <div class="flex items-center space-x-3">
                        <input
                            type="checkbox"
                            wire:model="is_active"
                            id="edit_is_active"
                            class="w-5 h-5 text-uda-green-600 rounded"
                        >
                        <label for="edit_is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Agent is active</label>
                    </div>

                    @error('update') <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror

                    <!-- Form Actions -->
                    <div class="flex gap-3 pt-4">
                        <button
                            type="button"
                            wire:click="closeEditModal"
                            class="flex-1 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 font-semibold rounded-lg transition"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="flex-1 py-3 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 hover:from-uda-yellow-600 hover:to-uda-green-600 disabled:opacity-50 text-white font-semibold rounded-lg transition"
                        >
                            <span wire:loading.remove>Update Agent</span>
                            <span wire:loading>Updating...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Loading Indicator -->
    <div wire:loading class="fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-gray-800 dark:bg-gray-700 text-white px-6 py-3 rounded-full shadow-lg">
        <div class="flex items-center space-x-3">
            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Loading...</span>
        </div>
    </div>

</div>
