@extends('layouts.admin')

@section('title', 'SIP-PANDU | Pengaturan Sistem')

@section('breadcrumb')
<a
    href="{{ route('admin.dashboard') }}"
    class="text-sm text-on-surface-variant hover:text-primary transition-colors font-medium"
>
    Beranda
</a>
<span class="material-symbols-outlined text-[16px] text-on-surface-variant">
    chevron_right
</span>
<span class="text-sm font-medium text-primary">
    Pengaturan Sistem
</span>
@endsection

@section('content')

{{-- ALERT SESSION NOTIFICATIONS --}}
@if (session('success'))
    <div class="mb-6 px-4 py-3 rounded-lg text-sm bg-green-50 text-green-700 border border-green-200 font-medium shadow-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-[20px]">check_circle</span>
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-6 px-4 py-3 rounded-lg text-sm bg-red-50 text-red-700 border border-red-200 font-medium shadow-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-[20px]">error</span>
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 px-4 py-3 rounded-lg text-sm bg-red-50 text-red-700 border border-red-200 font-medium shadow-sm space-y-1">
        @foreach ($errors->all() as $error)
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">error</span>
                <span>{{ $error }}</span>
            </div>
        @endforeach
    </div>
@endif

<div id="alertJsMessage" class="hidden mb-6 px-4 py-3 rounded-lg text-sm border font-medium"></div>

