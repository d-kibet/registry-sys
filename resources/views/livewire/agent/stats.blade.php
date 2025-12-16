<div class="p-4 max-w-2xl mx-auto space-y-6">

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">My Statistics</h1>
            <p class="text-gray-600 dark:text-gray-400">Your registration performance</p>
        </div>
        <button wire:click="refresh" class="p-3 bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-gray-900/50 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
            <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
        </button>
    </div>

    <!-- Total Overview Card -->
    <div class="bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 dark:from-uda-yellow-600 dark:to-uda-green-600 rounded-xl p-6 text-white shadow-lg dark:shadow-gray-900/50">
        <p class="text-sm opacity-90 mb-2">Total Registrations</p>
        <p class="text-5xl font-bold">{{ $totalMembers }}</p>
        <p class="text-sm opacity-90 mt-2">All-time members registered</p>
    </div>

    <!-- Daily Registrations (Last 7 Days) -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/50 overflow-hidden transition-colors duration-200">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-700/50 px-5 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">Daily Registrations</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Last 7 days</p>
        </div>

        <div class="p-5">
            @php
                $maxDaily = max(array_values($dailyStats)) ?: 1;
            @endphp

            @if(array_sum(array_values($dailyStats)) > 0)
                <div class="space-y-4">
                    @foreach($dailyStats as $date => $count)
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $date }}</span>
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-100">{{ $count }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                <div
                                    class="bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 h-3 rounded-full transition-all duration-500"
                                    style="width: {{ $maxDaily > 0 ? ($count / $maxDaily * 100) : 0 }}%"
                                ></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">No registrations in the last 7 days</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Gender Breakdown -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/50 overflow-hidden transition-colors duration-200">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-700/50 px-5 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">Gender Breakdown</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Distribution by gender</p>
        </div>

        <div class="p-5">
            @if($totalMembers > 0)
                <div class="space-y-4">
                    @foreach($genderBreakdown as $gender => $count)
                        @php
                            $percentage = ($count / $totalMembers) * 100;
                            $color = match($gender) {
                                'Male' => 'blue',
                                'Female' => 'pink',
                                default => 'gray',
                            };
                        @endphp

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    @if($gender === 'Male')
                                        <svg class="w-5 h-5 text-blue-500 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    @elseif($gender === 'Female')
                                        <svg class="w-5 h-5 text-pink-500 dark:text-pink-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $gender }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-bold text-gray-800 dark:text-gray-100">{{ $count }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">({{ number_format($percentage, 1) }}%)</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                <div
                                    class="h-3 rounded-full transition-all duration-500 {{ $gender === 'Male' ? 'bg-blue-500' : ($gender === 'Female' ? 'bg-pink-500' : 'bg-gray-500') }}"
                                    style="width: {{ $percentage }}%"
                                ></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 dark:text-gray-400 font-medium">No data available</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Top Constituencies -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/50 overflow-hidden transition-colors duration-200">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-700/50 px-5 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100">Top Constituencies</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Your most active areas</p>
        </div>

        <div class="p-5">
            @if(count($topConstituencies) > 0)
                <div class="space-y-4">
                    @foreach($topConstituencies as $index => $constituency)
                        @php
                            $percentage = ($constituency['count'] / $totalMembers) * 100;
                            $colors = ['green', 'blue', 'yellow', 'purple', 'pink'];
                            $color = $colors[$index % count($colors)];
                        @endphp

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-{{ $color }}-100 dark:bg-{{ $color }}-900/30 flex items-center justify-center">
                                        <span class="text-sm font-bold text-{{ $color }}-600 dark:text-{{ $color }}-400">#{{ $index + 1 }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $constituency['name'] }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-bold text-gray-800 dark:text-gray-100">{{ $constituency['count'] }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">({{ number_format($percentage, 1) }}%)</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                                <div
                                    class="h-3 rounded-full transition-all duration-500 bg-{{ $color }}-500"
                                    style="width: {{ $percentage }}%"
                                ></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">No constituency data yet</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Action -->
    <a href="{{ route('agent.register') }}" class="block w-full py-5 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 hover:from-uda-yellow-600 hover:to-uda-green-600 text-white font-bold text-xl rounded-xl shadow-lg active:scale-95 transition transform text-center">
        <div class="flex items-center justify-center space-x-2">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span>Register New Member</span>
        </div>
    </a>

</div>

@push('scripts')
<script>
    // Listen for refresh events
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('stats-refreshed', () => {
            console.log('Stats refreshed successfully');
        });
    });
</script>
@endpush
