const MODES = ['light', 'dark', 'system'];
const ACCENTS = ['indigo', 'emerald', 'violet', 'rose'];
const THEME_KEY = 'theme';
const DEFAULT_ACCENT = 'indigo';

const prefersDark = () => window.matchMedia('(prefers-color-scheme: dark)').matches;

const resolveMode = (mode) => (mode === 'system' ? (prefersDark() ? 'dark' : 'light') : mode);

export function readMode() {
    const stored = localStorage.getItem(THEME_KEY);

    return MODES.includes(stored) ? stored : 'system';
}

export function readAccent() {
    return DEFAULT_ACCENT;
}

export function applyMode(mode) {
    const resolved = resolveMode(mode);
    const root = document.documentElement;

    root.classList.toggle('dark', resolved === 'dark');
    root.dataset.theme = mode;
    root.style.colorScheme = resolved;
}

export function applyAccent(accent) {
    document.documentElement.dataset.accent = ACCENTS.includes(accent) ? accent : DEFAULT_ACCENT;
}

export function registerTheme(Alpine) {
    const initialMode = readMode();
    const initialAccent = readAccent();

    applyMode(initialMode);
    applyAccent(initialAccent);

    const media = window.matchMedia('(prefers-color-scheme: dark)');

    media.addEventListener('change', () => {
        if (readMode() !== 'system') {
            return;
        }

        applyMode('system');

        const store = Alpine.store('theme');

        if (store) {
            store.resolved = resolveMode('system');
        }
    });

    Alpine.store('theme', {
        mode: initialMode,
        resolved: resolveMode(initialMode),
        set(mode) {
            if (!MODES.includes(mode)) {
                return;
            }

            this.mode = mode;
            this.resolved = resolveMode(mode);
            localStorage.setItem(THEME_KEY, mode);
            applyMode(mode);
        },
        toggle() {
            this.set(this.resolved === 'dark' ? 'light' : 'dark');
        },
    });

    Alpine.store('accent', {
        value: initialAccent,
        options: ACCENTS,
        set(accent) {
            if (!ACCENTS.includes(accent)) {
                return;
            }

            this.value = accent;
            applyAccent(accent);
        },
    });
}

export { MODES, ACCENTS };
