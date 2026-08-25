@extends('layouts.user')

@section('title', 'Pengaturan')

@section('content')

<div class="p-6 md:p-8">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}

    <div class="mb-8">

        <h2 class="text-2xl md:text-3xl font-bold text-slate-900">
            Pengaturan Akun
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Kelola informasi profil, keamanan, dan preferensi akun Anda.
        </p>

    </div>


    {{-- =========================================================
        SUCCESS MESSAGE
    ========================================================== --}}

    @if (session('success'))

        <div
            class="mb-6 flex items-start gap-3 p-4 rounded-lg
                   bg-green-50 border border-green-200 text-green-700"
        >

            <span class="material-symbols-outlined text-[20px]">
                check_circle
            </span>

            <div>

                <p class="text-sm font-medium">
                    {{ session('success') }}
                </p>

            </div>

        </div>

    @endif


    {{-- =========================================================
        ERROR MESSAGE
    ========================================================== --}}

    @if ($errors->any())

        <div
            class="mb-6 p-4 rounded-lg
                   bg-red-50 border border-red-200 text-red-700"
        >

            <div class="flex items-start gap-3">

                <span class="material-symbols-outlined text-[20px]">
                    error
                </span>

                <div>

                    <p class="text-sm font-semibold mb-1">
                        Terjadi kesalahan
                    </p>

                    <ul class="text-xs space-y-1">

                        @foreach ($errors->all() as $error)

                            <li>
                                • {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif



    {{-- =========================================================
        SETTINGS LAYOUT
    ========================================================== --}}

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">


        {{-- =====================================================
            LEFT NAVIGATION
        ====================================================== --}}

        <div class="lg:col-span-3">

            <div
                class="flex flex-row lg:flex-col gap-2
                       overflow-x-auto lg:sticky lg:top-24"
            >

                {{-- PROFIL --}}

                <a
                    href="#profil"
                    class="flex items-center gap-2 px-4 py-3
                           bg-blue-600 text-white rounded-lg
                           whitespace-nowrap text-left w-full
                           transition-colors"
                >

                    <span class="material-symbols-outlined text-[20px]">
                        person
                    </span>

                    <span class="text-xs font-semibold">
                        Profil Pribadi
                    </span>

                </a>


                {{-- KEAMANAN --}}

                <a
                    href="#keamanan"
                    class="flex items-center gap-2 px-4 py-3
                           text-slate-600 hover:bg-slate-100
                           hover:text-blue-600 rounded-lg
                           whitespace-nowrap text-left w-full
                           transition-colors"
                >

                    <span class="material-symbols-outlined text-[20px]">
                        lock
                    </span>

                    <span class="text-xs font-semibold">
                        Keamanan
                    </span>

                </a>


                {{-- PREFERENSI --}}

                <a
                    href="#preferensi"
                    class="flex items-center gap-2 px-4 py-3
                           text-slate-600 hover:bg-slate-100
                           hover:text-blue-600 rounded-lg
                           whitespace-nowrap text-left w-full
                           transition-colors"
                >

                    <span class="material-symbols-outlined text-[20px]">
                        tune
                    </span>

                    <span class="text-xs font-semibold">
                        Preferensi
                    </span>

                </a>

            </div>

        </div>



        {{-- =====================================================
            RIGHT CONTENT
        ====================================================== --}}

        <div class="lg:col-span-9 flex flex-col gap-6">


            {{-- =================================================
                PROFIL PRIBADI
            ================================================== --}}

            <section
                id="profil"
                class="bg-white border border-slate-200 rounded-xl
                       p-6 flex flex-col gap-6 shadow-sm"
            >

                {{-- HEADER --}}

                <div class="border-b border-slate-200 pb-4">

                    <h3
                        class="text-xl font-semibold text-slate-900
                               flex items-center gap-2"
                    >

                        <span class="material-symbols-outlined text-blue-700">
                            person
                        </span>

                        Profil Pribadi

                    </h3>

                    <p class="text-xs text-slate-500 mt-1">
                        Informasi akun petugas yang sedang login.
                    </p>

                </div>


                {{-- =================================================
                    PROFILE CONTENT
                ================================================== --}}

                <div class="flex flex-col md:flex-row gap-8 items-start">


                    {{-- =================================================
                        AVATAR
                    ================================================== --}}

                    <div class="flex flex-col items-center gap-3">

                        <div
                            class="w-32 h-32 rounded-full overflow-hidden
                                   border-4 border-slate-100 shadow-sm
                                   bg-slate-100 flex items-center
                                   justify-center"
                        >

                            @if ($user->avatar)

                                <img
                                    src="{{ asset('storage/' . $user->avatar) }}"
                                    alt="Foto Profil {{ $user->name }}"
                                    class="w-full h-full object-cover"
                                >

                            @else

                                <span
                                    class="material-symbols-outlined
                                           text-6xl text-slate-400"
                                >
                                    person
                                </span>

                            @endif

                        </div>


                        {{-- Upload button --}}

                        <label
                            for="avatar"
                            class="inline-flex items-center gap-2
                                   px-4 py-2
                                   border border-slate-300
                                   text-slate-700
                                   text-xs font-semibold
                                   rounded-lg cursor-pointer
                                   hover:bg-slate-50
                                   transition-colors"
                        >

                            <span class="material-symbols-outlined text-[18px]">
                                photo_camera
                            </span>

                            Ubah Foto

                        </label>


                        {{-- Hidden File Input --}}

                        <input
                            id="avatar"
                            type="file"
                            name="avatar"
                            form="profile-form"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="hidden"
                        >


                        <span
                            class="text-[10px] text-slate-400
                                   text-center"
                        >
                            JPG, PNG, WEBP
                            <br>
                            Maksimal 2 MB
                        </span>


                        @error('avatar')

                            <span class="text-xs text-red-600 text-center">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>



                    {{-- =================================================
                        PROFILE FORM
                    ================================================== --}}

                    <form
                        id="profile-form"
                        action="{{ route('user.settings.profile') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="flex-1 w-full"
                    >

                        @csrf


                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                            {{-- =================================================
                                NAMA
                            ================================================== --}}

                            <div class="flex flex-col gap-1">

                                <label
                                    class="text-xs font-semibold
                                           text-slate-600"
                                >
                                    Nama Lengkap
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                    class="w-full px-4 py-2.5
                                           bg-white rounded-lg
                                           border border-slate-300
                                           focus:border-blue-600
                                           focus:ring-1
                                           focus:ring-blue-600
                                           text-sm outline-none
                                           transition-all"
                                >

                                @error('name')

                                    <span class="text-xs text-red-600">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>



                            {{-- =================================================
                                ID PEGAWAI
                            ================================================== --}}

                            <div class="flex flex-col gap-1">

                                <label
                                    class="text-xs font-semibold
                                           text-slate-600"
                                >
                                    ID Pegawai
                                </label>

                                <input
                                    type="text"
                                    value="{{ $user->id_pegawai }}"
                                    disabled
                                    class="w-full px-4 py-2.5
                                           bg-slate-100 rounded-lg
                                           border border-slate-300
                                           text-slate-500 text-sm
                                           cursor-not-allowed"
                                >

                                <span class="text-[10px] text-slate-400">
                                    ID Pegawai tidak dapat diubah
                                    melalui halaman ini.
                                </span>

                            </div>



                            {{-- =================================================
                                USERNAME
                            ================================================== --}}

                            <div class="flex flex-col gap-1">

                                <label
                                    class="text-xs font-semibold
                                           text-slate-600"
                                >
                                    Username
                                </label>

                                <input
                                    type="text"
                                    name="username"
                                    value="{{ old('username', $user->username) }}"
                                    required
                                    class="w-full px-4 py-2.5
                                           bg-white rounded-lg
                                           border border-slate-300
                                           focus:border-blue-600
                                           focus:ring-1
                                           focus:ring-blue-600
                                           text-sm outline-none
                                           transition-all"
                                >

                                @error('username')

                                    <span class="text-xs text-red-600">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>



                            {{-- =================================================
                                EMAIL
                            ================================================== --}}

                            <div class="flex flex-col gap-1">

                                <label
                                    class="text-xs font-semibold
                                           text-slate-600"
                                >
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    placeholder="Masukkan email"
                                    class="w-full px-4 py-2.5
                                           bg-white rounded-lg
                                           border border-slate-300
                                           focus:border-blue-600
                                           focus:ring-1
                                           focus:ring-blue-600
                                           text-sm outline-none
                                           transition-all"
                                >

                                @error('email')

                                    <span class="text-xs text-red-600">
                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>



                            {{-- =================================================
                                JABATAN
                            ================================================== --}}

                            <div class="flex flex-col gap-1">

                                <label
                                    class="text-xs font-semibold
                                           text-slate-600"
                                >
                                    Jabatan
                                </label>

                                <input
                                    type="text"
                                    value="{{ ucfirst($user->role) }}"
                                    disabled
                                    class="w-full px-4 py-2.5
                                           bg-slate-100 rounded-lg
                                           border border-slate-300
                                           text-slate-500 text-sm
                                           cursor-not-allowed"
                                >

                            </div>



                            {{-- =================================================
                                STATUS
                            ================================================== --}}

                            <div class="flex flex-col gap-1">

                                <label
                                    class="text-xs font-semibold
                                           text-slate-600"
                                >
                                    Status Akun
                                </label>

                                <div class="h-[42px] flex items-center">

                                    @if ($user->status === 'aktif')

                                        <span
                                            class="inline-flex items-center
                                                   gap-2 px-3 py-1.5
                                                   rounded-lg
                                                   bg-green-50
                                                   text-green-700
                                                   border border-green-200
                                                   text-xs font-semibold"
                                        >

                                            <span
                                                class="w-2 h-2 rounded-full
                                                       bg-green-500"
                                            ></span>

                                            Aktif

                                        </span>

                                    @else

                                        <span
                                            class="inline-flex items-center
                                                   gap-2 px-3 py-1.5
                                                   rounded-lg
                                                   bg-red-50
                                                   text-red-700
                                                   border border-red-200
                                                   text-xs font-semibold"
                                        >

                                            <span
                                                class="w-2 h-2 rounded-full
                                                       bg-red-500"
                                            ></span>

                                            Nonaktif

                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>



                        {{-- =================================================
                            SAVE BUTTON
                        ================================================== --}}

                        <div
                            class="flex justify-end pt-5 mt-5
                                   border-t border-slate-200"
                        >

                            <button
                                type="submit"
                                class="inline-flex items-center gap-2
                                       px-6 py-2.5
                                       bg-blue-600 text-white
                                       text-xs font-semibold
                                       rounded-lg
                                       hover:bg-blue-700
                                       transition-colors"
                            >

                                <span
                                    class="material-symbols-outlined
                                           text-[18px]"
                                >
                                    save
                                </span>

                                Simpan Perubahan

                            </button>

                        </div>

                    </form>

                </div>

            </section>



            {{-- =================================================
                KEAMANAN
            ================================================== --}}

            <section
                id="keamanan"
                class="bg-white border border-slate-200
                       rounded-xl p-6 flex flex-col gap-6
                       shadow-sm"
            >

                {{-- HEADER --}}

                <div class="border-b border-slate-200 pb-4">

                    <h3
                        class="text-xl font-semibold text-slate-900
                               flex items-center gap-2"
                    >

                        <span class="material-symbols-outlined text-red-600">
                            lock
                        </span>

                        Keamanan

                    </h3>

                    <p class="text-xs text-slate-500 mt-1">
                        Perbarui password untuk menjaga keamanan akun Anda.
                    </p>

                </div>



                {{-- PASSWORD FORM --}}

                <form
                    action="{{ route('user.settings.password') }}"
                    method="POST"
                    class="max-w-md"
                >

                    @csrf


                    <div class="flex flex-col gap-5">


                        {{-- PASSWORD LAMA --}}

                        <div class="flex flex-col gap-1">

                            <label
                                class="text-xs font-semibold
                                       text-slate-600"
                            >
                                Password Lama
                            </label>

                            <div class="relative">

                                <input
                                    id="current_password"
                                    type="password"
                                    name="current_password"
                                    placeholder="Masukkan password lama"
                                    required
                                    class="w-full pl-4 pr-12 py-2.5
                                           bg-white rounded-lg
                                           border border-slate-300
                                           focus:border-blue-600
                                           focus:ring-1
                                           focus:ring-blue-600
                                           text-sm outline-none
                                           transition-all"
                                >

                                <button
                                    type="button"
                                    onclick="togglePassword(
                                        'current_password',
                                        this
                                    )"
                                    class="absolute right-3
                                           top-1/2
                                           -translate-y-1/2
                                           text-slate-400
                                           hover:text-slate-700"
                                >

                                    <span
                                        class="material-symbols-outlined
                                               text-[20px]"
                                    >
                                        visibility_off
                                    </span>

                                </button>

                            </div>

                            @error('current_password')

                                <span class="text-xs text-red-600">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>



                        {{-- PASSWORD BARU --}}

                        <div class="flex flex-col gap-1">

                            <label
                                class="text-xs font-semibold
                                       text-slate-600"
                            >
                                Password Baru
                            </label>

                            <div class="relative">

                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    placeholder="Masukkan password baru"
                                    required
                                    class="w-full pl-4 pr-12 py-2.5
                                           bg-white rounded-lg
                                           border border-slate-300
                                           focus:border-blue-600
                                           focus:ring-1
                                           focus:ring-blue-600
                                           text-sm outline-none
                                           transition-all"
                                >

                                <button
                                    type="button"
                                    onclick="togglePassword(
                                        'password',
                                        this
                                    )"
                                    class="absolute right-3
                                           top-1/2
                                           -translate-y-1/2
                                           text-slate-400
                                           hover:text-slate-700"
                                >

                                    <span
                                        class="material-symbols-outlined
                                               text-[20px]"
                                    >
                                        visibility_off
                                    </span>

                                </button>

                            </div>

                            <span class="text-[10px] text-slate-400">
                                Minimal 8 karakter.
                            </span>

                            @error('password')

                                <span class="text-xs text-red-600">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>



                        {{-- KONFIRMASI PASSWORD --}}

                        <div class="flex flex-col gap-1">

                            <label
                                class="text-xs font-semibold
                                       text-slate-600"
                            >
                                Konfirmasi Password Baru
                            </label>

                            <div class="relative">

                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Ulangi password baru"
                                    required
                                    class="w-full pl-4 pr-12 py-2.5
                                           bg-white rounded-lg
                                           border border-slate-300
                                           focus:border-blue-600
                                           focus:ring-1
                                           focus:ring-blue-600
                                           text-sm outline-none
                                           transition-all"
                                >

                                <button
                                    type="button"
                                    onclick="togglePassword(
                                        'password_confirmation',
                                        this
                                    )"
                                    class="absolute right-3
                                           top-1/2
                                           -translate-y-1/2
                                           text-slate-400
                                           hover:text-slate-700"
                                >

                                    <span
                                        class="material-symbols-outlined
                                               text-[20px]"
                                    >
                                        visibility_off
                                    </span>

                                </button>

                            </div>

                        </div>

                    </div>



                    {{-- PASSWORD BUTTON --}}

                    <div
                        class="flex justify-start pt-5 mt-5
                               border-t border-slate-200"
                    >

                        <button
                            type="submit"
                            class="inline-flex items-center gap-2
                                   px-5 py-2.5
                                   bg-white text-slate-800
                                   border border-slate-400
                                   text-xs font-semibold
                                   rounded-lg
                                   hover:bg-slate-50
                                   transition-colors"
                        >

                            <span
                                class="material-symbols-outlined
                                       text-[18px]"
                            >
                                key
                            </span>

                            Perbarui Password

                        </button>

                    </div>

                </form>

            </section>



            {{-- =================================================
                PREFERENSI
            ================================================== --}}

            <section
                id="preferensi"
                class="bg-white border border-slate-200
                       rounded-xl p-6 flex flex-col gap-6
                       shadow-sm"
            >

                {{-- HEADER --}}

                <div class="border-b border-slate-200 pb-4">

                    <h3
                        class="text-xl font-semibold text-slate-900
                               flex items-center gap-2"
                    >

                        <span class="material-symbols-outlined text-blue-600">
                            tune
                        </span>

                        Preferensi

                    </h3>

                    <p class="text-xs text-slate-500 mt-1">
                        Pengaturan tampilan dan notifikasi akun.
                    </p>

                </div>



                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">


                    {{-- =================================================
                        NOTIFIKASI
                    ================================================== --}}

                    <div class="flex flex-col gap-4">

                        <h4
                            class="text-xs font-semibold text-slate-500
                                   uppercase tracking-wider"
                        >
                            Pengaturan Notifikasi
                        </h4>


                        {{-- EMAIL --}}

                        <div
                            class="flex items-center justify-between
                                   p-4 border border-slate-200
                                   rounded-lg"
                        >

                            <div class="flex items-center gap-3">

                                <div
                                    class="p-2 bg-blue-50 rounded
                                           text-blue-600"
                                >

                                    <span
                                        class="material-symbols-outlined
                                               text-[18px]"
                                    >
                                        mail
                                    </span>

                                </div>

                                <div>

                                    <p class="text-sm font-medium text-slate-800">
                                        Notifikasi Email
                                    </p>

                                    <p class="text-[11px] text-slate-400">
                                        Pengaturan notifikasi email.
                                    </p>

                                </div>

                            </div>


                            <div
                                class="relative inline-block
                                       w-10 h-5 opacity-50"
                                title="Fitur notifikasi belum tersedia"
                            >

                                <div
                                    class="absolute inset-0 rounded-full
                                           bg-slate-200"
                                ></div>

                                <div
                                    class="absolute left-0.5 top-0.5
                                           w-4 h-4 rounded-full
                                           bg-white shadow"
                                ></div>

                            </div>

                        </div>



                        {{-- DESKTOP --}}

                        <div
                            class="flex items-center justify-between
                                   p-4 border border-slate-200
                                   rounded-lg"
                        >

                            <div class="flex items-center gap-3">

                                <div
                                    class="p-2 bg-blue-50 rounded
                                           text-blue-600"
                                >

                                    <span
                                        class="material-symbols-outlined
                                               text-[18px]"
                                    >
                                        desktop_windows
                                    </span>

                                </div>

                                <div>

                                    <p class="text-sm font-medium text-slate-800">
                                        Notifikasi Desktop
                                    </p>

                                    <p class="text-[11px] text-slate-400">
                                        Pengaturan peringatan desktop.
                                    </p>

                                </div>

                            </div>


                            <div
                                class="relative inline-block
                                       w-10 h-5 opacity-50"
                                title="Fitur notifikasi belum tersedia"
                            >

                                <div
                                    class="absolute inset-0 rounded-full
                                           bg-slate-200"
                                ></div>

                                <div
                                    class="absolute left-0.5 top-0.5
                                           w-4 h-4 rounded-full
                                           bg-white shadow"
                                ></div>

                            </div>

                        </div>

                    </div>



                    {{-- =================================================
                        MODE TAMPILAN
                    ================================================== --}}

                    <div class="flex flex-col gap-4">

                        <h4
                            class="text-xs font-semibold text-slate-500
                                   uppercase tracking-wider"
                        >
                            Mode Tampilan
                        </h4>


                        <div class="grid grid-cols-2 gap-4">


                            {{-- LIGHT --}}

                            <div
                                class="border-2 border-blue-600
                                       bg-blue-50 rounded-lg p-3
                                       flex flex-col items-center gap-3"
                            >

                                <div
                                    class="w-full h-20 bg-white
                                           border border-slate-200
                                           rounded shadow-sm
                                           flex flex-col p-2 gap-1"
                                >

                                    <div
                                        class="w-full h-3
                                               bg-slate-100 rounded"
                                    ></div>

                                    <div
                                        class="w-1/2 h-2
                                               bg-slate-100 rounded"
                                    ></div>

                                    <div
                                        class="w-3/4 h-2
                                               bg-slate-100 rounded"
                                    ></div>

                                </div>

                                <span
                                    class="text-xs font-semibold
                                           text-slate-800
                                           flex items-center gap-1"
                                >

                                    <span
                                        class="material-symbols-outlined
                                               text-[16px]"
                                    >
                                        light_mode
                                    </span>

                                    Terang

                                </span>

                            </div>



                            {{-- DARK --}}

                            <div
                                class="border-2 border-slate-200
                                       rounded-lg p-3
                                       flex flex-col items-center
                                       gap-3 opacity-50
                                       cursor-not-allowed"
                                title="Mode gelap belum tersedia"
                            >

                                <div
                                    class="w-full h-20 bg-slate-900
                                           border border-slate-700
                                           rounded shadow-sm
                                           flex flex-col p-2 gap-1"
                                >

                                    <div
                                        class="w-full h-3
                                               bg-slate-700 rounded"
                                    ></div>

                                    <div
                                        class="w-1/2 h-2
                                               bg-slate-700 rounded"
                                    ></div>

                                    <div
                                        class="w-3/4 h-2
                                               bg-slate-700 rounded"
                                    ></div>

                                </div>

                                <span
                                    class="text-xs font-semibold
                                           text-slate-800
                                           flex items-center gap-1"
                                >

                                    <span
                                        class="material-symbols-outlined
                                               text-[16px]"
                                    >
                                        dark_mode
                                    </span>

                                    Gelap

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </section>


        </div>

    </div>

</div>



{{-- =========================================================
    PASSWORD TOGGLE
========================================================== --}}

<script>

    function togglePassword(inputId, button) {

        const input = document.getElementById(inputId);

        const icon = button.querySelector(
            '.material-symbols-outlined'
        );


        if (input.type === 'password') {

            input.type = 'text';

            icon.textContent = 'visibility';

        } else {

            input.type = 'password';

            icon.textContent = 'visibility_off';

        }

    }

</script>

@endsection