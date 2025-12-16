<div class="p-4 max-w-2xl mx-auto space-y-6">

    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 dark:from-uda-yellow-600 dark:to-uda-green-600 rounded-xl p-6 text-white shadow-lg dark:shadow-gray-900/50">
        <h1 class="text-2xl font-bold mb-2">Welcome, {{ Auth::user()->name }}!</h1>
        <p class="text-sm opacity-90">Ready to register new members today?</p>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-2 gap-4">
        <!-- Today's Count -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-md dark:shadow-gray-900/50 border-l-4 border-uda-green-500 dark:border-uda-green-400 transition-colors duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Today</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $todayCount }}</p>
                </div>
                <div class="bg-uda-green-100 dark:bg-uda-green-900/30 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-uda-green-600 dark:text-uda-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- This Week -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-md dark:shadow-gray-900/50 border-l-4 border-uda-yellow-500 dark:border-uda-yellow-400 transition-colors duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">This Week</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $weekCount }}</p>
                </div>
                <div class="bg-uda-yellow-100 dark:bg-uda-yellow-900/30 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-uda-yellow-600 dark:text-uda-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- This Month -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-md dark:shadow-gray-900/50 border-l-4 border-blue-500 dark:border-blue-400 transition-colors duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">This Month</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $monthCount }}</p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Registrations -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-md dark:shadow-gray-900/50 border-l-4 border-purple-500 dark:border-purple-400 transition-colors duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $totalRegistrations }}</p>
                </div>
                <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action Button -->
    <a href="{{ route('agent.register') }}" class="block w-full py-5 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 hover:from-uda-yellow-600 hover:to-uda-green-600 text-white font-bold text-xl rounded-xl shadow-lg active:scale-95 transition transform text-center">
        <div class="flex items-center justify-center space-x-2">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span>Register New Member</span>
        </div>
    </a>

    <!-- Recent Registrations -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/50 overflow-hidden transition-colors duration-200">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-700/50 px-5 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">Recent Registrations</h2>
            <button wire:click="refresh" class="p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </button>
        </div>

        @if($recentRegistrations->count() > 0)
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($recentRegistrations as $member)
                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800 dark:text-gray-100 text-lg">{{ $member->full_name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $member->phone_number }}</p>
                                <div class="flex items-center space-x-2 mt-2">
                                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $member->constituency->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Verified
                                </span>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ $member->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- View All Link -->
            <div class="bg-gray-50 dark:bg-gray-700/50 px-5 py-4 text-center">
                <a href="{{ route('agent.my-registrations') }}" class="text-uda-green-600 dark:text-uda-green-400 font-semibold hover:text-uda-green-700 dark:hover:text-uda-green-500 transition">
                    View All Registrations →
                </a>
            </div>
        @else
            <div class="p-8 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-gray-500 dark:text-gray-400 font-medium">No registrations yet</p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Start by registering your first member</p>
            </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
    // Listen for refresh events
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('stats-refreshed', () => {
            // Optional: Show a brief success indicator
            console.log('Stats refreshed successfully');
        });
    });
</script>
@endpush
