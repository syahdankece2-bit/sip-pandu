@extends('layouts.user')

@section('title', 'Detail Nasabah')

@section('content')

<div class="p-6 md:p-8">

    {{-- ========================================================= --}}
    {{-- FLASH MESSAGE --}}
    {{-- ========================================================= --}}

    @if (session('success'))

        <div class="max-w-[1200px] mx-auto mb-6">

            <div class="flex items-center gap-3
                        px-4 py-3
                        bg-green-50
                        border border-green-200
                        rounded-lg
                        text-green-700">

                <span class="material-symbols-outlined text-[20px]">
                    check_circle
                </span>

                <div>

                    <p class="text-sm font-semibold">
                        Berhasil
                    </p>

                    <p class="text-xs mt-0.5">
                        {{ session('success') }}
                    </p>

                </div>

            </div>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- VALIDATION ERROR --}}
    {{-- ========================================================= --}}

    @if ($errors->any())

        <div class="max-w-[1200px] mx-auto mb-6">

            <div class="px-4 py-3
                        bg-red-50
                        border border-red-200
                        rounded-lg
                        text-red-700">

                <div class="flex items-start gap-3">

                    <span class="material-symbols-outlined text-[20px]">
                        error
                    </span>

                    <div>

                        <p class="text-sm font-semibold">
                            Terjadi kesalahan
                        </p>

                        <ul class="mt-1 text-xs list-disc list-inside space-y-1">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- BREADCRUMB --}}
    {{-- ========================================================= --}}

    <div class="max-w-[1200px] mx-auto">

        <div class="flex items-center gap-2 text-sm text-slate-500 mb-6">

            {{-- Dashboard --}}
            <a
                href="{{ route('user.dashboard') }}"
                class="hover:text-blue-600 flex items-center transition-colors"
                title="Dashboard"
            >

                <span class="material-symbols-outlined text-[18px]">
                    home
                </span>

            </a>


            <span class="material-symbols-outlined text-[16px]">
                chevron_right
            </span>


            {{-- Data Nasabah --}}
            <a
                href="{{ route('user.nasabah.index') }}"
                class="hover:text-blue-600 transition-colors"
            >
                Data Nasabah
            </a>


            <span class="material-symbols-outlined text-[16px]">
                chevron_right
            </span>


            {{-- Current --}}
            <span class="text-slate-900 font-medium truncate max-w-[220px]">
                {{ $nasabah->nama }}
            </span>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================================================= --}}

    <div class="flex flex-col gap-6 max-w-[1200px] mx-auto">


        {{-- ===================================================== --}}
        {{-- INFORMASI NASABAH + LOKASI ARSIP --}}
        {{-- ===================================================== --}}

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">


            {{-- ================================================= --}}
            {{-- INFORMASI NASABAH --}}
            {{-- ================================================= --}}

            <div class="md:col-span-2 bg-white border border-slate-200 rounded-lg p-6">

                <div class="flex justify-between items-start gap-4">

                    {{-- Informasi Utama --}}
                    <div class="flex items-center gap-4 min-w-0">

                        {{-- Icon --}}
                        <div class="w-16 h-16 shrink-0 rounded-lg
                                    bg-slate-100
                                    flex items-center justify-center
                                    text-slate-700">

                            <span class="material-symbols-outlined text-[32px]">
                                person
                            </span>

                        </div>


                        {{-- Nama dan Nomor --}}
                        <div class="min-w-0">

                            <p class="text-xs font-semibold
                                      text-slate-500
                                      uppercase
                                      tracking-wider
                                      mb-1">

                                Informasi Nasabah

                            </p>


                            <h2 class="text-2xl font-semibold
                                       text-slate-900
                                       mb-1
                                       truncate">

                                {{ $nasabah->nama }}

                            </h2>


                            <p class="font-mono text-sm text-slate-500
                                      flex items-center gap-2">

                                <span class="material-symbols-outlined text-[16px]">
                                    tag
                                </span>

                                {{ $nasabah->nomor_nasabah }}

                            </p>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- STATUS NASABAH --}}
                    {{-- ================================================= --}}

                    @if ($nasabah->status === 'aktif')

                        <div class="shrink-0 px-3 py-1
                                    bg-blue-50
                                    text-blue-700
                                    rounded
                                    text-xs
                                    font-semibold
                                    uppercase
                                    tracking-wider
                                    border border-blue-200">

                            Aktif

                        </div>

                    @else

                        <div class="shrink-0 px-3 py-1
                                    bg-red-50
                                    text-red-700
                                    rounded
                                    text-xs
                                    font-semibold
                                    uppercase
                                    tracking-wider
                                    border border-red-200">

                            Non-Aktif

                        </div>

                    @endif

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- LOKASI ARSIP --}}
            {{-- ================================================= --}}

            <div class="bg-white border border-slate-200 rounded-lg p-6
                        flex flex-col relative overflow-hidden">

                {{-- Background Icon --}}
                <div class="absolute -right-4 -top-4 opacity-5 pointer-events-none">

                    <span class="material-symbols-outlined text-[150px]">
                        shelves
                    </span>

                </div>


                {{-- Header --}}
                <h3 class="text-xs font-semibold
                           text-slate-500
                           uppercase
                           tracking-wider
                           mb-5
                           flex items-center gap-2
                           relative z-10">

                    <span class="material-symbols-outlined text-[18px]">
                        location_on
                    </span>

                    Lokasi Arsip Fisik Utama

                </h3>


                {{-- Ada Lokasi --}}
                @if ($nasabah->lokasiArsip)

                    <div class="flex flex-col relative z-10">


                        {{-- ================================================= --}}
                        {{-- RAK --}}
                        {{-- ================================================= --}}

                        <div class="flex items-center gap-4 mb-4">

                            <div class="w-12 h-12 shrink-0 rounded
                                        bg-slate-100
                                        flex items-center justify-center
                                        border border-slate-200">

                                <span class="font-bold text-xl text-slate-900">
                                    {{ $nasabah->lokasiArsip->rak }}
                                </span>

                            </div>


                            <div>

                                <p class="text-xs font-semibold
                                          text-slate-500
                                          uppercase
                                          tracking-wider">

                                    Rak

                                </p>

                                <p class="text-sm text-slate-900">

                                    {{ $nasabah->lokasiArsip->rak }}

                                </p>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- NOMOR MAP --}}
                        {{-- ================================================= --}}

                        <div class="flex items-center gap-4 mb-4">

                            <div class="w-12 h-12 shrink-0 rounded
                                        bg-slate-100
                                        flex items-center justify-center
                                        border border-slate-200">

                                <span class="font-mono text-lg text-slate-900">

                                    {{ $nasabah->lokasiArsip->nomor_map }}

                                </span>

                            </div>


                            <div>

                                <p class="text-xs font-semibold
                                          text-slate-500
                                          uppercase
                                          tracking-wider">

                                    Nomor Map

                                </p>

                                <p class="text-sm text-slate-900">

                                    {{ $nasabah->lokasiArsip->nomor_map }}

                                </p>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- POSISI --}}
                        {{-- ================================================= --}}

                        <div class="flex items-center gap-4">

                            <div class="w-12 h-12 shrink-0 rounded
                                        bg-slate-100
                                        flex items-center justify-center
                                        border border-slate-200">

                                <span class="font-mono text-lg text-slate-900">

                                    {{ $nasabah->lokasiArsip->posisi }}

                                </span>

                            </div>


                            <div>

                                <p class="text-xs font-semibold
                                          text-slate-500
                                          uppercase
                                          tracking-wider">

                                    Posisi

                                </p>

                                <p class="text-sm text-slate-900">

                                    {{ $nasabah->lokasiArsip->posisi }}

                                </p>

                            </div>

                        </div>

                    </div>


                {{-- ================================================= --}}
                {{-- TIDAK ADA LOKASI --}}
                {{-- ================================================= --}}

                @else

                    <div class="flex flex-col
                                items-center
                                justify-center
                                text-center
                                py-6
                                relative z-10">

                        <span class="material-symbols-outlined
                                     text-5xl
                                     text-slate-300">

                            location_off

                        </span>


                        <p class="mt-3 text-sm font-medium text-slate-600">

                            Lokasi arsip belum tersedia

                        </p>


                        <p class="mt-1 text-xs text-slate-400">

                            Nasabah belum memiliki lokasi arsip fisik.

                        </p>

                    </div>

                @endif

            </div>

        </div>



        {{-- ===================================================== --}}
        {{-- DOKUMEN TERKAIT --}}
        {{-- ===================================================== --}}

        <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">


            {{-- ================================================= --}}
            {{-- HEADER DOKUMEN --}}
            {{-- ================================================= --}}

            <div class="px-6 py-4
                        border-b border-slate-200
                        flex flex-col sm:flex-row
                        justify-between
                        items-start sm:items-center
                        gap-4
                        bg-slate-50">

                {{-- Judul --}}
                <div>

                    <h3 class="text-xl font-semibold text-slate-900">

                        Dokumen Terkait

                    </h3>


                    <p class="text-xs text-slate-500 mt-1">

                        Kelola dokumen digital milik nasabah.

                    </p>

                </div>


                {{-- ================================================= --}}
                {{-- TOTAL + UPLOAD --}}
                {{-- ================================================= --}}

                <div class="flex items-center gap-3">


                    {{-- Total --}}
                    <span class="px-2.5 py-1
                                 bg-slate-200
                                 text-slate-600
                                 rounded
                                 text-xs
                                 font-medium
                                 whitespace-nowrap">

                        Total:
                        {{ $nasabah->dokumen->count() }}

                    </span>


                    {{-- Upload Dokumen --}}
                    <a
                        href="{{ route('user.nasabah.dokumen.create', $nasabah) }}"
                        class="inline-flex items-center gap-2
                               px-4 py-2
                               bg-blue-600
                               text-white
                               text-sm
                               font-medium
                               rounded-md
                               hover:bg-blue-700
                               transition-colors
                               whitespace-nowrap"
                    >

                        <span class="material-symbols-outlined text-[18px]">
                            upload_file
                        </span>

                        Upload Dokumen

                    </a>

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- TABLE DOKUMEN --}}
            {{-- ================================================= --}}

            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse">


                    {{-- ================================================= --}}
                    {{-- TABLE HEADER --}}
                    {{-- ================================================= --}}

                    <thead>

                        <tr class="bg-slate-50 border-b border-slate-200">

                            <th class="py-3 px-6
                                       text-xs
                                       font-semibold
                                       text-slate-500
                                       uppercase
                                       tracking-wider
                                       w-16">

                                No

                            </th>


                            <th class="py-3 px-6
                                       text-xs
                                       font-semibold
                                       text-slate-500
                                       uppercase
                                       tracking-wider">

                                Jenis Dokumen

                            </th>


                            <th class="py-3 px-6
                                       text-xs
                                       font-semibold
                                       text-slate-500
                                       uppercase
                                       tracking-wider">

                                Nama File

                            </th>


                            <th class="py-3 px-6
                                       text-xs
                                       font-semibold
                                       text-slate-500
                                       uppercase
                                       tracking-wider">

                                Status Ketersediaan

                            </th>


                            <th class="py-3 px-6
                                       text-xs
                                       font-semibold
                                       text-slate-500
                                       uppercase
                                       tracking-wider
                                       text-right">

                                Aksi

                            </th>

                        </tr>

                    </thead>



                    {{-- ================================================= --}}
                    {{-- TABLE BODY --}}
                    {{-- ================================================= --}}

                    <tbody class="text-sm">


                        @forelse ($nasabah->dokumen as $index => $dokumen)

                            <tr class="border-b border-slate-200
                                       hover:bg-blue-50/40
                                       transition-colors">


                                {{-- ================================================= --}}
                                {{-- NO --}}
                                {{-- ================================================= --}}

                                <td class="py-4 px-6 text-slate-500">

                                    {{ $index + 1 }}

                                </td>



                                {{-- ================================================= --}}
                                {{-- JENIS DOKUMEN --}}
                                {{-- ================================================= --}}

                                <td class="py-4 px-6">

                                    <div class="font-medium text-slate-900">

                                        {{ $dokumen->jenisDokumen?->nama_dokumen ?? 'Jenis dokumen tidak tersedia' }}

                                    </div>


                                    @if ($dokumen->jenisDokumen?->deskripsi)

                                        <div class="text-xs text-slate-400 mt-1">

                                            {{ $dokumen->jenisDokumen->deskripsi }}

                                        </div>

                                    @endif

                                </td>



                                {{-- ================================================= --}}
                                {{-- NAMA FILE --}}
                                {{-- ================================================= --}}

                                <td class="py-4 px-6">

                                    @if ($dokumen->nama_file)

                                        <div class="flex items-center gap-2 min-w-[180px]">

                                            <span class="material-symbols-outlined
                                                         text-red-500
                                                         text-[18px]
                                                         shrink-0">

                                                description

                                            </span>


                                            <span
                                                class="font-mono
                                                       text-xs
                                                       text-slate-600
                                                       max-w-[240px]
                                                       truncate"
                                                title="{{ $dokumen->nama_file }}"
                                            >

                                                {{ $dokumen->nama_file }}

                                            </span>

                                        </div>

                                    @else

                                        <span class="text-xs text-slate-400 italic">

                                            Belum ada file

                                        </span>

                                    @endif

                                </td>



                                {{-- ================================================= --}}
                                {{-- STATUS KETERSEDIAAN --}}
                                {{-- ================================================= --}}

                                <td class="py-4 px-6">

                                    <div class="flex flex-wrap gap-2">


                                        {{-- STATUS FISIK --}}
                                        @if ($dokumen->status_fisik === 'tersedia')

                                            <span class="inline-flex
                                                         items-center
                                                         gap-1
                                                         px-2
                                                         py-1
                                                         bg-green-100
                                                         text-green-700
                                                         rounded
                                                         text-xs
                                                         border
                                                         border-green-200">

                                                <span class="material-symbols-outlined text-[14px]">
                                                    inventory_2
                                                </span>

                                                Fisik

                                            </span>

                                        @else

                                            <span class="inline-flex
                                                         items-center
                                                         gap-1
                                                         px-2
                                                         py-1
                                                         bg-red-100
                                                         text-red-700
                                                         rounded
                                                         text-xs
                                                         border
                                                         border-red-200">

                                                <span class="material-symbols-outlined text-[14px]">
                                                    close
                                                </span>

                                                Fisik

                                            </span>

                                        @endif



                                        {{-- STATUS DIGITAL --}}
                                        @if ($dokumen->status_digital === 'tersedia')

                                            <span class="inline-flex
                                                         items-center
                                                         gap-1
                                                         px-2
                                                         py-1
                                                         bg-green-100
                                                         text-green-700
                                                         rounded
                                                         text-xs
                                                         border
                                                         border-green-200">

                                                <span class="material-symbols-outlined text-[14px]">
                                                    cloud_done
                                                </span>

                                                Digital

                                            </span>

                                        @else

                                            <span class="inline-flex
                                                         items-center
                                                         gap-1
                                                         px-2
                                                         py-1
                                                         bg-red-100
                                                         text-red-700
                                                         rounded
                                                         text-xs
                                                         border
                                                         border-red-200">

                                                <span class="material-symbols-outlined text-[14px]">
                                                    cloud_off
                                                </span>

                                                Digital

                                            </span>

                                        @endif

                                    </div>

                                </td>



                                {{-- ================================================= --}}
                                {{-- AKSI --}}
                                {{-- ================================================= --}}

                                <td class="py-4 px-6 text-right">

                                    <div class="flex justify-end items-center gap-2">


                                        {{-- ================================================= --}}
                                        {{-- PREVIEW --}}
                                        {{-- ================================================= --}}

                                        @if ($dokumen->path_file)

                                            <a
                                                href="{{ asset('storage/' . $dokumen->path_file) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex
                                                       items-center
                                                       justify-center
                                                       w-8
                                                       h-8
                                                       rounded
                                                       text-blue-600
                                                       hover:bg-blue-50
                                                       transition-colors"
                                                title="Preview Dokumen"
                                            >

                                                <span class="material-symbols-outlined text-[20px]">
                                                    visibility
                                                </span>

                                            </a>

                                        @else

                                            <span
                                                class="inline-flex
                                                       items-center
                                                       justify-center
                                                       w-8
                                                       h-8
                                                       rounded
                                                       text-slate-300
                                                       cursor-not-allowed"
                                                title="Preview belum tersedia"
                                            >

                                                <span class="material-symbols-outlined text-[20px]">
                                                    visibility_off
                                                </span>

                                            </span>

                                        @endif


                                        {{-- ================================================= --}}
                                        {{-- UPLOAD --}}
                                        {{-- ================================================= --}}

                                        <a
                                            href="{{ route('user.nasabah.dokumen.create', $nasabah) }}"
                                            class="inline-flex
                                                   items-center
                                                   justify-center
                                                   w-8
                                                   h-8
                                                   rounded
                                                   text-green-600
                                                   hover:bg-green-50
                                                   transition-colors"
                                            title="Upload Dokumen"
                                        >

                                            <span class="material-symbols-outlined text-[20px]">
                                                upload_file
                                            </span>

                                        </a>

                                    </div>

                                </td>

                            </tr>


                        @empty


                            {{-- ================================================= --}}
                            {{-- EMPTY STATE --}}
                            {{-- ================================================= --}}

                            <tr>

                                <td
                                    colspan="5"
                                    class="py-14 px-6 text-center"
                                >

                                    <div class="flex flex-col items-center">


                                        <span class="material-symbols-outlined
                                                     text-5xl
                                                     text-slate-300">

                                            folder_open

                                        </span>


                                        <p class="mt-3
                                                  text-sm
                                                  font-medium
                                                  text-slate-600">

                                            Belum ada dokumen

                                        </p>


                                        <p class="mt-1
                                                  text-xs
                                                  text-slate-400">

                                            Belum terdapat dokumen yang terhubung
                                            dengan nasabah ini.

                                        </p>


                                        {{-- Upload Pertama --}}
                                        <a
                                            href="{{ route('user.nasabah.dokumen.create', $nasabah) }}"
                                            class="mt-4
                                                   inline-flex
                                                   items-center
                                                   gap-2
                                                   px-4
                                                   py-2
                                                   bg-blue-600
                                                   text-white
                                                   text-sm
                                                   font-medium
                                                   rounded-md
                                                   hover:bg-blue-700
                                                   transition-colors"
                                        >

                                            <span class="material-symbols-outlined text-[18px]">
                                                upload_file
                                            </span>

                                            Upload Dokumen

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @endforelse


                    </tbody>

                </table>

            </div>

        </div>



        {{-- ===================================================== --}}
        {{-- KEMBALI --}}
        {{-- ===================================================== --}}

        <div>

            <a
                href="{{ route('user.nasabah.index') }}"
                class="inline-flex
                       items-center
                       gap-2
                       px-4
                       py-2
                       border
                       border-slate-300
                       text-slate-700
                       text-sm
                       font-medium
                       rounded-md
                       hover:bg-slate-50
                       transition-colors"
            >

                <span class="material-symbols-outlined text-[18px]">
                    arrow_back
                </span>

                Kembali ke Data Nasabah

            </a>

        </div>

    </div>

</div>

@endsection