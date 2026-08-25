@extends('layouts.admin')

@section('title', 'SIP-PANDU | Edit Nasabah')

@section('breadcrumb')

<a
    href="{{ route('admin.dashboard') }}"
    class="text-sm text-on-surface-variant hover:text-primary transition-colors"
>
    Beranda
</a>

<span class="material-symbols-outlined text-[16px]">
    chevron_right
</span>

<a
    href="{{ route('admin.nasabah.index') }}"
    class="text-sm text-on-surface-variant hover:text-primary transition-colors"
>
    Data Nasabah
</a>

<span class="material-symbols-outlined text-[16px]">
    chevron_right
</span>

<span class="text-sm text-primary font-medium">
    Edit Nasabah
</span>

@endsection

@section('content')

<div class="mb-6">

    <h1 class="text-2xl font-semibold text-on-surface mb-1">
        Edit Data Nasabah
    </h1>

    <p class="text-sm text-on-surface-variant">
        Perbarui nomor nasabah, nama lengkap, dan lokasi arsip fisik.
    </p>

</div>


{{-- =========================================================
ALERT VALIDATION
========================================================== --}}

@if ($errors->any())

    <div class="mb-6 px-4 py-3 rounded-lg border bg-error-container border-error/30 text-on-error-container">

        <div class="flex items-start gap-3">

            <span class="material-symbols-outlined text-[20px]">
                error
            </span>

            <div>

                <p class="font-semibold text-sm mb-1">
                    Terdapat kesalahan pada data.
                </p>

                <ul class="list-disc list-inside text-xs space-y-1">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        </div>

    </div>

@endif


{{-- =========================================================
FORM
========================================================== --}}

<form
    action="{{ route('admin.nasabah.update', $nasabah->id) }}"
    method="POST"
    class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start"
