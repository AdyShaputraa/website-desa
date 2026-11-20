export function registerComponents(Alpine) {
    const SIDEBAR_COLLAPSED_KEY = 'sidebar_collapsed';

    const readSidebarCollapsed = () => {
        try {
            return localStorage.getItem(SIDEBAR_COLLAPSED_KEY) === '1';
        } catch (error) {
            return false;
        }
    };

    Alpine.store('sidebar', {
        open: false,
        collapsed: readSidebarCollapsed(),
        toggle() {
            this.open = !this.open;
        },
        close() {
            this.open = false;
        },
        toggleCollapsed() {
            this.collapsed = !this.collapsed;

            try {
                localStorage.setItem(SIDEBAR_COLLAPSED_KEY, this.collapsed ? '1' : '0');
            } catch (error) {
                // localStorage dapat diblokir; state tetap berlaku selama halaman terbuka.
            }

            document.documentElement.dataset.sidebarCollapsed = this.collapsed ? 'true' : 'false';
        },
    });

    Alpine.store('toasts', {
        items: [],
        push(message, type = 'success', duration = 5000) {
            const id = `${Date.now()}-${Math.random().toString(36).slice(2)}`;

            this.items.push({ id, message, type });

            if (duration > 0) {
                window.setTimeout(() => this.remove(id), duration);
            }
        },
        remove(id) {
            this.items = this.items.filter((toast) => toast.id !== id);
        },
    });

    Alpine.data('dropdown', () => ({
        open: false,
        toggle() {
            this.open = !this.open;
        },
        close() {
            this.open = false;
        },
    }));

    Alpine.data('modal', () => ({
        open: false,
        previouslyFocused: null,
        show() {
            this.previouslyFocused = document.activeElement;
            this.open = true;
            document.body.style.overflow = 'hidden';

            this.$nextTick(() => {
                const panel = this.$refs.panel;
                const target =
                    panel?.querySelector('[data-autofocus]') ??
                    panel?.querySelector(
                        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])',
                    );

                target?.focus();
            });
        },
        hide() {
            this.open = false;
            document.body.style.overflow = '';
            this.previouslyFocused?.focus?.();
        },
    }));

    Alpine.data('tabs', (initial = 0) => ({
        active: initial,
        select(index) {
            this.active = index;
        },
        isActive(index) {
            return this.active === index;
        },
    }));

    Alpine.data('accordion', () => ({
        openItem: null,
        toggle(index) {
            this.openItem = this.openItem === index ? null : index;
        },
        isOpen(index) {
            return this.openItem === index;
        },
    }));

    Alpine.data('passwordInput', () => ({
        visible: false,
        toggle() {
            this.visible = !this.visible;
        },
    }));
}
