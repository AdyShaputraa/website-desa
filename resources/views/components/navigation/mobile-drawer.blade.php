@props(['label' => 'Menu navigasi'])

<div
    class="lg:contents"
    x-data="{ isMobile: window.innerWidth < 1024 }"
    x-on:resize.window.debounce.200ms="isMobile = window.innerWidth < 1024; if (! isMobile) $store.sidebar.close()"
    x-on:keydown.escape.window="$store.sidebar.close()"
    x-effect="if (isMobile && $store.sidebar.open) $nextTick(() => $refs.sidebarPanel?.querySelector('[data-sidebar-close]')?.focus())"
>
    <div
        x-show="$store.sidebar.open"
        x-cloak
        x-transition.opacity
        x-on:click="$store.sidebar.close()"
        class="fixed inset-0 z-30 bg-overlay lg:hidden"
        aria-hidden="true"
    ></div>

    <aside
        id="app-sidebar"
        x-ref="sidebarPanel"
        x-bind:inert="isMobile && ! $store.sidebar.open"
        class="fixed inset-y-0 left-0 z-40 w-72 max-w-[85vw] shadow-xl transition-transform duration-200 ease-out lg:static lg:z-auto lg:w-auto lg:max-w-none lg:translate-x-0 lg:shadow-none"
        :class="$store.sidebar.open ? 'translate-x-0' : '-translate-x-full'"
        aria-label="{{ $label }}"
    >
        <div class="h-full lg:sticky lg:top-0 lg:h-screen">
            {{ $slot }}
        </div>
    </aside>
</div>
