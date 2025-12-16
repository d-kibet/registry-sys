<div class="p-4 max-w-2xl mx-auto space-y-4">

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">All Registrations</h1>
        <p class="text-gray-600 dark:text-gray-400">System-wide: {{ $members->total() }} members</p>
    </div>

    <!-- Search Bar -->
    <div class="relative">
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            placeholder="Search by name, phone, or ID..."
            class="w-full px-4 py-4 pl-12 pr-12 text-lg bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-xl focus:border-uda-yellow-500 dark:focus:border-uda-yellow-400 focus:ring-2 focus:ring-uda-yellow-200 dark:focus:ring-uda-yellow-500/30 transition placeholder:text-gray-400 dark:placeholder:text-gray-500"
        >
        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>

        @if($search)
            <button wire:click="$set('search', '')" class="absolute right-4 top-1/2 transform -translate-y-1/2 p-1 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-full transition">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/50 p-4 space-y-3 transition-colors duration-200">
        <div class="flex items-center justify-between">
            <h3 class="font-semibold text-gray-800 dark:text-gray-100">Filters</h3>
            @if($companyFilter || $constituencyFilter || $dateFrom || $dateTo)
                <button wire:click="clearFilters" class="text-sm text-red-600 dark:text-red-400 font-medium hover:text-red-700 dark:hover:text-red-500 transition">
                    Clear All
                </button>
            @endif
        </div>

        <!-- Company Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Company</label>
            <select
                wire:model.live="companyFilter"
                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 dark:focus:border-uda-yellow-400 focus:ring-2 focus:ring-uda-yellow-200 dark:focus:ring-uda-yellow-500/30 transition"
            >
                <option value="">All Companies</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Constituency Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Constituency</label>
            <select
                wire:model.live="constituencyFilter"
                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 dark:focus:border-uda-yellow-400 focus:ring-2 focus:ring-uda-yellow-200 dark:focus:ring-uda-yellow-500/30 transition"
            >
                <option value="">All Constituencies</option>
                @foreach($constituencies as $constituency)
                    <option value="{{ $constituency->id }}">{{ $constituency->name }} ({{ $constituency->county }})</option>
                @endforeach
            </select>
        </div>

        <!-- Date Range Filter -->
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">From Date</label>
                <input
                    type="date"
                    wire:model.live="dateFrom"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 dark:focus:border-uda-yellow-400 focus:ring-2 focus:ring-uda-yellow-200 dark:focus:ring-uda-yellow-500/30 transition"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">To Date</label>
                <input
                    type="date"
                    wire:model.live="dateTo"
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-lg focus:bg-white dark:focus:bg-gray-600 focus:border-uda-yellow-500 dark:focus:border-uda-yellow-400 focus:ring-2 focus:ring-uda-yellow-200 dark:focus:ring-uda-yellow-500/30 transition"
                >
            </div>
        </div>
    </div>

    <!-- Active Filters Display -->
    @if($search || $companyFilter || $constituencyFilter || $dateFrom || $dateTo)
        <div class="flex items-center justify-between text-sm">
            <p class="text-gray-600 dark:text-gray-400">
                Showing {{ $members->total() }} result{{ $members->total() !== 1 ? 's' : '' }}
            </p>
        </div>
    @endif

    <!-- Members List -->
    @if($members->count() > 0)
        <div class="space-y-3">
            @foreach($members as $member)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/50 p-5 border-l-4 border-uda-green-500 dark:border-uda-green-400 hover:shadow-lg transition-all duration-200">
                    <!-- Member Header -->
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">{{ $member->full_name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">ID: #{{ $member->id }}</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Verified
                        </span>
                    </div>

                    <!-- Member Details Grid -->
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <!-- Phone -->
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Phone Number</p>
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $member->phone_number }}</p>
                            </div>
                        </div>

                        <!-- ID Number -->
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">ID/Passport</p>
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $member->id_number }}</p>
                            </div>
                        </div>

                        <!-- Gender -->
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Gender</p>
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $member->gender }}</p>
                            </div>
                        </div>

                        <!-- Registration Date -->
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Registered</p>
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $member->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Company, Agent & Location Details -->
                    <div class="pt-3 border-t border-gray-200 dark:border-gray-700 space-y-2">
                        <div class="flex items-start space-x-2">
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                <span class="font-medium">{{ $member->company->name }}</span>
                            </p>
                        </div>
                        <div class="flex items-start space-x-2">
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                Registered by <span class="font-medium">{{ $member->registeredBy->name }}</span>
                            </p>
                        </div>
                        <div class="flex items-start space-x-2">
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    <span class="font-medium">{{ $member->constituency->name }}</span>,
                                    {{ $member->ward }} Ward,
                                    {{ $member->polling_station }}
                                </p>
                            </div>
                        </div>

                        <!-- Verification Proof Image -->
                        @if($member->verification_proof_path)
                            <div class="flex items-start space-x-2 mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Verification Proof</p>
                                    <div class="relative group inline-block">
                                        <img
                                            src="{{ asset('storage/' . $member->verification_proof_path) }}"
                                            alt="Verification proof for {{ $member->full_name }}"
                                            class="w-32 h-32 object-cover rounded-lg border-2 border-gray-200 dark:border-gray-700 cursor-pointer hover:border-uda-green-500 dark:hover:border-uda-green-400 transition"
                                            onclick="openImageModal('{{ asset('storage/' . $member->verification_proof_path) }}', '{{ $member->full_name }}')"
                                        >
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Image Modal -->
        <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 hidden z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
            <div class="relative max-w-4xl w-full" onclick="event.stopPropagation()">
                <button onclick="closeImageModal()" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <img id="modalImage" src="" alt="" class="w-full h-auto rounded-lg shadow-2xl">
                <p id="modalCaption" class="text-white text-center mt-4 font-medium"></p>
            </div>
        </div>

        <script>
            function openImageModal(imageSrc, memberName) {
                document.getElementById('imageModal').classList.remove('hidden');
                document.getElementById('modalImage').src = imageSrc;
                document.getElementById('modalCaption').textContent = 'Verification Proof - ' + memberName;
                document.body.style.overflow = 'hidden';
            }

            function closeImageModal() {
                document.getElementById('imageModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            // Close modal on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeImageModal();
                }
            });
        </script>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $members->links() }}
        </div>

    @else
        <!-- Empty State -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/50 p-12 text-center transition-colors duration-200">
            <svg class="w-20 h-20 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>

            <p class="text-gray-600 dark:text-gray-300 font-medium text-lg mb-2">No registrations found</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Try adjusting your filters or search</p>
            <button wire:click="clearFilters" class="px-6 py-3 bg-uda-green-500 hover:bg-uda-green-600 dark:bg-uda-green-600 dark:hover:bg-uda-green-700 text-white font-semibold rounded-lg transition">
                Clear Filters
            </button>
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
