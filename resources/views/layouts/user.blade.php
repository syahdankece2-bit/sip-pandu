<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard Petugas') - SIP-PANDU
    </title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    {{-- Inter + JetBrains Mono --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=JetBrains+Mono:wght@500&display=swap"
        rel="stylesheet"
    >

    {{-- Material Symbols --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap"
        rel="stylesheet"
    >

    {{-- Tailwind Configuration --}}
    <script>
        tailwind.config = {
            darkMode: "class",

            theme: {
                extend: {
                    colors: {
                        "inverse-primary": "#bec6e0",
                        "outline-variant": "#c6c6cd",
                        "on-background": "#0b1c30",
                        "secondary-fixed-dim": "#b4c5ff",
                        "inverse-on-surface": "#eaf1ff",
                        "on-primary": "#ffffff",
                        "secondary-fixed": "#dbe1ff",
                        "secondary": "#0051d5",
                        "tertiary-fixed": "#e0e3e5",
                        "on-tertiary-fixed": "#191c1e",
                        "surface-container-highest": "#d3e4fe",
                        "on-secondary": "#ffffff",
                        "tertiary": "#000000",
                        "tertiary-fixed-dim": "#c4c7c9",
                        "primary-fixed-dim": "#bec6e0",
                        "error-container": "#ffdad6",
                        "inverse-surface": "#213145",
                        "on-primary-fixed": "#131b2e",
                        "on-primary-fixed-variant": "#3f465c",
                        "surface-container-lowest": "#ffffff",
                        "primary-container": "#131b2e",
                        "surface": "#f8f9ff",
                        "primary": "#000000",
                        "surface-container-low": "#eff4ff",
                        "on-primary-container": "#7c839b",
                        "background": "#f8f9ff",
                        "on-tertiary-container": "#818486",
                        "primary-fixed": "#dae2fd",
                        "on-surface": "#0b1c30",
                        "on-error-container": "#93000a",
                        "on-error": "#ffffff",
                        "surface-dim": "#cbdbf5",
                        "error": "#ba1a1a",
                        "on-tertiary": "#ffffff",
                        "surface-bright": "#f8f9ff",
                        "surface-container-high": "#dce9ff",
                        "secondary-container": "#316bf3",
                        "on-secondary-fixed-variant": "#003ea8",
                        "on-surface-variant": "#45464d",
                        "on-tertiary-fixed-variant": "#444749",
                        "surface-variant": "#d3e4fe",
                        "on-secondary-container": "#fefcff",
                        "outline": "#76777d",
                        "tertiary-container": "#191c1e",
                        "on-secondary-fixed": "#00174b"
                    },

                    borderRadius: {
                        DEFAULT: "0.125rem",
                        lg: "0.25rem",
                        xl: "0.5rem",
                        full: "0.75rem"
                    },

                    spacing: {
                        "container-max": "1440px",
                        "sm": "8px",
                        "lg": "24px",
                        "xl": "32px",
                        "sidebar-width": "260px",
                        "base": "4px",
                        "xs": "4px",
                        "md": "16px"
                    },

                    fontFamily: {
                        "body-md": ["Inter"],
                        "mono-md": ["JetBrains Mono"],
                        "headline-lg": ["Inter"],
                        "body-lg": ["Inter"],
                        "label-md": ["Inter"],
                        "headline-md": ["Inter"],
                        "headline-sm": ["Inter"]
                    },

                    fontSize: {
                        "body-md": [
                            "14px",
                            {
                                lineHeight: "20px",
                                fontWeight: "400"
                            }
                        ],

                        "mono-md": [
                            "13px",
                            {
                                lineHeight: "20px",
                                fontWeight: "500"
                            }
                        ],

                        "headline-lg": [
                            "30px",
                            {
                                lineHeight: "38px",
                                letterSpacing: "-0.02em",
                                fontWeight: "700"
                            }
                        ],

                        "body-lg": [
                            "16px",
                            {
                                lineHeight: "24px",
                                fontWeight: "400"
                            }
                        ],

                        "label-md": [
                            "12px",
                            {
                                lineHeight: "16px",
                                letterSpacing: "0.05em",
                                fontWeight: "600"
                            }
                        ],

                        "headline-md": [
                            "24px",
                            {
                                lineHeight: "32px",
                                letterSpacing: "-0.01em",
                                fontWeight: "600"
                            }
                        ],

                        "headline-sm": [
                            "20px",
                            {
                                lineHeight: "28px",
                                fontWeight: "600"
                            }
                        ]
                    }
                }
            }
        }
    </script>

    <style>
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
            font-feature-settings: 'liga';
        }
    </style>

    @stack('styles')
</head>


<body class="bg-background text-on-background font-body-md min-h-screen">

    {{-- SIDEBAR --}}
    <nav
        class="bg-primary-container fixed left-0 top-0 h-full w-sidebar-width border-r border-outline-variant flex-col py-xl z-20 hidden md:flex"
    >

        {{-- BRAND --}}
        <div class="px-xl mb-xl">

            <h1 class="font-headline-sm text-headline-sm font-bold text-on-primary">
                Arsip Bank
            </h1>

            <p class="font-label-md text-label-md text-on-primary-container mt-xs">
                Sistem Manajemen Dokumen
            </p>

        </div>


        {{-- MENU --}}
        <ul class="flex flex-col gap-sm flex-grow mt-lg">

            {{-- DASHBOARD --}}
            <li>

                <a
                    href="{{ route('user.dashboard') }}"
                    class="flex items-center gap-md px-md py-sm
                    {{ request()->routeIs('user.dashboard')
                        ? 'bg-secondary-container text-on-secondary border-l-4 border-secondary'
                        : 'text-on-primary-container hover:bg-inverse-surface' }}
                    transition-colors"
                >

                    <span class="material-symbols-outlined">
                        dashboard
                    </span>

                    <span>
                        Dashboard
                    </span>

                </a>

            </li>


            {{-- DATA NASABAH --}}
            <li>

                <a
                    href="{{ route('user.nasabah.index') }}"
                    class="flex items-center gap-md px-md py-sm
                    {{ request()->routeIs('user.nasabah.*')
                        ? 'bg-secondary-container text-on-secondary border-l-4 border-secondary'
                        : 'text-on-primary-container hover:bg-inverse-surface' }}
                    transition-colors"
                >

                    <span class="material-symbols-outlined">
                        group
                    </span>

                    <span>
                        Data Nasabah
                    </span>

                </a>

            </li>


            {{-- DOKUMEN --}}
            <li>

                <a
                    href="{{ route('user.dokumen.index') }}"
                    class="flex items-center gap-md px-md py-sm
                    {{ request()->routeIs('user.dokumen.*')
                        ? 'bg-secondary-container text-on-secondary border-l-4 border-secondary'
                        : 'text-on-primary-container hover:bg-inverse-surface' }}
                    transition-colors"
                >

                    <span class="material-symbols-outlined">
                        description
                    </span>

                    <span>
                        Dokumen
                    </span>

                </a>

            </li>


            {{-- PENGATURAN --}}
            <li>

                <a
                    href="{{ route('user.settings') }}"
                    class="flex items-center gap-md px-md py-sm
                    {{ request()->routeIs('user.settings')
                        ? 'bg-secondary-container text-on-secondary border-l-4 border-secondary'
                        : 'text-on-primary-container hover:bg-inverse-surface' }}
                    transition-colors"
                >

                    <span class="material-symbols-outlined">
                        settings
                    </span>

                    <span>
                        Pengaturan
                    </span>

                </a>

            </li>
        </ul>


        {{-- USER INFO + LOGOUT --}}
        <div class="mt-auto px-xl">

            <div class="border-t border-on-primary-container/30 pt-md mb-md">

                <p class="text-on-primary font-medium truncate">
                    {{ Auth::user()->name }}
                </p>

                <p class="text-on-primary-container text-xs truncate">
                    {{ Auth::user()->username }}
                </p>

            </div>


            <form
                action="{{ route('logout') }}"
                method="POST"
            >

                @csrf

                <button
                    type="submit"
                    class="w-full flex items-center gap-md px-md py-sm text-on-primary-container hover:text-on-primary transition-colors"
                >

                    <span class="material-symbols-outlined">
                        logout
                    </span>

                    <span>
                        Logout
                    </span>

                </button>

            </form>

        </div>

    </nav>


    {{-- MAIN --}}
    <main class="flex-1 md:ml-sidebar-width min-h-screen flex flex-col">


        {{-- TOPBAR --}}
        <header
            class="bg-surface border-b border-outline-variant flex justify-between items-center h-16 px-xl sticky top-0 z-10"
        >

            {{-- MOBILE BRAND --}}
            <div class="flex items-center">

                <h2 class="font-headline-sm font-black text-on-surface md:hidden">
                    Arsip Bank
                </h2>

            </div>


            {{-- RIGHT SIDE --}}
            <div class="flex items-center gap-lg">

                {{-- NOTIFICATION --}}
                <button
                    type="button"
                    class="text-on-surface-variant hover:text-secondary transition-all"
                >

                    <span class="material-symbols-outlined">
                        notifications
                    </span>

                </button>


                {{-- HELP --}}
                <button
                    type="button"
                    class="text-on-surface-variant hover:text-secondary transition-all"
                >

                    <span class="material-symbols-outlined">
                        help
                    </span>

                </button>

                {{-- PROFILE --}}
                <div
                    class="w-8 h-8 rounded-full overflow-hidden bg-secondary-container text-on-secondary flex items-center justify-center border border-outline-variant"
                >

                    @if (Auth::user()->avatar)

                        <img
                            src="{{ asset('storage/' . Auth::user()->avatar) }}"
                            alt="Foto Profil"
                            class="w-full h-full object-cover"
                        >

                    @else

                        <span class="material-symbols-outlined text-[20px]">
                            person
                        </span>

                    @endif

                </div>

            </div>

        </header>


        {{-- PAGE CONTENT --}}
        <div class="p-xl flex-1">

            @yield('content')

        </div>

    </main>


    @stack('scripts')

</body>

</html>