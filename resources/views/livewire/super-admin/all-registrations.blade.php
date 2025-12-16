<div class="p-4 space-y-4">

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

    <!-- Members Table -->
    @if($members->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Member</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Company & Agent</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Registered</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Proof</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($members as $member)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <!-- Member Info -->
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $member->full_name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $member->id_number }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-{{ $member->gender == 'Male' ? 'blue' : 'pink' }}-100 dark:bg-{{ $member->gender == 'Male' ? 'blue' : 'pink' }}-900/30 text-{{ $member->gender == 'Male' ? 'blue' : 'pink' }}-800 dark:text-{{ $member->gender == 'Male' ? 'blue' : 'pink' }}-400">
                                                {{ $member->gender }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Contact -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700 dark:text-gray-300">{{ $member->phone_number }}</div>
                                </td>

                                <!-- Location -->
                                <td class="px-6 py-4">
                                    <div class="text-xs text-gray-700 dark:text-gray-300">
                                        <div class="font-medium">{{ $member->constituency->name }}</div>
                                        <div class="text-gray-500 dark:text-gray-400">{{ $member->ward }} Ward</div>
                                        <div class="text-gray-500 dark:text-gray-400">{{ $member->polling_station }}</div>
                                    </div>
                                </td>

                                <!-- Company & Agent -->
                                <td class="px-6 py-4">
                                    <div class="text-xs">
                                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $member->company->name }}</div>
                                        <div class="text-gray-500 dark:text-gray-400">by {{ $member->registeredBy->name }}</div>
                                    </div>
                                </td>

                                <!-- Registered Date -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $member->created_at->format('d/m/Y') }}
                                </td>

                                <!-- Verification Proof -->
                                <td class="px-6 py-4 text-center">
                                    @if($member->verification_proof_path)
                                        <img
                                            src="{{ asset('storage/' . $member->verification_proof_path) }}"
                                            alt="Verification proof"
                                            class="w-16 h-16 object-cover rounded-lg border-2 border-gray-200 dark:border-gray-700 cursor-pointer hover:border-uda-green-500 dark:hover:border-uda-green-400 transition inline-block"
                                            onclick="openImageModal('{{ asset('storage/' . $member->verification_proof_path) }}', '{{ $member->full_name }}')"
                                        >
                                    @else
                                        <span class="text-xs text-gray-400 dark:text-gray-500">No proof</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
