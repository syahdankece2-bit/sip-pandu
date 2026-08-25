<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SIP-PANDU - Admin')</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    {{-- Google Fonts - Inter --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    {{-- Material Symbols --}}
    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,0..200"
    >

    {{-- Material Symbols CSS --}}
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
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24;
        }
    </style>

    {{-- Tailwind Configuration --}}
    <script>
        tailwind.config = {
            darkMode: "class",

            theme: {
                extend: {
                    colors: {
                        "primary-container": "#004a99",
                        "error-container": "#ffdad6",
                        "on-primary": "#ffffff",
                        "outline": "#737783",
                        "surface-container": "#eceef0",
                        "on-background": "#191c1e",
                        "surface-container-lowest": "#ffffff",
                        "surface-bright": "#f7f9fb",
                        "primary-fixed-dim": "#abc7ff",
                        "primary": "#00346f",
                        "error": "#ba1a1a",
                        "surface": "#f7f9fb",
                        "surface-container-highest": "#e0e3e5",
                        "surface-variant": "#e0e3e5",
                        "on-surface": "#191c1e",
                        "surface-container-low": "#f2f4f6",
                        "secondary": "#505f76",
                        "on-surface-variant": "#424751",
                        "outline-variant": "#c2c6d3"
                    },

                    borderRadius: {
                        DEFAULT: "0.125rem",
                        lg: "0.25rem",
                        xl: "0.5rem",
                        full: "0.75rem"
                    },

                    spacing: {
                        "sidebar-width": "280px",
                        "header-height": "64px",
                        "container-padding": "24px"
                    },

                    fontFamily: {
                        "body": ["Inter", "sans-serif"]
                    }
                }
            }
        };
    </script>

    @stack('styles')
</head>


