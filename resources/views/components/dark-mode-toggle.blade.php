<!-- Dark Mode Toggle -->
<button
    id="darkModeToggle"
    onclick="toggleDarkMode()"
    class="p-2 rounded-lg bg-white/20 dark:bg-gray-800/50 hover:bg-white/30 dark:hover:bg-gray-700/50 transition-all duration-200"
    aria-label="Toggle dark mode"
>
    <!-- Sun Icon (shown in dark mode) -->
    <svg id="sunIcon" class="w-5 h-5 text-white hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>

    <!-- Moon Icon (shown in light mode) -->
    <svg id="moonIcon" class="w-5 h-5 text-white block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
    </svg>
</button>

<script>
    // Dark mode functionality
    function toggleDarkMode() {
        const html = document.documentElement;
        const isDark = html.classList.contains('dark');

        if (isDark) {
            html.classList.remove('dark');
            localStorage.setItem('darkMode', 'false');
            updateMetaThemeColor('#179847'); // UDA Green for light mode
        } else {
            html.classList.add('dark');
            localStorage.setItem('darkMode', 'true');
            updateMetaThemeColor('#1F2937'); // Dark gray for dark mode
        }
    }

    function updateMetaThemeColor(color) {
        let metaThemeColor = document.querySelector('meta[name="theme-color"]');
        if (metaThemeColor) {
            metaThemeColor.setAttribute('content', color);
        }
    }

    // Initialize dark mode on page load
    (function() {
        const darkMode = localStorage.getItem('darkMode');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (darkMode === 'true' || (darkMode === null && prefersDark)) {
            document.documentElement.classList.add('dark');
            updateMetaThemeColor('#1F2937');
        } else {
            document.documentElement.classList.remove('dark');
            updateMetaThemeColor('#179847');
        }
    })();

    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        const darkMode = localStorage.getItem('darkMode');
        // Only auto-switch if user hasn't manually set preference
        if (darkMode === null) {
            if (e.matches) {
                document.documentElement.classList.add('dark');
                updateMetaThemeColor('#1F2937');
            } else {
                document.documentElement.classList.remove('dark');
                updateMetaThemeColor('#179847');
            }
        }
    });
</script>
