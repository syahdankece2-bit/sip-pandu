<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Masuk ke SIP-PANDU - Admin System</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    {{-- Inter Font --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
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
                        "primary-container": "#004a99",
                        "error-container": "#ffdad6",
                        "on-primary": "#ffffff",
                        "outline": "#737783",
                        "surface-container": "#eceef0",
                        "on-background": "#191c1e",
                        "surface-container-lowest": "#ffffff",
                        "primary-fixed-dim": "#abc7ff",
                        "surface-bright": "#f7f9fb",
                        "primary": "#00346f",
                        "error": "#ba1a1a",
                        "surface": "#f7f9fb",
                        "surface-container-highest": "#e0e3e5",
                        "surface-variant": "#e0e3e5",
                        "outline-variant": "#c2c6d3",
                        "on-surface": "#191c1e",
                        "on-surface-variant": "#424751"
                    },

                    borderRadius: {
                        DEFAULT: "0.125rem",
                        lg: "0.25rem",
                        xl: "0.5rem",
                        full: "0.75rem"
                    },

                    spacing: {
                        "gutter": "16px",
                        "container-padding": "24px"
                    },

                    fontFamily: {
                        "body": ["Inter", "sans-serif"]
                    },

                    fontSize: {
                        "body-md": ["14px", {
                            lineHeight: "20px",
                            fontWeight: "400"
                        }],

                        "body-sm": ["13px", {
                            lineHeight: "18px",
                            fontWeight: "400"
                        }],

                        "headline-md": ["24px", {
                            lineHeight: "32px",
                            letterSpacing: "-0.01em",
                            fontWeight: "600"
                        }],

                        "label-md": ["12px", {
                            lineHeight: "16px",
                            fontWeight: "500"
                        }],

                        "label-bold": ["12px", {
                            lineHeight: "16px",
                            fontWeight: "600"
                        }],

                        "display-lg": ["32px", {
                            lineHeight: "40px",
                            letterSpacing: "-0.02em",
                            fontWeight: "700"
                        }]
                    }
                }
            }
        };
    </script>

    {{-- Material Symbols Configuration --}}
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

        .glass-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow:
                0 4px 6px -1px rgba(0, 0, 0, 0.05),
                0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
    </style>
</head>


<body class="bg-surface min-h-screen flex items-center justify-center text-on-surface">

    {{-- LOGIN CARD --}}
    <div class="w-full max-w-md mx-auto px-4">

        <div class="glass-panel rounded-xl overflow-hidden">

            <div class="p-8 md:p-10 bg-surface-container-lowest">

                <div class="w-full max-w-sm mx-auto">

                    {{-- BRANDING --}}
                    <div class="flex items-center justify-center gap-3 mb-8 text-primary">

                        <span class="material-symbols-outlined text-[36px]">
                            account_balance
                        </span>

                        <span class="text-3xl font-bold">
                            SIP-PANDU
                        </span>

                    </div>


                    {{-- TITLE --}}
                    <div class="mb-8">

                        <h2 class="text-headline-md text-on-surface mb-2">
                            Masuk ke SIP-PANDU
                        </h2>

                        <p class="text-body-md text-on-surface-variant">
                            Silakan masukkan kredensial Anda untuk mengakses sistem admin.
                        </p>

                    </div>


                    {{-- ERROR MESSAGE --}}
                    @if ($errors->any())

                        <div class="mb-5 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">

                            {{ $errors->first() }}

                        </div>

                    @endif


                    {{-- LOGIN FORM --}}
                    <form
                        action="{{ route('login.process') }}"
                        method="POST"
                        class="space-y-5"
                    >

                        @csrf


                        {{-- USERNAME --}}
                        <div>

                            <label
                                for="username"
                                class="block text-label-md text-on-surface mb-1"
                            >
                                Username
                            </label>

                            <div class="relative">

                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline">

                                    <span class="material-symbols-outlined text-[20px]">
                                        person
                                    </span>

                                </div>

                                <input
                                    id="username"
                                    name="username"
                                    type="text"
                                    value="{{ old('username') }}"
                                    placeholder="Masukkan username admin"
                                    required
                                    autofocus
                                    class="block w-full pl-10 pr-3 py-2.5 border border-outline-variant rounded-lg bg-surface focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary text-body-md text-on-surface transition-colors"
                                >

                            </div>

                        </div>


                        {{-- PASSWORD --}}
                        <div>

                            <label
                                for="password"
                                class="block text-label-md text-on-surface mb-1"
                            >
                                Password
                            </label>

                            <div class="relative">

                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline">

                                    <span class="material-symbols-outlined text-[20px]">
                                        lock
                                    </span>

                                </div>

                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    placeholder="Masukkan password"
                                    required
                                    class="block w-full pl-10 pr-10 py-2.5 border border-outline-variant rounded-lg bg-surface focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary text-body-md text-on-surface transition-colors"
                                >

                                <button
                                    type="button"
                                    id="togglePassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-outline hover:text-on-surface transition-colors"
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
                        <div class="flex items-center justify-between pt-1">

                            <div class="flex items-center">

                                <input
                                    id="remember-me"
                                    name="remember-me"
                                    type="checkbox"
                                    class="h-4 w-4 text-primary focus:ring-primary border-outline-variant rounded bg-surface"
                                >

                                <label
                                    for="remember-me"
                                    class="ml-2 block text-body-sm text-on-surface-variant"
                                >
                                    Ingat saya
                                </label>

                            </div>

                            <a
                                href="#"
                                class="text-label-md text-primary hover:text-primary-container transition-colors"
                            >
                                Lupa Password?
                            </a>

                        </div>


                        {{-- SUBMIT BUTTON --}}
                        <div class="pt-4">

                            <button
                                id="loginButton"
                                type="submit"
                                class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-label-bold text-on-primary bg-primary-container hover:bg-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all active:scale-[0.98]"
                            >

                                <span>
                                    Masuk
                                </span>

                                <span class="material-symbols-outlined ml-2 text-[18px]">
                                    login
                                </span>

                            </button>

                        </div>


                        {{-- REGISTER --}}
                        <div class="mt-4 text-center">

                            <p class="text-body-sm text-on-surface-variant">

                                Belum punya akun?

                                <a
                                    href="#"
                                    class="text-primary font-semibold hover:text-primary-container transition-colors"
                                >
                                    Daftar di sini
                                </a>

                            </p>

                        </div>

                    </form>

                </div>

            </div>

        </div>


        {{-- FOOTER --}}
        <div class="text-center mt-6">

            <p class="text-body-sm text-outline">
                © 2026 SIP-PANDU. Hak Cipta Dilindungi.
            </p>

            <div class="flex justify-center gap-4 mt-2">

                <a
                    href="#"
                    class="text-label-md text-outline hover:text-primary transition-colors"
                >
                    Kebijakan Privasi
                </a>

                <a
                    href="#"
                    class="text-label-md text-outline hover:text-primary transition-colors"
                >
                    Syarat & Ketentuan
                </a>

            </div>

        </div>

    </div>


    {{-- PASSWORD TOGGLE --}}
    <script>
        document
            .getElementById('togglePassword')
            .addEventListener('click', function () {

                const passwordInput =
                    document.getElementById('password');

                const eyeIcon =
                    document.getElementById('eyeIcon');

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