<body class="bg-surface text-on-surface font-body min-h-screen">


    {{-- =========================================================
         SIDEBAR
    ========================================================== --}}
    <nav
        class="bg-surface-container-lowest w-sidebar-width h-screen fixed left-0 top-0 border-r border-outline-variant flex flex-col py-6 z-50"
    >

        {{-- Logo --}}
        <div class="px-6 mb-8">

            <h1 class="text-3xl font-bold text-primary">
                SIP-PANDU
            </h1>

            <p class="text-sm text-on-surface-variant mt-1">
                Admin System
            </p>

        </div>


        {{-- Navigation --}}
        <div class="flex-1 flex flex-col gap-1 px-3">


            {{-- Dashboard --}}
            <a
                href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                {{ request()->routeIs('admin.dashboard')
                    ? 'text-primary font-semibold border-l-2 border-primary bg-surface-container'
                    : 'text-on-surface-variant hover:bg-surface-container-low' }}
                transition-colors"
            >

                <span
                    class="material-symbols-outlined"
                    @if(request()->routeIs('admin.dashboard'))
                        style="font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24;"
                    @endif
                >
                    dashboard
                </span>

                <span class="text-sm font-medium">
                    Dashboard
                </span>

            </a>

            {{-- Data Nasabah --}}
            <a
                href="{{ route('admin.nasabah.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                {{ request()->routeIs('admin.nasabah.*')
                    ? 'text-primary font-semibold border-l-2 border-primary bg-surface-container'
                    : 'text-on-surface-variant hover:bg-surface-container-low' }}
                transition-colors"
            >

                <span
                    class="material-symbols-outlined"
                    @if(request()->routeIs('admin.nasabah.*'))
                        style="font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24;"
                    @endif
                >
                    group
                </span>

                <span class="text-sm font-medium">
                    Data Nasabah
                </span>

            </a>


            {{-- Jenis Dokumen --}}
            <a
                href="{{ route('admin.jenis-dokumen') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                {{ request()->routeIs('admin.jenis-dokumen*')
                    ? 'text-primary font-semibold border-l-2 border-primary bg-surface-container'
                    : 'text-on-surface-variant hover:bg-surface-container-low' }}
                transition-colors"
            >

                <span
                    class="material-symbols-outlined"
                    @if(request()->routeIs('admin.jenis-dokumen*'))
                        style="font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24;"
                    @endif
                >
                    description
                </span>

                <span class="text-sm font-medium">
                    Jenis Dokumen
                </span>

            </a>


            {{-- Kelola User --}}
            <a
                href="{{ route('admin.users') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                {{ request()->routeIs('admin.users*')
                    ? 'text-primary font-semibold border-l-2 border-primary bg-surface-container'
                    : 'text-on-surface-variant hover:bg-surface-container-low' }}
                transition-colors"
            >

                <span
                    class="material-symbols-outlined"
                    @if(request()->routeIs('admin.users*'))
                        style="font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24;"
                    @endif
                >
                    manage_accounts
                </span>

                <span class="text-sm font-medium">
                    Kelola User
                </span>

            </a>


            {{-- Settings --}}
            <a
                href="{{ route('admin.settings') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                {{ request()->routeIs('admin.settings*')
                    ? 'text-primary font-semibold border-l-2 border-primary bg-surface-container'
                    : 'text-on-surface-variant hover:bg-surface-container-low' }}
                transition-colors"
            >

                <span
                    class="material-symbols-outlined"
                    @if(request()->routeIs('admin.settings*'))
                        style="font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 24;"
                    @endif
                >
                    settings
                </span>

                <span class="text-sm font-medium">
                    Pengaturan
                </span>

            </a>

        </div>


        {{-- =====================================================
             LOGOUT
        ====================================================== --}}
        <div class="px-3 mt-auto border-t border-outline-variant pt-4">

            <form action="{{ route('logout') }}" method="POST">

                @csrf

                <button
                    type="submit"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg
                    text-on-surface-variant
                    hover:bg-surface-container-low
                    hover:text-error
                    transition-colors"
                >

                    <span class="material-symbols-outlined">
                        logout
                    </span>

                    <span class="text-sm font-medium">
                        Logout
                    </span>

                </button>

            </form>

        </div>

    </nav>



    {{-- =========================================================
         MAIN AREA
    ========================================================== --}}
    <div class="ml-sidebar-width flex flex-col min-h-screen">


        {{-- =====================================================
             TOP NAVBAR
        ====================================================== --}}
        <header
            class="bg-surface h-header-height fixed top-0 right-0
            w-[calc(100%-280px)]
            border-b border-outline-variant
            flex justify-between items-center px-4 z-40"
        >

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-on-surface-variant">

                @yield('breadcrumb')

            </div>


            {{-- Right Navigation --}}
            <div class="flex items-center gap-4">


                {{-- Notification --}}
                <button
                    type="button"
                    class="text-on-surface-variant
                    hover:text-primary
                    transition-colors
                    p-2 rounded-full
                    hover:bg-surface-container-low"
                    title="Notifikasi"
                >

                    <span class="material-symbols-outlined">
                        notifications
                    </span>

                </button>


                {{-- Help --}}
                <button
                    type="button"
                    class="text-on-surface-variant
                    hover:text-primary
                    transition-colors
                    p-2 rounded-full
                    hover:bg-surface-container-low"
                    title="Bantuan"
                >

                    <span class="material-symbols-outlined">
                        help
                    </span>

                </button>


                {{-- Profile --}}
                @php $authUser = auth()->user(); @endphp
                <a
                    href="{{ route('admin.settings') }}"
                    class="flex items-center gap-2 border-l border-outline-variant pl-4 ml-2 hover:opacity-80 transition-opacity"
                    title="Pengaturan Profil"
                >

                    {{-- Profile Icon / Avatar --}}
                    @if ($authUser && $authUser->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($authUser->avatar))
                        <img
                            src="{{ asset('storage/' . $authUser->avatar) }}?v={{ $authUser->updated_at?->timestamp }}"
                            alt="Foto Profil"
                            class="w-8 h-8 rounded-full object-cover border border-outline-variant flex-shrink-0"
                        />
                    @else
                        <div
                            class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                        >
                            {{ strtoupper(substr($authUser->name ?? 'AD', 0, 2)) }}
                        </div>
                    @endif


                    {{-- Profile Information --}}
                    <div class="flex flex-col">

                        <span class="text-xs font-semibold text-on-surface">
                            {{ $authUser->name ?? 'Admin' }}
                        </span>

                        <span class="text-[11px] text-on-surface-variant">
                            {{ ucfirst($authUser->role ?? 'Administrator') }}
                        </span>

                    </div>

                </a>

            </div>

        </header>



        {{-- =====================================================
             PAGE CONTENT
        ====================================================== --}}
        <main
            class="flex-1 mt-header-height p-container-padding overflow-y-auto"
        >

            @yield('content')

        </main>

    </div>


    @stack('scripts')

</body>
</html>