>

    @csrf
    @method('PUT')


    {{-- =====================================================
    INFORMASI NASABAH
    ====================================================== --}}

    <div class="lg:col-span-8">

        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">

            <div class="flex items-center gap-2 mb-6 pb-4 border-b border-outline-variant">

                <span class="material-symbols-outlined text-primary">
                    person
                </span>

                <h2 class="text-lg font-semibold text-on-surface">
                    Informasi Nasabah
                </h2>

            </div>


            <div class="space-y-5">


                {{-- =================================================
                NOMOR NASABAH
                ================================================== --}}

                <div>

                    <label
                        for="nomor_nasabah"
                        class="block text-xs font-semibold text-on-surface mb-2"
                    >
                        Nomor Nasabah
                        <span class="text-error">*</span>
                    </label>

                    <input
                        id="nomor_nasabah"
                        name="nomor_nasabah"
                        type="text"
                        value="{{ old('nomor_nasabah', $nasabah->nomor_nasabah) }}"
                        maxlength="50"
                        required
                        autocomplete="off"
                        class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2.5 text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                    >

                    @error('nomor_nasabah')

                        <p class="mt-1.5 text-xs text-error">
                            {{ $message }}
                        </p>

                    @enderror

                    <p class="mt-1.5 text-xs text-on-surface-variant">
                        Nomor identitas nasabah yang digunakan dalam sistem.
                    </p>

                </div>


                {{-- =================================================
                NAMA LENGKAP
                ================================================== --}}

                <div>

                    <label
                        for="nama"
                        class="block text-xs font-semibold text-on-surface mb-2"
                    >
                        Nama Lengkap
                        <span class="text-error">*</span>
                    </label>

                    <input
                        id="nama"
                        name="nama"
                        type="text"
                        value="{{ old('nama', $nasabah->nama) }}"
                        maxlength="255"
                        required
                        autocomplete="off"
                        class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2.5 text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                    >

                    @error('nama')

                        <p class="mt-1.5 text-xs text-error">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- =================================================
                INFO STATUS
                ================================================== --}}

                <div class="rounded-lg bg-surface-container-low border border-outline-variant p-4">

                    <div class="flex items-start gap-3">

                        <span class="material-symbols-outlined text-secondary text-[20px]">
                            info
                        </span>

                        <div>

                            <p class="text-sm font-semibold text-on-surface">
                                Status Nasabah
                            </p>

                            <p class="mt-1 text-xs leading-5 text-on-surface-variant">
                                Status nasabah saat ini:
                                <span class="font-semibold text-on-surface">
                                    {{ $nasabah->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}
                                </span>.
                            </p>

                            <p class="mt-1 text-xs leading-5 text-on-surface-variant">
                                Status tidak diubah melalui halaman edit ini.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
    LOKASI ARSIP
    ====================================================== --}}

    <div class="lg:col-span-4">

        @php
            $lokasi = $nasabah->lokasiArsip;
        @endphp

        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm lg:sticky lg:top-[88px]">


            {{-- HEADER --}}

            <div class="flex items-center gap-2 mb-6 pb-4 border-b border-outline-variant">

                <span class="material-symbols-outlined text-primary">
                    folder_open
                </span>

                <h2 class="text-lg font-semibold text-on-surface">
                    Lokasi Arsip Fisik
                </h2>

            </div>


            <div class="space-y-5">


                {{-- =================================================
                RAK
                ================================================== --}}

                <div>

                    <label
                        for="rak"
                        class="block text-xs font-semibold text-on-surface mb-2"
                    >
                        Rak
                    </label>

                    <input
                        id="rak"
                        name="rak"
                        type="text"
                        value="{{ old('rak', $lokasi?->rak) }}"
                        maxlength="50"
                        placeholder="Contoh: C"
                        class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2.5 text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                    >

                    @error('rak')

                        <p class="mt-1.5 text-xs text-error">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- =================================================
                NOMOR MAP
                ================================================== --}}

                <div>

                    <label
                        for="nomor_map"
                        class="block text-xs font-semibold text-on-surface mb-2"
                    >
                        Nomor Map
                    </label>

                    <input
                        id="nomor_map"
                        name="nomor_map"
                        type="text"
                        value="{{ old('nomor_map', $lokasi?->nomor_map) }}"
                        maxlength="50"
                        placeholder="Contoh: 030"
                        class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2.5 text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                    >

                    @error('nomor_map')

                        <p class="mt-1.5 text-xs text-error">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- =================================================
                POSISI
                ================================================== --}}

                <div>

                    <label
                        for="posisi"
                        class="block text-xs font-semibold text-on-surface mb-2"
                    >
                        Posisi
                    </label>

                    <input
                        id="posisi"
                        name="posisi"
                        type="text"
                        value="{{ old('posisi', $lokasi?->posisi) }}"
                        maxlength="100"
                        placeholder="Contoh: 05"
                        class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2.5 text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                    >

                    @error('posisi')

                        <p class="mt-1.5 text-xs text-error">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

            </div>


            {{-- INFO --}}

            <div class="mt-5 p-3 rounded-lg bg-surface-container-low border border-outline-variant">

                <div class="flex items-start gap-2">

                    <span class="material-symbols-outlined text-secondary text-[18px]">
                        info
                    </span>

                    <p class="text-xs text-on-surface-variant leading-5">
                        Lokasi arsip digunakan untuk membantu petugas
                        menemukan dokumen fisik nasabah.
                    </p>

                </div>

            </div>


            {{-- =================================================
            ACTION
            ================================================== --}}

            <div class="mt-6 pt-5 border-t border-outline-variant flex flex-col sm:flex-row lg:flex-col gap-3">

                <a
                    href="{{ route('admin.nasabah.show', $nasabah->id) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-2.5 text-sm font-medium text-secondary hover:bg-surface-container-low transition-colors"
                >

                    <span class="material-symbols-outlined text-[18px]">
                        arrow_back
                    </span>

                    Batal

                </a>


                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary-container px-4 py-2.5 text-sm font-semibold text-white hover:bg-primary transition-colors shadow-sm"
                >

                    <span class="material-symbols-outlined text-[18px]">
                        save
                    </span>

                    Simpan Perubahan

                </button>

            </div>

        </div>

    </div>

</form>

@endsection