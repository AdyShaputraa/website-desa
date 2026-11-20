{{-- Terapkan tema sebelum paint agar tidak ada flash warna salah. --}}
<script>
    (function () {
        try {
            var mode = localStorage.getItem('theme') || 'system';
            var accent = localStorage.getItem('accent') || 'indigo';
            var isDark = mode === 'dark'
                || (mode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
            var root = document.documentElement;

            root.classList.toggle('dark', isDark);
            root.dataset.theme = mode;
            root.dataset.accent = accent;
            root.style.colorScheme = isDark ? 'dark' : 'light';
        } catch (error) {
            // localStorage dapat diblokir; biarkan tema default.
        }
    })();
</script>
