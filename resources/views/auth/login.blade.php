<x-guest-layout>
    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6 text-center">Sign In</h2>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-400 rounded-lg text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- ID Number -->
        <div>
            <label for="id_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                ID Number
            </label>
            <input
                id="id_number"
                type="text"
                name="id_number"
                value="{{ old('id_number') }}"
                required
                autofocus
                autocomplete="username"
                inputmode="numeric"
                pattern="[0-9]*"
                class="w-full px-4 py-4 text-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-uda-yellow-500 dark:focus:ring-uda-yellow-400 focus:border-transparent transition placeholder:text-gray-400 dark:placeholder:text-gray-500 @error('id_number') border-red-500 dark:border-red-500 @enderror"
                placeholder="Enter your ID number"
            >
            @error('id_number')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- PIN -->
        <div>
            <label for="pin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                PIN
            </label>
            <input
                id="pin"
                type="password"
                name="pin"
                required
                autocomplete="current-password"
                inputmode="numeric"
                pattern="[0-9]{4}"
                maxlength="4"
                class="w-full px-4 py-4 text-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-uda-yellow-500 dark:focus:ring-uda-yellow-400 focus:border-transparent transition placeholder:text-gray-400 dark:placeholder:text-gray-500 @error('pin') border-red-500 dark:border-red-500 @enderror"
                placeholder="Enter your 4-digit PIN"
            >
            @error('pin')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input
                id="remember"
                type="checkbox"
                name="remember"
                class="w-5 h-5 text-uda-green-600 dark:text-uda-green-500 bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded focus:ring-uda-yellow-500 dark:focus:ring-uda-yellow-400"
            >
            <label for="remember" class="ml-3 text-sm text-gray-600 dark:text-gray-400">
                Remember me on this device
            </label>
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="w-full py-4 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 hover:from-uda-yellow-600 hover:to-uda-green-600 text-white font-bold text-lg rounded-lg shadow-lg active:scale-95 transition transform"
        >
            Sign In
        </button>
    </form>

    <!-- Help Text -->
    <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
        <p>For assistance, contact your administrator</p>
    </div>
</x-guest-layout>
