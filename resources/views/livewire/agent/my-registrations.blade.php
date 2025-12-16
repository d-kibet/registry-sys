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
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">My Registrations</h1>
        <p class="text-gray-600 dark:text-gray-400">Total: {{ $members->total() }} members</p>
    </div>

    <!-- Search Bar -->
    <div class="relative">
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            placeholder="Search by name, phone, or ID..."
            class="w-full px-4 py-4 pl-12 pr-12 text-lg border-2 border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-xl focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition"
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

    <!-- Results Info -->
    @if($search)
        <div class="flex items-center justify-between text-sm">
            <p class="text-gray-600 dark:text-gray-400">
                Found {{ $members->total() }} result{{ $members->total() !== 1 ? 's' : '' }} for "<span class="font-semibold">{{ $search }}</span>"
            </p>
        </div>
    @endif

    <!-- Members Table -->
    @if($members->count() > 0)
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
                            <th class="px-4 py-4 text-left text-sm font-bold uppercase tracking-wider">Gender</th>
                            <th class="px-4 py-4 text-left text-sm font-bold uppercase tracking-wider">Ward</th>
                            <th class="px-4 py-4 text-left text-sm font-bold uppercase tracking-wider">Polling Station</th>
                            <th class="px-4 py-4 text-left text-sm font-bold uppercase tracking-wider">Date</th>
                            <th class="px-4 py-4 text-left text-sm font-bold uppercase tracking-wider">Proof</th>
                            <th class="px-4 py-4 text-left text-sm font-bold uppercase tracking-wider">Vie Status</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($members as $index => $member)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                <!-- Row Number -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                        {{ $members->firstItem() + $index }}
                                    </span>
                                </td>

                                <!-- Full Name -->
                                <td class="px-4 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $member->full_name }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            Member #{{ $member->id }}
                                        </span>
                                    </div>
                                </td>

                                <!-- ID Number -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-700 dark:text-gray-300 font-mono">
                                        {{ $member->id_number }}
                                    </span>
                                </td>

                                <!-- Phone Number -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-700 dark:text-gray-300 font-mono">
                                        {{ $member->phone_number }}
                                    </span>
                                </td>

                                <!-- Gender -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $member->gender === 'Male' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400' : 'bg-pink-100 dark:bg-pink-900/30 text-pink-800 dark:text-pink-400' }}">
                                        {{ $member->gender }}
                                    </span>
                                </td>

                                <!-- Ward -->
                                <td class="px-4 py-4">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $member->ward }}
                                    </span>
                                </td>

                                <!-- Polling Station -->
                                <td class="px-4 py-4">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $member->polling_station }}
                                    </span>
                                </td>

                                <!-- Registration Date -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm text-gray-900 dark:text-gray-100 font-medium">
                                            {{ $member->created_at->format('d/m/Y') }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $member->created_at->format('H:i') }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Verification Proof -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if($member->verification_proof_path)
                                        <button
                                            onclick="openImageModal('{{ asset('storage/' . $member->verification_proof_path) }}', '{{ $member->full_name }}')"
                                            class="inline-flex items-center px-3 py-1.5 bg-uda-green-500 hover:bg-uda-green-600 dark:bg-uda-green-600 dark:hover:bg-uda-green-700 text-white text-xs font-medium rounded-lg transition-colors duration-150"
                                        >
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            View
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400 dark:text-gray-500 italic">N/A</span>
                                    @endif
                                </td>

                                <!-- Vie Status -->
                                <td class="px-4 py-4">
                                    @if($member->wants_to_vie && $member->vie_position)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-400">
                                            {{ str_replace(' Representative', '', $member->vie_position) }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400 dark:text-gray-500 italic">Not vying</span>
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

            @if($search)
                <p class="text-gray-600 dark:text-gray-300 font-medium text-lg mb-2">No results found</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Try searching with different keywords</p>
                <button wire:click="clearSearch" class="px-6 py-3 bg-uda-green-500 hover:bg-uda-green-600 text-white font-semibold rounded-lg transition">
                    Clear Search
                </button>
            @else
                <p class="text-gray-600 dark:text-gray-300 font-medium text-lg mb-2">No registrations yet</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Start by registering your first member</p>
                <a href="{{ route('agent.register') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 text-white font-semibold rounded-lg hover:from-uda-yellow-600 hover:to-uda-green-600 transition">
                    Register Member
                </a>
            @endif
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