{{-- PAGE CONTENT --}}
<div class="max-w-5xl mx-auto">
    
    <h2 class="font-display-lg text-headline-md sm:text-display-lg font-bold text-on-surface mb-8">
        Pengaturan Sistem
    </h2>

    <div class="flex flex-col md:flex-row gap-8">
        
        {{-- VERTICAL TABS NAVIGATION --}}
        <div class="w-full md:w-64 flex-shrink-0">
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant p-2 flex flex-col gap-1 shadow-sm">
                
                <button
                    type="button"
                    onclick="switchTab('profile')"
                    id="tab-btn-profile"
                    class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left text-primary font-semibold bg-surface-container-low transition-all"
                >
                    <span class="material-symbols-outlined text-[20px]">person</span>
                    Profil Saya
                </button>

                <button
                    type="button"
                    onclick="switchTab('general')"
                    id="tab-btn-general"
                    class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left text-on-surface-variant hover:bg-surface-container transition-all"
                >
                    <span class="material-symbols-outlined text-[20px]">tune</span>
                    Pengaturan Umum
                </button>

                <button
                    type="button"
                    onclick="switchTab('security')"
                    id="tab-btn-security"
                    class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left text-on-surface-variant hover:bg-surface-container transition-all"
                >
                    <span class="material-symbols-outlined text-[20px]">security</span>
                    Keamanan
                </button>

                <button
                    type="button"
                    onclick="switchTab('info')"
                    id="tab-btn-info"
                    class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left text-on-surface-variant hover:bg-surface-container transition-all"
                >
                    <span class="material-symbols-outlined text-[20px]">info</span>
                    Informasi Aplikasi
                </button>

            </div>
        </div>

        {{-- TAB CONTENT AREA --}}
        <div class="flex-grow">

            {{-- 1. TAB PROFIL SAYA --}}
            <div id="tab-content-profile" class="tab-content bg-surface-container-lowest rounded-xl border border-outline-variant p-6 sm:p-8 shadow-sm">
                <h3 class="font-title-sm text-title-sm font-semibold text-on-surface border-b border-outline-variant pb-4 mb-6">
                    Profil Saya
                </h3>

                <form action="{{ route('admin.settings.profile') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
                    @csrf

                    {{-- AVATAR DISPLAY & UPLOAD --}}
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 mb-2">
                        @if ($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar))
                            <img
                                src="{{ asset('storage/' . $user->avatar) }}"
                                alt="Foto Profil"
                                class="w-20 h-20 sm:w-24 sm:h-24 rounded-full object-cover border border-outline-variant shadow-sm flex-shrink-0"
                            />
                        @else
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-2xl border border-outline-variant shadow-sm flex-shrink-0">
                                {{ strtoupper(substr($user->name ?? 'AD', 0, 2)) }}
                            </div>
                        @endif

                        <div>
                            <input
                                type="file"
                                id="avatarFileInput"
                                name="avatar"
                                accept="image/*"
                                class="hidden"
                                onchange="document.getElementById('avatarFileName').textContent = this.files[0] ? this.files[0].name : '';"
                            />
                            <button
                                type="button"
                                onclick="document.getElementById('avatarFileInput').click()"
                                class="bg-surface-container hover:bg-surface-container-high text-on-surface font-label-md px-4 py-2 rounded-lg border border-outline-variant transition-colors mb-1 text-xs font-medium inline-flex items-center gap-1.5"
                            >
                                <span class="material-symbols-outlined text-[16px]">upload</span>
                                Unggah Foto Baru
                            </button>
                            <p id="avatarFileName" class="text-xs text-primary font-medium mb-1"></p>
                            <p class="font-body-sm text-body-sm text-on-surface-variant text-xs">
                                JPG, PNG atau GIF. Maksimal 2MB.
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- NAMA LENGKAP --}}
                        <div class="flex flex-col gap-2">
                            <label class="font-label-md text-xs font-semibold text-on-surface uppercase tracking-wider">
                                Nama Lengkap <span class="text-error">*</span>
                            </label>
                            <input
                                type="text"
                                name="name"
                                required
                                value="{{ old('name', $user->name ?? '') }}"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-outline-variant bg-surface text-sm text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all font-body-md"
                            />
                        </div>

                        {{-- EMAIL --}}
                        <div class="flex flex-col gap-2">
                            <label class="font-label-md text-xs font-semibold text-on-surface uppercase tracking-wider">
                                Email <span class="text-error">*</span>
                            </label>
                            <input
                                type="email"
                                name="email"
                                required
                                value="{{ old('email', $user->email ?? '') }}"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-outline-variant bg-surface text-sm text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all font-body-md"
                            />
                        </div>

                        {{-- PERAN (DISABLED) --}}
                        <div class="flex flex-col gap-2 md:col-span-2">
                            <label class="font-label-md text-xs font-semibold text-on-surface uppercase tracking-wider">
                                Peran Akun
                            </label>
                            <input
                                type="text"
                                disabled
                                value="{{ ucfirst($user->role ?? 'Admin') }}"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-outline-variant bg-surface-container text-on-surface-variant cursor-not-allowed font-body-md text-sm font-medium"
                            />
                        </div>

                    </div>

                    <div class="flex justify-end mt-4 pt-4 border-t border-outline-variant">
                        <button
                            type="submit"
                            class="bg-primary-container text-on-primary hover:bg-primary font-label-md px-6 py-2.5 rounded-lg transition-colors text-xs font-medium shadow-sm inline-flex items-center gap-2"
                        >
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- 2. TAB PENGATURAN UMUM --}}
            <div id="tab-content-general" class="tab-content hidden bg-surface-container-lowest rounded-xl border border-outline-variant p-6 sm:p-8 shadow-sm">
                <h3 class="font-title-sm text-title-sm font-semibold text-on-surface border-b border-outline-variant pb-4 mb-6">
                    Pengaturan Umum Sistem
                </h3>

                <form action="{{ route('admin.settings.general') }}" method="POST" class="flex flex-col gap-6">
                    @csrf

                    <div class="space-y-4">
                        
                        <div>
                            <label class="block text-xs font-semibold text-on-surface uppercase tracking-wider mb-2">
                                Nama Sistem / Aplikasi <span class="text-error">*</span>
                            </label>
                            <input
                                type="text"
                                name="app_name"
                                required
                                value="{{ old('app_name', $generalSettings['app_name']) }}"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-outline-variant bg-surface text-sm text-on-surface focus:ring-2 focus:ring-primary outline-none"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-on-surface uppercase tracking-wider mb-2">
                                Deskripsi Sistem
                            </label>
                            <textarea
                                name="app_description"
                                rows="3"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-outline-variant bg-surface text-sm text-on-surface focus:ring-2 focus:ring-primary outline-none resize-none"
                            >{{ old('app_description', $generalSettings['app_description']) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-on-surface uppercase tracking-wider mb-2">
                                    Maksimal Ukuran Upload Dokumen (MB) <span class="text-error">*</span>
                                </label>
                                <select
                                    name="max_file_size"
                                    class="w-full px-3.5 py-2.5 rounded-lg border border-outline-variant bg-surface text-sm text-on-surface focus:ring-2 focus:ring-primary outline-none"
                                >
                                    <option value="5" {{ $generalSettings['max_file_size'] == '5' ? 'selected' : '' }}>5 MB</option>
                                    <option value="10" {{ $generalSettings['max_file_size'] == '10' ? 'selected' : '' }}>10 MB</option>
                                    <option value="25" {{ $generalSettings['max_file_size'] == '25' ? 'selected' : '' }}>25 MB</option>
                                    <option value="50" {{ $generalSettings['max_file_size'] == '50' ? 'selected' : '' }}>50 MB</option>
                                    <option value="100" {{ $generalSettings['max_file_size'] == '100' ? 'selected' : '' }}>100 MB</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-on-surface uppercase tracking-wider mb-2">
                                    Ekstensi File Diizinkan <span class="text-error">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="allowed_file_types"
                                    required
                                    value="{{ old('allowed_file_types', $generalSettings['allowed_file_types']) }}"
                                    class="w-full px-3.5 py-2.5 rounded-lg border border-outline-variant bg-surface text-sm text-on-surface focus:ring-2 focus:ring-primary outline-none"
                                />
                            </div>
                        </div>

                    </div>

                    <div class="flex justify-end mt-4 pt-4 border-t border-outline-variant">
                        <button
                            type="submit"
                            class="bg-primary-container text-on-primary hover:bg-primary font-label-md px-6 py-2.5 rounded-lg transition-colors text-xs font-medium shadow-sm inline-flex items-center gap-2"
                        >
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            Simpan Pengaturan Umum
                        </button>
                    </div>
                </form>
            </div>

            {{-- 3. TAB KEAMANAN --}}
            <div id="tab-content-security" class="tab-content hidden bg-surface-container-lowest rounded-xl border border-outline-variant p-6 sm:p-8 shadow-sm">
                <h3 class="font-title-sm text-title-sm font-semibold text-on-surface border-b border-outline-variant pb-4 mb-6">
                    Keamanan & Kata Sandi
                </h3>

                <form action="{{ route('admin.settings.password') }}" method="POST" class="flex flex-col gap-6">
                    @csrf

                    <div class="space-y-4 max-w-lg">
                        
                        <div>
                            <label class="block text-xs font-semibold text-on-surface uppercase tracking-wider mb-2">
                                Password Saat Ini <span class="text-error">*</span>
                            </label>
                            <input
                                type="password"
                                name="current_password"
                                required
                                placeholder="Masukkan password saat ini"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-outline-variant bg-surface text-sm text-on-surface focus:ring-2 focus:ring-primary outline-none"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-on-surface uppercase tracking-wider mb-2">
                                Password Baru <span class="text-error">*</span>
                            </label>
                            <input
                                type="password"
                                name="password"
                                required
                                minlength="8"
                                placeholder="Minimal 8 karakter"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-outline-variant bg-surface text-sm text-on-surface focus:ring-2 focus:ring-primary outline-none"
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-on-surface uppercase tracking-wider mb-2">
                                Konfirmasi Password Baru <span class="text-error">*</span>
                            </label>
                            <input
                                type="password"
                                name="password_confirmation"
                                required
                                minlength="8"
                                placeholder="Ulangi password baru"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-outline-variant bg-surface text-sm text-on-surface focus:ring-2 focus:ring-primary outline-none"
                            />
                        </div>

                    </div>

                    <div class="flex justify-end mt-4 pt-4 border-t border-outline-variant">
                        <button
                            type="submit"
                            class="bg-primary-container text-on-primary hover:bg-primary font-label-md px-6 py-2.5 rounded-lg transition-colors text-xs font-medium shadow-sm inline-flex items-center gap-2"
                        >
                            <span class="material-symbols-outlined text-[18px]">lock_reset</span>
                            Perbarui Password
                        </button>
                    </div>
                </form>
            </div>

            {{-- 4. TAB INFORMASI APLIKASI --}}
            <div id="tab-content-info" class="tab-content hidden bg-surface-container-lowest rounded-xl border border-outline-variant p-6 sm:p-8 shadow-sm">
                <h3 class="font-title-sm text-title-sm font-semibold text-on-surface border-b border-outline-variant pb-4 mb-6">
                    Informasi Sistem & Statistik Real-Time
                </h3>

                <div class="space-y-4 text-sm text-on-surface">
                    
                    <div class="flex justify-between items-center py-2.5 border-b border-outline-variant/60">
                        <span class="text-on-surface-variant font-medium">Nama Sistem</span>
                        <span class="font-semibold text-primary">{{ $appInfo['app_name'] }} (DMS Edition)</span>
                    </div>

                    <div class="flex justify-between items-center py-2.5 border-b border-outline-variant/60">
                        <span class="text-on-surface-variant font-medium">Versi Aplikasi</span>
                        <span class="font-mono text-xs bg-surface-container px-2.5 py-1 rounded border border-outline-variant font-bold text-on-surface">v1.2.0</span>
                    </div>

                    <div class="flex justify-between items-center py-2.5 border-b border-outline-variant/60">
                        <span class="text-on-surface-variant font-medium">Framework Engine</span>
                        <span class="font-medium text-on-surface">Laravel {{ $appInfo['laravel_version'] }} (PHP {{ $appInfo['php_version'] }})</span>
                    </div>

                    <div class="flex justify-between items-center py-2.5 border-b border-outline-variant/60">
                        <span class="text-on-surface-variant font-medium">Database Backend Engine</span>
                        <span class="font-medium text-on-surface">{{ $appInfo['db_driver'] }}</span>
                    </div>

                    <div class="flex justify-between items-center py-2.5 border-b border-outline-variant/60">
                        <span class="text-on-surface-variant font-medium">Total Nasabah Terdaftar</span>
                        <span class="font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded border border-emerald-200 text-xs">{{ number_format($appInfo['total_nasabah']) }} Nasabah</span>
                    </div>

                    <div class="flex justify-between items-center py-2.5 border-b border-outline-variant/60">
                        <span class="text-on-surface-variant font-medium">Total Dokumen Tersimpan</span>
                        <span class="font-semibold text-primary bg-primary/10 px-2.5 py-0.5 rounded border border-primary/20 text-xs">{{ number_format($appInfo['total_dokumen']) }} Dokumen</span>
                    </div>

                    <div class="flex justify-between items-center py-2.5">
                        <span class="text-on-surface-variant font-medium">Hak Cipta</span>
                        <span class="text-xs text-on-surface-variant font-medium">© 2026 PT. Bank Pengkreditan Rakyat / {{ $appInfo['app_name'] }} System</span>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
    /*
    |--------------------------------------------------------------------------
    | TAB SWITCHER LOGIC
    |--------------------------------------------------------------------------
    */
    function switchTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });

        // Reset button styles
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('text-primary', 'font-semibold', 'bg-surface-container-low');
            btn.classList.add('text-on-surface-variant', 'hover:bg-surface-container');
        });

        // Show active content
        const activeContent = document.getElementById(`tab-content-${tabName}`);
        if (activeContent) {
            activeContent.classList.remove('hidden');
        }

        // Highlight active button
        const activeBtn = document.getElementById(`tab-btn-${tabName}`);
        if (activeBtn) {
            activeBtn.classList.remove('text-on-surface-variant', 'hover:bg-surface-container');
            activeBtn.classList.add('text-primary', 'font-semibold', 'bg-surface-container-low');
        }
    }

    // Auto switch tab if validation error exists on password
    @if ($errors->has('current_password') || $errors->has('password'))
        switchTab('security');
    @endif
</script>
@endpush
