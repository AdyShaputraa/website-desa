{{-- Terapkan tema sebelum paint agar tidak ada flash warna salah. Accent dikunci ke indigo. --}}
<script>
    (function () {
        try {
            var mode = localStorage.getItem('theme') || 'system';
            var isDark = mode === 'dark'
                || (mode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
            var root = document.documentElement;

            root.classList.toggle('dark', isDark);
            root.dataset.theme = mode;
            root.dataset.accent = 'indigo';
            root.dataset.sidebarCollapsed = localStorage.getItem('sidebar_collapsed') === '1' ? 'true' : 'false';
            root.style.colorScheme = isDark ? 'dark' : 'light';
        } catch (error) {
            // localStorage dapat diblokir; biarkan tema default.
        }
    })();
</script>
