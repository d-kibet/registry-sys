<!-- PWA Install Prompt -->
<div id="pwa-install-prompt" class="hidden fixed bottom-20 left-4 right-4 lg:left-auto lg:right-4 lg:w-96 bg-white dark:bg-gray-800 rounded-xl shadow-2xl dark:shadow-gray-900/50 p-4 z-50 border-2 border-uda-green-500 dark:border-uda-green-600 transition-colors duration-200">
    <div class="flex items-start gap-3">
        <div class="flex-shrink-0">
            <div class="w-12 h-12 bg-gradient-to-br from-uda-yellow-500 to-uda-green-500 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
        <div class="flex-1">
            <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-1">Install UDA Registry</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Install this app on your device for quick and easy access</p>
            <div class="flex gap-2">
                <button
                    onclick="installPWA()"
                    class="flex-1 py-2 px-4 bg-gradient-to-r from-uda-yellow-500 to-uda-green-500 text-white font-semibold rounded-lg text-sm hover:shadow-lg transition"
                >
                    Install
                </button>
                <button
                    onclick="dismissPWAPrompt()"
                    class="py-2 px-4 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-lg text-sm hover:bg-gray-300 dark:hover:bg-gray-600 transition"
                >
                    Later
                </button>
            </div>
        </div>
        <button
            onclick="dismissPWAPrompt()"
            class="flex-shrink-0 p-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition"
        >
            <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>

<script>
    let pwaPrompt = null;

    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        pwaPrompt = e;

        // Check if user has dismissed the prompt before
        const dismissed = localStorage.getItem('pwa-install-dismissed');
        const dismissedTime = localStorage.getItem('pwa-install-dismissed-time');

        // Show prompt if not dismissed or if 7 days have passed
        if (!dismissed || (dismissedTime && Date.now() - dismissedTime > 7 * 24 * 60 * 60 * 1000)) {
            setTimeout(() => {
                document.getElementById('pwa-install-prompt').classList.remove('hidden');
            }, 3000); // Show after 3 seconds
        }
    });

    function installPWA() {
        if (!pwaPrompt) {
            return;
        }

        // Show the install prompt
        pwaPrompt.prompt();

        // Wait for the user to respond to the prompt
        pwaPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('User accepted the install prompt');
            } else {
                console.log('User dismissed the install prompt');
            }
            pwaPrompt = null;
            document.getElementById('pwa-install-prompt').classList.add('hidden');
        });
    }

    function dismissPWAPrompt() {
        document.getElementById('pwa-install-prompt').classList.add('hidden');
        localStorage.setItem('pwa-install-dismissed', 'true');
        localStorage.setItem('pwa-install-dismissed-time', Date.now().toString());
    }

    // Listen for app installed event
    window.addEventListener('appinstalled', () => {
        document.getElementById('pwa-install-prompt').classList.add('hidden');
        localStorage.setItem('pwa-install-dismissed', 'true');

        // Show success message
        alert('UDA Registry has been installed successfully!');
    });
</script>
