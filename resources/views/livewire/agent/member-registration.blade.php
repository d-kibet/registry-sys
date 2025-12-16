<div class="p-4 max-w-2xl mx-auto relative">

    <!-- Security Watermark -->
    <div class="fixed inset-0 pointer-events-none z-10 flex items-center justify-center" style="opacity: 0.08;">
        <div class="transform -rotate-45 text-center">
            <p class="text-6xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ Auth::user()->name }}</p>
            <p class="text-4xl font-semibold text-gray-700 dark:text-gray-300">ID: {{ Auth::user()->id_number }}</p>
            <p class="text-3xl text-gray-600 dark:text-gray-400 mt-2">{{ Auth::user()->phone }}</p>
        </div>
    </div>

    <!-- Success Message -->
    @if($showSuccess)
        <div class="mb-6 p-4 bg-green-500 dark:bg-green-600 text-white rounded-xl shadow-lg dark:shadow-gray-900/50 animate-pulse">
            <div class="flex items-center space-x-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="font-bold text-lg">Registration Successful!</p>
                    <p class="text-sm">Member ID: #{{ $registeredMemberId }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">Register New Member</h1>
        <p class="text-gray-600 dark:text-gray-400">Fill in all required information below</p>
    </div>

    <!-- Registration Form -->
    <form wire:submit.prevent="submit" class="space-y-6">

        <!-- ID Number -->
        <div>
            <label for="id_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                ID Number <span class="text-red-500 dark:text-red-400">*</span>
            </label>
            <input
                type="text"
                id="id_number"
                wire:model="id_number"
                class="w-full px-4 py-4 text-lg bg-gray-50 dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-700 dark:text-gray-100 rounded-xl focus:bg-white dark:focus:bg-gray-700 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('id_number') border-red-500 dark:border-red-400 @enderror"
                placeholder="Enter ID number (numbers only)"
                inputmode="numeric"
                pattern="[0-9]*"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
            >
            @error('id_number') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        <!-- Phone Number with Real-time Duplicate Check -->
        <div>
            <label for="phone_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Phone Number <span class="text-red-500 dark:text-red-400">*</span>
            </label>
            <input
                type="tel"
                id="phone_number"
                wire:model.live.debounce.500ms="phone_number"
                class="w-full px-4 py-4 text-lg dark:bg-gray-800 dark:text-gray-100 border-2 rounded-xl transition @error('phone_number') border-red-500 dark:border-red-400 @else {{ $phoneExists ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-700' }} @enderror focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200"
                placeholder="0712345678"
                inputmode="numeric"
                pattern="[0-9+]*"
                oninput="this.value = this.value.replace(/[^0-9+]/g, '')"
            >

            @if($phoneExists)
                <div class="mt-3 p-3 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 dark:border-red-400 rounded-r-lg">
                    <p class="text-sm text-red-700 dark:text-red-400 font-medium">{{ $existingMemberMessage }}</p>
                </div>
            @endif

            @error('phone_number') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Format: 0712345678 or +254712345678</p>
        </div>

        <!-- First Name -->
        <div>
            <label for="first_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                First Name <span class="text-red-500 dark:text-red-400">*</span>
            </label>
            <input
                type="text"
                id="first_name"
                wire:model="first_name"
                class="w-full px-4 py-4 text-lg bg-gray-50 dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-700 dark:text-gray-100 rounded-xl focus:bg-white dark:focus:bg-gray-700 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('first_name') border-red-500 dark:border-red-400 @enderror"
                placeholder="Enter first name"
            >
            @error('first_name') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        <!-- Second Name (Optional) -->
        <div>
            <label for="second_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Second Name <span class="text-xs text-gray-500 dark:text-gray-400">(Optional)</span>
            </label>
            <input
                type="text"
                id="second_name"
                wire:model="second_name"
                class="w-full px-4 py-4 text-lg bg-gray-50 dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-700 dark:text-gray-100 rounded-xl focus:bg-white dark:focus:bg-gray-700 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('second_name') border-red-500 dark:border-red-400 @enderror"
                placeholder="Enter second name (optional)"
            >
            @error('second_name') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        <!-- Third Name (Last Name) -->
        <div>
            <label for="third_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Last Name <span class="text-red-500 dark:text-red-400">*</span>
            </label>
            <input
                type="text"
                id="third_name"
                wire:model="third_name"
                class="w-full px-4 py-4 text-lg bg-gray-50 dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-700 dark:text-gray-100 rounded-xl focus:bg-white dark:focus:bg-gray-700 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('third_name') border-red-500 dark:border-red-400 @enderror"
                placeholder="Enter last name"
            >
            @error('third_name') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        <!-- Gender Dropdown -->
        <div>
            <label for="gender" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Gender <span class="text-red-500 dark:text-red-400">*</span>
            </label>
            <select
                id="gender"
                wire:model="gender"
                class="w-full px-4 py-4 text-lg bg-gray-50 dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-700 dark:text-gray-100 rounded-xl focus:bg-white dark:focus:bg-gray-700 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('gender') border-red-500 dark:border-red-400 @enderror"
            >
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            @error('gender') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        <!-- Constituency (Pre-filled, Read-only) -->
        <div>
            <label for="constituency_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Constituency <span class="text-xs text-gray-500 dark:text-gray-400">(Assigned by Admin)</span>
            </label>
            <select
                id="constituency_id"
                wire:model="constituency_id"
                class="w-full px-4 py-4 text-lg bg-gray-200 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 dark:text-gray-300 rounded-xl cursor-not-allowed opacity-75"
                @if(count($constituencies) === 1) disabled @endif
            >
                <option value="">Select Constituency</option>
                @foreach($constituencies as $constituency)
                    <option value="{{ $constituency->id }}" {{ count($constituencies) === 1 ? 'selected' : '' }}>
                        {{ $constituency->name }} ({{ $constituency->county }})
                    </option>
                @endforeach
            </select>
            @error('constituency_id') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            @if(count($constituencies) === 1)
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">This constituency was assigned to your company by the administrator</p>
            @endif
        </div>

        <!-- Ward -->
        <div>
            <label for="ward" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Ward <span class="text-red-500 dark:text-red-400">*</span>
            </label>
            <select
                id="ward"
                wire:model.live="ward"
                class="w-full px-4 py-4 text-lg bg-gray-50 dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-700 dark:text-gray-100 rounded-xl focus:bg-white dark:focus:bg-gray-700 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('ward') border-red-500 dark:border-red-400 @enderror"
            >
                <option value="">Select Ward</option>
                <option value="Chepkunyuk">Chepkunyuk</option>
                <option value="Kapchorua">Kapchorua</option>
                <option value="Nandi Hills">Nandi Hills</option>
                <option value="Ollessos">Ollessos</option>
            </select>
            @error('ward') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        <!-- Polling Station -->
        <div>
            <label for="polling_station" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Polling Station <span class="text-red-500 dark:text-red-400">*</span>
            </label>
            <select
                id="polling_station"
                wire:model="polling_station"
                class="w-full px-4 py-4 text-lg bg-gray-50 dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-700 dark:text-gray-100 rounded-xl focus:bg-white dark:focus:bg-gray-700 focus:border-uda-yellow-500 focus:ring-2 focus:ring-uda-yellow-200 transition @error('polling_station') border-red-500 dark:border-red-400 @enderror"
                {{ empty($ward) ? 'disabled' : '' }}
            >
                <option value="">{{ empty($ward) ? 'Please select a ward first' : 'Select Polling Station' }}</option>
                @if(!empty($availablePollingStations))
                    @foreach($availablePollingStations as $station)
                        <option value="{{ $station }}">{{ $station }}</option>
                    @endforeach
                @endif
            </select>
            @error('polling_station') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
            @if(empty($ward))
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Select a ward to see available polling stations</p>
            @endif
        </div>

        <!-- Verification Proof Image Upload -->
        <div>
            <label for="verification_proof" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                Verification Proof (Photo/Screenshot) <span class="text-red-500 dark:text-red-400">*</span>
            </label>

            <div class="mt-2">
                <label for="verification_proof" class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-12 h-12 mb-3 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Tap to upload</span></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG (MAX. 2MB)</p>
                    </div>
                    <input
                        id="verification_proof"
                        type="file"
                        wire:model="verification_proof"
                        accept="image/*"
                        capture="environment"
                        class="hidden"
                    >
                </label>
            </div>

            @if ($verification_proof)
                <div class="mt-3 p-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-lg">
                    <p class="text-sm text-green-700 dark:text-green-400">✓ Image selected: {{ $verification_proof->getClientOriginalName() }}</p>
                </div>
            @endif

            <div wire:loading wire:target="verification_proof" class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg">
                <p class="text-sm text-blue-700 dark:text-blue-400">Uploading image...</p>
            </div>

            @error('verification_proof') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
        </div>

        <!-- Vie for Representative Positions -->
        <div class="p-4 bg-gray-50 dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-700 rounded-xl">
            <div class="mb-4">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input
                        type="checkbox"
                        wire:model.live="wants_to_vie"
                        class="w-5 h-5 text-uda-green-600 dark:text-uda-green-500 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded focus:ring-uda-green-500 dark:focus:ring-uda-green-400 focus:ring-2"
                    >
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Would you like to participate in vying for representative positions?
                    </span>
                </label>
            </div>

            @if($wants_to_vie)
                <div class="mt-4 pt-4 border-t border-gray-300 dark:border-gray-600">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        Select Position to Vie For:
                    </label>
                    <div class="space-y-3">
                        @foreach(['Youth Representative', 'Women Representative', 'PWDs Representative', 'MSMEs Representative', 'Farmers Representative', 'Religious Groups Representative', 'Professionals Representative'] as $position)
                            <label class="flex items-start space-x-3 cursor-pointer group">
                                <input
                                    type="radio"
                                    wire:model="vie_position"
                                    value="{{ $position }}"
                                    class="mt-0.5 w-5 h-5 text-uda-green-600 dark:text-uda-green-500 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-uda-green-500 dark:focus:ring-uda-green-400 focus:ring-2"
                                >
                                <span class="text-sm text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-gray-100">
                                    {{ $position }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('vie_position') <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    @if($vie_position)
                        <div class="mt-3 p-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-lg">
                            <p class="text-sm text-green-700 dark:text-green-400">
                                ✓ Selected: {{ $vie_position }}
                            </p>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- GPS Coordinates (Hidden inputs, auto-captured) -->
        <input type="hidden" wire:model="latitude" id="latitude">
        <input type="hidden" wire:model="longitude" id="longitude">

        <!-- GPS Status Indicator -->
        <div id="gps-status" class="hidden p-3 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg">
            <p class="text-sm text-blue-700 dark:text-blue-400">📍 Capturing location...</p>
        </div>

        <!-- Error Message -->
        @error('submit')
            <div class="p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 dark:border-red-400 rounded-r-lg">
                <p class="text-sm text-red-700 dark:text-red-400">{{ $message }}</p>
            </div>
        @enderror

        <!-- Submit Button (Large & Touch-Friendly) -->
        <button
            type="submit"
            wire:loading.attr="disabled"
            wire:target="submit"
            class="w-full py-5 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 hover:from-uda-yellow-600 hover:to-uda-green-600 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold text-xl rounded-xl shadow-lg dark:shadow-gray-900/50 active:scale-95 transition transform"
            @if($phoneExists) disabled @endif
        >
            <span wire:loading.remove wire:target="submit">
                Register Member
            </span>
            <span wire:loading wire:target="submit">
                <svg class="inline w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            </span>
        </button>

        <p class="text-center text-sm text-gray-500 dark:text-gray-400">
            All fields marked with <span class="text-red-500 dark:text-red-400">*</span> are required
        </p>
    </form>
</div>

@push('scripts')
<script>
    // Auto-hide success message after 5 seconds
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('registration-success', () => {
            setTimeout(() => {
                @this.showSuccess = false;
            }, 5000);
        });
    });

    // GPS Coordinate Capture
    if (navigator.geolocation) {
        const gpsStatus = document.getElementById('gps-status');
        gpsStatus?.classList.remove('hidden');

        navigator.geolocation.getCurrentPosition(
            function(position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;

                // Trigger Livewire update
                @this.latitude = position.coords.latitude;
                @this.longitude = position.coords.longitude;

                gpsStatus.innerHTML = '<p class="text-sm text-green-700">✓ Location captured successfully</p>';
                gpsStatus.classList.remove('bg-blue-50', 'border-blue-200');
                gpsStatus.classList.add('bg-green-50', 'border-green-200');

                setTimeout(() => gpsStatus.classList.add('hidden'), 3000);
            },
            function(error) {
                gpsStatus.innerHTML = '<p class="text-sm text-yellow-700">⚠️ Location optional - you can continue without it</p>';
                gpsStatus.classList.remove('bg-blue-50', 'border-blue-200');
                gpsStatus.classList.add('bg-yellow-50', 'border-yellow-200');

                setTimeout(() => gpsStatus.classList.add('hidden'), 5000);
            },
            {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            }
        );
    }
</script>
@endpush
