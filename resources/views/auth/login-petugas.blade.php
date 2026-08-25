<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIP-PANDU | Login Petugas</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    {{-- Inter & JetBrains Mono --}}
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
                        "surface-variant": "#d3e4fe",
                        "on-secondary-container": "#fefcff",
                        "surface-container": "#e5eeff",
                        "surface-tint": "#565e74",
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
                        "body-md": ["14px", {
                            lineHeight: "20px",
                            fontWeight: "400"
                        }],

                        "mono-md": ["13px", {
                            lineHeight: "20px",
                            fontWeight: "500"
                        }],

                        "headline-lg": ["30px", {
                            lineHeight: "38px",
                            letterSpacing: "-0.02em",
                            fontWeight: "700"
                        }],

                        "body-lg": ["16px", {
                            lineHeight: "24px",
                            fontWeight: "400"
                        }],

                        "label-md": ["12px", {
                            lineHeight: "16px",
                            letterSpacing: "0.05em",
                            fontWeight: "600"
                        }],

                        "headline-md": ["24px", {
                            lineHeight: "32px",
                            letterSpacing: "-0.01em",
                            fontWeight: "600"
                        }],

                        "headline-sm": ["20px", {
                            lineHeight: "28px",
                            fontWeight: "600"
                        }]
                    }
                }
            }
        };
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
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-background min-h-screen flex items-center justify-center font-body-md text-body-md text-on-surface antialiased">

    <div class="w-full flex min-h-screen">

        {{-- ============================================================
             LEFT PANEL
        ============================================================= --}}
        <div class="hidden lg:flex lg:w-1/2 relative bg-primary-container flex-col justify-between p-xl overflow-hidden">

            {{-- Background --}}
            <div class="absolute inset-0 z-0">

                <div
                    class="w-full h-full bg-cover bg-center opacity-40 mix-blend-overlay"
                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAx5H9cttACu0OdJq7AjuJ3oDgGhrvNCzR3ltd9oqnA539r4Oj6JyHeuBtR3Rbkp4g7ROapmB7R7FtNb3w9rs2nYazVIPzhl1U2qN08KT6yLe1vit4KPlaYLJAYTPKsLVulCUDsffwF3f8beBFkQBiJOLzHJyzMMLhHUPIJIPwKvbkO3PH1KKoADdcYZbd-hmyFPF4gndx65Hs8zv2Lzv3H7QDEQa0H7rhlvmu8X0U1Xe7q1pY8E9KV8w');"
                ></div>

                <div class="absolute inset-0 bg-gradient-to-t from-primary-container via-primary-container/80 to-transparent"></div>

            </div>


            {{-- Branding / Logo --}}
            <div class="relative z-10 flex items-center gap-3 text-white">

                <span
                    class="material-symbols-outlined"
                    style="font-size: 32px; font-variation-settings: 'FILL' 1;"
                >
                    assured_workload
                </span>

                <span class="text-2xl font-bold tracking-tight">
                    SIP-PANDU
                </span>

            </div>


            {{-- Description --}}
            <div class="relative z-10">

                <h1 class="font-headline-lg text-headline-lg text-on-primary mb-md">
                    Sistem Informasi<br>
                    Pengelolaan Arsip Terpadu
                </h1>

                <p class="font-body-lg text-body-lg text-inverse-primary max-w-md">
                    Infrastruktur manajemen dokumen yang aman, terpusat,
                    dan dapat dilacak sepenuhnya.
                </p>

            </div>

        </div>


        {{-- ============================================================
             RIGHT PANEL
        ============================================================= --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-xl bg-surface">

            <div class="w-full max-w-sm bg-surface-container-lowest border border-outline-variant p-xl rounded-xl">

                {{-- ====================================================
                     LOGO & HEADER
                ===================================================== --}}
                <div class="flex flex-col items-center mb-xl text-center">

                    <div class="w-16 h-16 mb-md bg-surface-container-high rounded-full flex items-center justify-center border border-outline-variant shadow-sm">

                        <span
                            class="material-symbols-outlined text-secondary"
                            style="font-size: 32px; font-variation-settings: 'FILL' 1;"
                        >
                            assured_workload
                        </span>

                    </div>


                    <h2 class="font-headline-md text-headline-md text-on-surface font-bold mt-sm">
                        Masuk ke SIP-PANDU
                    </h2>

                    <p class="font-body-md text-body-md text-on-surface-variant mt-xs">
                        Autentikasi diperlukan untuk akses arsip.
                    </p>

                </div>


                {{-- ====================================================
                     ERROR MESSAGE
                ===================================================== --}}
                @if ($errors->any())

                    <div class="mb-5 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">

                        {{ $errors->first() }}

                    </div>

                @endif


                {{-- ====================================================
                     LOGIN FORM
                ===================================================== --}}
                <form
                    action="{{ route('login.process') }}"
                    method="POST"
                    class="space-y-lg"
                >

                    @csrf


                    {{-- USERNAME --}}
                    <div class="space-y-sm">

                        <label
                            for="username"
                            class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider block"
                        >
                            Username
                        </label>

                        <div class="relative">

                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">
                                person
                            </span>

                            <input
                                id="username"
                                name="username"
                                type="text"
                                value="{{ old('username') }}"
                                placeholder="Masukkan ID Petugas"
                                required
                                autofocus
                                autocomplete="username"
                                class="w-full bg-surface-bright border border-outline-variant rounded-lg pl-10 pr-md py-[10px] text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-colors font-body-md text-body-md"
                            >

                        </div>

                    </div>


                    {{-- PASSWORD --}}
                    <div class="space-y-sm">

                        <label
                            for="password"
                            class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider block"
                        >
                            Password
                        </label>

                        <div class="relative">

                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">
                                lock
                            </span>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                placeholder="••••••••"
                                required
                                autocomplete="current-password"
                                class="w-full bg-surface-bright border border-outline-variant rounded-lg pl-10 pr-12 py-[10px] text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-colors font-body-md text-body-md"
                            >

                            {{-- Toggle Password --}}
                            <button
                                type="button"
                                id="togglePassword"
                                class="absolute right-0 top-0 h-full px-3 flex items-center text-outline hover:text-on-surface transition-colors"
                            >

                                <span
                                    class="material-symbols-outlined text-[20px]"
                                    id="eyeIcon"
                                >
                                    visibility_off
                                </span>

                            </button>

                        </div>

                    </div>


                    {{-- REMEMBER ME --}}
                    <div class="flex items-center pt-sm">

                        <input
                            id="remember-me"
                            name="remember-me"
                            type="checkbox"
                            class="h-4 w-4 rounded border-outline-variant text-secondary focus:ring-secondary bg-surface-bright"
                        >

                        <label
                            for="remember-me"
                            class="ml-2 block font-body-md text-body-md text-on-surface-variant cursor-pointer"
                        >
                            Ingat saya
                        </label>

                    </div>


                    {{-- SUBMIT BUTTON --}}
                    <div class="pt-sm">

                        <button
                            id="loginButton"
                            type="submit"
                            class="w-full flex justify-center items-center py-[12px] px-md border border-transparent rounded-lg shadow-sm font-label-md text-label-md uppercase tracking-wider text-on-secondary bg-secondary hover:bg-secondary-container hover:text-on-secondary-container focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary transition-colors active:scale-[0.99]"
                        >

                            <span>
                                Masuk
                            </span>

                            <span class="material-symbols-outlined ml-2 text-[18px]">
                                login
                            </span>

                        </button>

                    </div>

                </form>


                {{-- ====================================================
                     FOOTER STATUS
                ===================================================== --}}
                <div class="mt-xl text-center border-t border-outline-variant pt-lg">

                    <div class="inline-flex items-center gap-xs bg-surface-container-high px-md py-xs rounded-full border border-outline-variant">

                        <span class="material-symbols-outlined text-[16px] text-on-surface-variant">
                            admin_panel_settings
                        </span>

                        <span class="font-mono-md text-mono-md text-on-surface-variant">
                            Login sebagai Petugas
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ================================================================
         PASSWORD TOGGLE
    ================================================================= --}}
    <script>

        const togglePassword =
            document.getElementById('togglePassword');

        const passwordInput =
            document.getElementById('password');

        const eyeIcon =
            document.getElementById('eyeIcon');


        togglePassword.addEventListener('click', function () {

            if (passwordInput.type === 'password') {

                passwordInput.type = 'text';

                eyeIcon.textContent = 'visibility';

            } else {

                passwordInput.type = 'password';

                eyeIcon.textContent = 'visibility_off';

            }

        });

    </script>

</body>

</html>