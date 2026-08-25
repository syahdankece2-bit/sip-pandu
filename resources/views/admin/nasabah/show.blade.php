@extends('layouts.admin')

@section('title', 'SIP-PANDU | Detail Nasabah')

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

<span
    id="breadcrumbNama"
    class="text-sm text-primary font-medium"
>
    Detail Nasabah
</span>

@endsection


@section('content')

{{-- =========================================================
PAGE HEADER
========================================================== --}}

<div class="mb-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

        <div>

            <h1 class="text-2xl font-semibold text-on-surface mb-1">
                Detail Nasabah
            </h1>

            <p class="text-sm text-on-surface-variant">
                Kelola informasi profil, lokasi arsip fisik, dan dokumen digital.
            </p>

        </div>


        <div class="flex flex-wrap gap-3">

            {{-- NONAKTIFKAN --}}

            <button
                type="button"
                id="btnNonaktifkan"
                class="inline-flex items-center justify-center gap-2
                       px-4 py-2.5
                       bg-surface-container-lowest
                       border border-outline-variant
                       rounded-lg
                       text-on-surface-variant
                       text-sm font-medium
                       hover:bg-surface-container-low
                       transition-colors"
            >

                <span class="material-symbols-outlined text-[18px]">
                    block
                </span>

                <span id="nonaktifkanText">
                    Nonaktifkan Nasabah
                </span>

            </button>


            {{-- EDIT --}}

            <a
                href="{{ route('admin.nasabah.edit', $nasabah->id) }}"
                class="px-4 py-2 bg-primary-container text-on-primary rounded font-label-md text-label-md hover:bg-on-primary-fixed-variant transition-colors shadow-sm flex items-center gap-2"
            >

                <span class="material-symbols-outlined text-[18px]">
                    edit
                </span>

                Edit Data Nasabah

            </a>

        </div>

    </div>

</div>


{{-- =========================================================
ALERT
========================================================== --}}

<div
    id="alertMessage"
    class="hidden mb-5 px-4 py-3 rounded-lg text-sm border"
></div>


{{-- =========================================================
LOADING
========================================================== --}}

<div
    id="loadingState"
    class="bg-surface-container-lowest
           border border-outline-variant
           rounded-xl
           p-10
           flex flex-col
           items-center
           justify-center
           text-center"
>

    <span
        class="material-symbols-outlined
               text-primary
               text-[40px]
               animate-spin"
    >
        progress_activity
    </span>

    <p class="mt-3 text-sm font-medium text-on-surface">
        Memuat data nasabah...
    </p>

    <p class="mt-1 text-xs text-on-surface-variant">
        Mohon tunggu sebentar.
    </p>

</div>


{{-- =========================================================
MAIN DETAIL
========================================================== --}}

<div
    id="detailContent"
    class="hidden space-y-6"
>


    {{-- =====================================================
    BENTO GRID
    ====================================================== --}}

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


        {{-- =================================================
        INFORMASI PROFIL
        ================================================== --}}

        <div
            class="lg:col-span-2
                   bg-surface-container-lowest
                   border border-outline-variant
                   rounded-xl
                   p-6"
        >

            <div
                class="flex items-center justify-between
                       border-b border-outline-variant
                       pb-4 mb-5"
            >

                <h2
                    class="text-lg font-semibold
                           text-on-surface
                           flex items-center gap-2"
                >

                    <span class="material-symbols-outlined text-primary">
                        person
                    </span>

                    Informasi Profil

                </h2>


                <span
                    id="statusBadge"
                    class="inline-flex items-center
                           px-2.5 py-1
                           rounded-full
                           text-xs font-semibold"
                >
                    -
                </span>

            </div>


            {{-- =================================================
            DATA NASABAH
            ================================================== --}}

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">


                {{-- NAMA --}}

                <div>

                    <p
                        class="text-xs font-medium
                               text-on-surface-variant
                               mb-1
                               uppercase tracking-wider"
                    >
                        Nama Lengkap
                    </p>

                    <p
                        id="detailNama"
                        class="text-sm font-medium text-on-surface"
                    >
                        -
                    </p>

                </div>


                {{-- NOMOR NASABAH --}}

                <div>

                    <p
                        class="text-xs font-medium
                               text-on-surface-variant
                               mb-1
                               uppercase tracking-wider"
                    >
                        No Nasabah (CIF)
                    </p>

                    <p
                        id="detailNomorNasabah"
                        class="inline-block
                               text-sm
                               font-mono
                               text-on-surface
                               bg-surface-container-low
                               px-2 py-1
                               rounded"
                    >
                        -
                    </p>

                </div>

            </div>

        </div>


        {{-- =================================================
        LOKASI ARSIP
        ================================================== --}}

        <div
            class="bg-surface-container-lowest
                   border border-outline-variant
                   rounded-lg
                   p-6
                   flex flex-col
                   justify-between
                   relative
                   overflow-hidden"
        >

            {{-- Background dekorasi --}}

            <div
                class="absolute -right-10 -top-10
                       w-32 h-32
                       bg-primary/5
                       rounded-full
                       blur-2xl
                       pointer-events-none"
            ></div>


            {{-- Header --}}

            <div>

                <div
                    class="flex items-center justify-between
                           border-b border-outline-variant
                           pb-4 mb-4
                           relative z-10"
                >

                    <h3
                        class="font-title-sm
                               text-title-sm
                               text-on-background
                               flex items-center gap-2"
                    >

                        <span class="material-symbols-outlined text-primary">
                            inventory_2
                        </span>

                        Lokasi Arsip Fisik

                    </h3>

                </div>


                {{-- Isi Lokasi --}}

                <div class="space-y-4 relative z-10">


                    {{-- Status --}}

                    <div
                        class="flex items-center justify-between
                               bg-surface-container-low
                               p-3
                               rounded
                               border border-surface-container-highest"
                    >

                        <span
                            class="font-label-md
                                   text-label-md
                                   text-on-surface-variant
                                   uppercase
                                   tracking-wider"
                        >
                            Status
                        </span>


                        <span
                            id="lokasiStatus"
                            class="inline-flex
                                   items-center
                                   gap-1
                                   font-label-bold
                                   text-[11px]
                                   px-2
                                   py-0.5
                                   rounded-full"
                        >
                            Belum Diatur
                        </span>

                    </div>


                    {{-- Rak & Map --}}

                    <div class="grid grid-cols-2 gap-4">


                        {{-- Rak --}}

                        <div
                            class="bg-surface
                                   p-3
                                   rounded
                                   border border-outline-variant/50"
                        >

                            <p
                                class="font-label-md
                                       text-[10px]
                                       text-on-surface-variant
                                       mb-1
                                       uppercase"
                            >
                                Rak
                            </p>

                            <p
                                id="detailRak"
                                class="font-headline-md
                                       text-lg
                                       text-primary"
                            >
                                -
                            </p>

                        </div>


                        {{-- Map --}}

                        <div
                            class="bg-surface
                                   p-3
                                   rounded
                                   border border-outline-variant/50"
                        >

                            <p
                                class="font-label-md
                                       text-[10px]
                                       text-on-surface-variant
                                       mb-1
                                       uppercase"
                            >
                                Map
                            </p>

                            <p
                                id="detailNomorMap"
                                class="font-code-sm
                                       text-code-sm
                                       text-on-background
                                       font-medium"
                            >
                                -
                            </p>

                        </div>


                        {{-- Posisi --}}

                        <div
                            class="col-span-2
                                   bg-surface
                                   p-3
                                   rounded
                                   border border-outline-variant/50
                                   flex
                                   justify-between
                                   items-center"
                        >

                            <p
                                class="font-label-md
                                       text-[10px]
                                       text-on-surface-variant
                                       uppercase"
                            >
                                Posisi
                            </p>

                            <p
                                id="detailPosisi"
                                class="font-code-sm
                                       text-code-sm
                                       text-on-background
                                       font-medium"
                            >
                                -
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Tutup grid profil + lokasi --}}

    </div>


    {{-- =====================================================
    DOKUMEN NASABAH
    ====================================================== --}}

    <div
        class="bg-surface-container-lowest
               border border-outline-variant
               rounded-xl
               overflow-hidden
               shadow-sm"
    >


        {{-- HEADER --}}

        <div
            class="p-4 sm:p-5
                   border-b border-outline-variant
                   flex flex-col sm:flex-row
                   sm:items-center
                   justify-between
                   gap-4
                   bg-surface"
        >

            <div class="flex items-center gap-3">

                <div
                    class="w-10 h-10
                           rounded-lg
                           bg-primary/10
                           text-primary
                           flex items-center
                           justify-center
                           flex-shrink-0"
                >

                    <span class="material-symbols-outlined text-[22px]">
                        folder_open
                    </span>

                </div>

                <div>

                    <h2
                        class="text-base sm:text-lg
                               font-semibold
                               text-on-surface
                               flex items-center gap-2"
                    >

                        Dokumen Nasabah

                        <span
                            id="jumlahDokumen"
                            class="text-xs
                                   font-semibold
                                   bg-primary-container
                                   text-primary
                                   px-2.5
                                   py-0.5
                                   rounded-full"
                        >
                            0
                        </span>

                    </h2>

                    <p class="text-xs text-on-surface-variant">
                        Daftar arsip fisik dan berkas dokumen digital nasabah
                    </p>

                </div>

            </div>


            <div class="flex flex-wrap items-center gap-3">

                {{-- SEARCH --}}

                <div class="relative flex-1 sm:flex-none">

                    <span
                        class="material-symbols-outlined
                               absolute
                               left-3
                               top-1/2
                               -translate-y-1/2
                               text-on-surface-variant
                               text-[18px]"
                    >
                        search
                    </span>

                    <input
                        type="text"
                        id="searchDokumen"
                        placeholder="Cari dokumen..."
                        class="pl-9
                               pr-4
                               py-2
                               bg-surface-container-low
                               border border-outline-variant
                               rounded-lg
                               text-sm
                               focus:ring-2
                               focus:ring-primary/20
                               focus:border-primary
                               w-full
                               sm:w-60
                               outline-none
                               transition-all"
                    >

                </div>


                {{-- TAMBAH DOKUMEN --}}

                <a
                    href="{{ route('admin.nasabah.dokumen.create', $nasabah->id) }}"
                    class="inline-flex
                           items-center
                           gap-2
                           px-3.5
                           py-2
                           bg-primary
                           text-on-primary
                           rounded-lg
                           text-xs
                           font-medium
                           hover:bg-primary/90
                           transition-all
                           shadow-sm
                           flex-shrink-0"
                >

                    <span class="material-symbols-outlined text-[16px]">
                        add
                    </span>

                    Tambah Dokumen

                </a>

            </div>

        </div>


        {{-- TABLE --}}

        <div class="w-full overflow-x-auto">

            <table
                class="w-full
                       min-w-[950px]
                       table-fixed
                       text-left
                       border-collapse"
            >

                <colgroup>

                    <col class="w-[24%]">
                    <col class="w-[14%]">
                    <col class="w-[14%]">
                    <col class="w-[20%]">
                    <col class="w-[14%]">
                    <col class="w-[14%]">

                </colgroup>


                <thead>

                    <tr
                        class="bg-surface-container-low/70
                               border-b border-outline-variant
                               text-[11px]
                               font-semibold
                               text-on-surface-variant
                               uppercase
                               tracking-wider"
                    >

                        <th class="px-5 py-3 text-left">
                            Jenis Dokumen
                        </th>

                        <th class="px-4 py-3 text-center">
                            Status Fisik
                        </th>

                        <th class="px-4 py-3 text-center">
                            Status Digital
                        </th>

                        <th class="px-4 py-3 text-left">
                            Nama File
                        </th>

                        <th class="px-4 py-3 text-left">
                            Tanggal Upload
                        </th>

                        <th class="px-4 py-3 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody
                    id="dokumenTableBody"
                    class="divide-y
                           divide-outline-variant/40
                           bg-surface-container-lowest"
                >
                </tbody>

            </table>

        </div>


        {{-- EMPTY STATE --}}

        <div
            id="emptyDokumen"
            class="hidden p-12 text-center"
        >

            <div
                class="w-14 h-14
                       rounded-full
                       bg-surface-container-low
                       text-on-surface-variant
                       flex items-center
                       justify-center
                       mx-auto
                       mb-3
                       border border-outline-variant/50"
            >

                <span class="material-symbols-outlined text-3xl">
                    folder_off
                </span>

            </div>

            <h3 class="text-sm font-semibold text-on-surface">
                Belum ada dokumen
            </h3>

            <p
                class="mt-1
                       text-xs
                       text-on-surface-variant
                       max-w-sm
                       mx-auto"
            >
                Nasabah ini belum memiliki dokumen digital maupun rekaman fisik yang terdaftar.
            </p>

            <a
                href="{{ route('admin.nasabah.dokumen.create', $nasabah->id) }}"
                class="inline-flex
                       items-center
                       gap-2
                       mt-4
                       px-4
                       py-2
                       bg-primary
                       text-on-primary
                       rounded-lg
                       text-xs
                       font-medium
                       hover:bg-primary/90
                       transition-all
                       shadow-sm"
            >

                <span class="material-symbols-outlined text-[16px]">
                    upload_file
                </span>

                Upload Dokumen Pertama

            </a>

        </div>

    </div>


    {{-- =====================================================
    BACK BUTTON
    ====================================================== --}}

    <div>

        <a
            href="{{ route('admin.nasabah.index') }}"
            class="inline-flex
                   items-center
                   gap-2
                   px-4
                   py-2.5
                   rounded-lg
                   border border-outline-variant
                   text-secondary
                   text-sm
                   font-medium
                   hover:bg-surface-container-low
                   transition-colors"
        >

            <span class="material-symbols-outlined text-[18px]">
                arrow_back
            </span>

            Kembali ke Data Nasabah

        </a>

    </div>

</div>

@endsection


@push('scripts')

<script>

    /*
    |--------------------------------------------------------------------------
    | CONFIG
    |--------------------------------------------------------------------------
    */

    const NASABAH_ID =
        @json($nasabah->id);

    const NASABAH_API =
        `/api/nasabah/${NASABAH_ID}`;

    const LOKASI_API =
        `/api/nasabah/${NASABAH_ID}/lokasi-arsip`;

    const NASABAH_AWAL =
        @json($nasabah);

    const LOKASI_AWAL =
        @json($nasabah->lokasiArsip);

    const DOKUMEN_AWAL =
        @json($nasabah->dokumen);

    const DOKUMEN_API =
        `/api/nasabah/${NASABAH_ID}/dokumen`;

    const GANTI_DOKUMEN_URL =
        @json(url('/admin/nasabah/' . $nasabah->id . '/dokumen'));

    const NONAKTIFKAN_API =
        `/api/nasabah/${NASABAH_ID}/nonaktifkan`;


    /*
    |--------------------------------------------------------------------------
    | TOKEN
    |--------------------------------------------------------------------------
    */

    function getToken()
    {
        return localStorage.getItem(
            'sip_pandu_token'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HEADERS
    |--------------------------------------------------------------------------
    */

    function getHeaders()
    {
        const token =
            getToken();

        return {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
        };
    }


    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const loadingState =
        document.getElementById(
            'loadingState'
        );

    const detailContent =
        document.getElementById(
            'detailContent'
        );

    const alertMessage =
        document.getElementById(
            'alertMessage'
        );


    /*
    |--------------------------------------------------------------------------
    | ALERT
    |--------------------------------------------------------------------------
    */

    function showAlert(
        message,
        type = 'success'
    )
    {
        alertMessage.textContent =
            message;

        alertMessage.className =
            'mb-5 px-4 py-3 rounded-lg text-sm border';

        if (type === 'success') {

            alertMessage.classList.add(
                'bg-green-50',
                'text-green-700',
                'border-green-200'
            );

        } else {

            alertMessage.classList.add(
                'bg-red-50',
                'text-red-700',
                'border-red-200'
            );

        }

        alertMessage.classList.remove(
            'hidden'
        );

        alertMessage.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }


    /*
    |--------------------------------------------------------------------------
    | HANDLE RESPONSE
    |--------------------------------------------------------------------------
    */

    async function handleResponse(
        response
    )
    {
        if (response.status === 401) {
            return null;
        }

        const result =
            await response.json();

        if (!response.ok) {

            throw new Error(
                result.message ||
                'Terjadi kesalahan pada server.'
            );
        }

        return result;
    }


    /*
    |--------------------------------------------------------------------------
    | FORMAT NILAI
    |--------------------------------------------------------------------------
    */

    function displayValue(value)
    {
        if (
            value === null ||
            value === undefined ||
            value === ''
        ) {
            return '-';
        }

        return String(value);
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS NASABAH
    |--------------------------------------------------------------------------
    */

    function renderStatus(status)
    {
        const badge =
            document.getElementById(
                'statusBadge'
            );

        const value =
            String(
                status || ''
            ).toLowerCase();

        badge.textContent =
            value
                ? value.charAt(0).toUpperCase() +
                  value.slice(1)
                : '-';

        badge.className =
            'inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold';

        if (value === 'aktif') {

            badge.classList.add(
                'bg-green-50',
                'text-green-700',
                'border',
                'border-green-200'
            );

        } else {

            badge.classList.add(
                'bg-red-50',
                'text-red-700',
                'border',
                'border-red-200'
            );

        }
    }


    /*
    |--------------------------------------------------------------------------
    | RENDER NASABAH
    |--------------------------------------------------------------------------
    */

    function renderNasabah(nasabah)
    {
        if (!nasabah) {
            return;
        }

        document.getElementById(
            'detailNama'
        ).textContent =
            displayValue(
                nasabah.nama
            );

        document.getElementById(
            'detailNomorNasabah'
        ).textContent =
            displayValue(
                nasabah.nomor_nasabah
            );

        document.getElementById(
            'breadcrumbNama'
        ).textContent =
            displayValue(
                nasabah.nama
            );

        renderStatus(
            nasabah.status
        );


        /*
        |--------------------------------------------------------------------------
        | NONAKTIFKAN BUTTON
        |--------------------------------------------------------------------------
        */

        const btnNonaktifkan =
            document.getElementById(
                'btnNonaktifkan'
            );

        const nonaktifkanText =
            document.getElementById(
                'nonaktifkanText'
            );

        if (
            String(
                nasabah.status
            ).toLowerCase() ===
            'nonaktif'
        ) {

            btnNonaktifkan.disabled =
                true;

            btnNonaktifkan.classList.add(
                'opacity-50',
                'cursor-not-allowed'
            );

            nonaktifkanText.textContent =
                'Nasabah Nonaktif';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | RENDER LOKASI
    |--------------------------------------------------------------------------
    */

    function renderLokasi(lokasi)
    {
        if (!lokasi) {

            document.getElementById(
                'detailRak'
            ).textContent = '-';

            document.getElementById(
                'detailNomorMap'
            ).textContent = '-';

            document.getElementById(
                'detailPosisi'
            ).textContent = '-';

            renderLokasiStatus(
                false
            );

            return;
        }

        document.getElementById(
            'detailRak'
        ).textContent =
            displayValue(
                lokasi.rak
            );

        document.getElementById(
            'detailNomorMap'
        ).textContent =
            displayValue(
                lokasi.nomor_map
            );

        document.getElementById(
            'detailPosisi'
        ).textContent =
            displayValue(
                lokasi.posisi
            );

        const tersedia =
            lokasi.rak ||
            lokasi.nomor_map ||
            lokasi.posisi;

        renderLokasiStatus(
            Boolean(tersedia)
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS LOKASI
    |--------------------------------------------------------------------------
    */

    function renderLokasiStatus(
        tersedia
    )
    {
        const status =
            document.getElementById(
                'lokasiStatus'
            );

        if (tersedia) {

            status.innerHTML = `
                <span class="material-symbols-outlined text-[14px]">
                    check_circle
                </span>
                Tersedia
            `;

            status.className =
                'inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-1 rounded-full bg-green-50 text-green-700 border border-green-200';

        } else {

            status.innerHTML = `
                <span class="material-symbols-outlined text-[14px]">
                    info
                </span>
                Belum Diatur
            `;

            status.className =
                'inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-1 rounded-full bg-gray-50 text-gray-600 border border-gray-200';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | GET DOCUMENT TYPE NAME
    |--------------------------------------------------------------------------
    */

    function getDocumentTypeName(
        documentData
    )
    {
        if (!documentData) {
            return 'Dokumen';
        }

        const jenisDokumen =
            documentData.jenis_dokumen;


        if (
            jenisDokumen &&
            typeof jenisDokumen === 'object'
        ) {

            const nama =
                jenisDokumen.nama ||
                jenisDokumen.name ||
                jenisDokumen.nama_dokumen ||
                jenisDokumen.jenis ||
                jenisDokumen.label ||
                jenisDokumen.title;

            if (
                nama !== null &&
                nama !== undefined &&
                nama !== ''
            ) {
                return String(nama);
            }


            if (
                jenisDokumen.data &&
                typeof jenisDokumen.data === 'object'
            ) {

                const nested =
                    jenisDokumen.data;

                const nestedNama =
                    nested.nama ||
                    nested.name ||
                    nested.nama_dokumen ||
                    nested.jenis ||
                    nested.label ||
                    nested.title;

                if (
                    nestedNama !== null &&
                    nestedNama !== undefined &&
                    nestedNama !== ''
                ) {
                    return String(
                        nestedNama
                    );
                }
            }

        }


        if (
            typeof jenisDokumen === 'string' &&
            jenisDokumen.trim() !== ''
        ) {

            return jenisDokumen;
        }


        const fallback =
            documentData.nama_dokumen ||
            documentData.nama ||
            documentData.jenis ||
            documentData.document_type ||
            documentData.documentType ||
            documentData.type;


        if (
            fallback !== null &&
            fallback !== undefined &&
            fallback !== ''
        ) {

            if (
                typeof fallback === 'object'
            ) {

                return (
                    fallback.nama ||
                    fallback.name ||
                    fallback.label ||
                    fallback.title ||
                    'Dokumen'
                );

            }

            return String(
                fallback
            );
        }


        return 'Dokumen';
    }


    /*
    |--------------------------------------------------------------------------
    | DOCUMENT ICON
    |--------------------------------------------------------------------------
    */

    function getDocumentIcon(nama)
    {
        const value =
            String(
                nama || ''
            ).toLowerCase();

        if (
            value.includes('ktp')
        ) {
            return 'id_card';
        }

        if (
            value.includes('kk') ||
            value.includes('keluarga')
        ) {
            return 'contact_page';
        }

        if (
            value.includes('npwp')
        ) {
            return 'receipt_long';
        }

        if (
            value.includes('slip') ||
            value.includes('gaji')
        ) {
            return 'payments';
        }

        return 'description';
    }


    /*
    |--------------------------------------------------------------------------
    | DOCUMENT PHYSICAL STATUS
    |--------------------------------------------------------------------------
    */

    function physicalStatusBadge(
        documentData
    )
    {
        const status =
            documentData.status_fisik;

        if (
            status === null ||
            status === undefined ||
            status === ''
        ) {

            return `
                <span class="inline-flex items-center gap-1 text-[11px] font-medium bg-slate-100 text-slate-500 px-2.5 py-0.5 rounded-full border border-slate-200">
                    <span class="material-symbols-outlined text-[13px]">
                        remove
                    </span>
                    Belum Ada
                </span>
            `;
        }

        const value =
            String(
                status
            ).toLowerCase();

        if (
            value === 'ada' ||
            value === 'tersedia'
        ) {

            return `
                <span class="inline-flex items-center gap-1 text-[11px] font-semibold bg-emerald-50 text-emerald-700 px-2.5 py-0.5 rounded-full border border-emerald-200/80">
                    <span class="material-symbols-outlined text-[13px] text-emerald-600">
                        check_circle
                    </span>
                    Ada
                </span>
            `;
        }

        return `
            <span class="inline-flex items-center gap-1 text-[11px] font-medium bg-slate-100 text-slate-600 px-2.5 py-0.5 rounded-full border border-slate-200">
                ${escapeHtml(status)}
            </span>
        `;
    }


    /*
    |--------------------------------------------------------------------------
    | DIGITAL STATUS
    |--------------------------------------------------------------------------
    */

    function digitalStatusBadge(
        documentData
    )
    {
        const file =
            documentData.file_url ||
            documentData.file_path ||
            documentData.nama_file ||
            documentData.filename ||
            documentData.file_name;

        if (
            file ||
            documentData.status_digital ===
            'tersedia'
        ) {

            return `
                <span class="inline-flex items-center gap-1 text-[11px] font-semibold bg-sky-50 text-sky-700 px-2.5 py-0.5 rounded-full border border-sky-200/80">
                    <span class="material-symbols-outlined text-[13px] text-sky-600">
                        cloud_done
                    </span>
                    Tersedia
                </span>
            `;
        }

        return `
            <span class="inline-flex items-center gap-1 text-[11px] font-medium bg-rose-50 text-rose-600 px-2.5 py-0.5 rounded-full border border-rose-200/80">
                <span class="material-symbols-outlined text-[13px] text-rose-500">
                    cloud_off
                </span>
                Belum Ada
            </span>
        `;
    }


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value)
    {
        if (
            value === null ||
            value === undefined
        ) {
            return '';
        }

        return String(value)
            .replace(
                /&/g,
                '&amp;'
            )
            .replace(
                /</g,
                '&lt;'
            )
            .replace(
                />/g,
                '&gt;'
            )
            .replace(
                /"/g,
                '&quot;'
            )
            .replace(
                /'/g,
                '&#039;'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DATE FORMAT
    |--------------------------------------------------------------------------
    */

    function formatDate(value)
    {
        if (!value) {
            return '-';
        }

        const date =
            new Date(value);

        if (
            Number.isNaN(
                date.getTime()
            )
        ) {
            return value;
        }

        return date.toLocaleDateString(
            'id-ID',
            {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RENDER DOKUMEN
    |--------------------------------------------------------------------------
    */

    let allDocuments = [];


    function renderDocuments(
        documents
    )
    {
        allDocuments =
            Array.isArray(documents)
                ? documents
                : [];

        const tbody =
            document.getElementById(
                'dokumenTableBody'
            );

        const empty =
            document.getElementById(
                'emptyDokumen'
            );

        const jumlah =
            document.getElementById(
                'jumlahDokumen'
            );

        jumlah.textContent =
            allDocuments.length;

        if (
            allDocuments.length === 0
        ) {

            tbody.innerHTML = '';

            empty.classList.remove(
                'hidden'
            );

            return;
        }

        empty.classList.add(
            'hidden'
        );

        tbody.innerHTML =
            allDocuments.map(
                (documentData) => {

                    const jenis =
                        getDocumentTypeName(
                            documentData
                        );

                    const namaFile =
                        documentData.nama_file ||
                        documentData.filename ||
                        documentData.file_name ||
                        null;

                    const tanggal =
                        documentData.tanggal_upload ||
                        documentData.created_at ||
                        null;

                    const documentId =
                        Number(
                            documentData.id
                        ) || null;

                    const hasDigitalFile =
                        Boolean(
                            documentId
                        ) &&
                        Boolean(
                            namaFile ||
                            documentData.status_digital ===
                            'tersedia'
                        );

                    const icon =
                        getDocumentIcon(
                            jenis
                        );


                    return `
                        <tr class="hover:bg-surface-container-low/70 transition-colors border-b border-outline-variant/40 last:border-b-0">

                            <td class="px-5 py-3.5 text-sm text-on-surface font-medium whitespace-nowrap">

                                <div class="flex items-center gap-3">

                                    <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">

                                        <span class="material-symbols-outlined text-[18px]">
                                            ${icon}
                                        </span>

                                    </div>

                                    <span class="font-medium text-on-surface text-sm">
                                        ${escapeHtml(jenis)}
                                    </span>

                                </div>

                            </td>


                            <td class="px-4 py-3.5 whitespace-nowrap text-center">
                                ${physicalStatusBadge(documentData)}
                            </td>


                            <td class="px-4 py-3.5 whitespace-nowrap text-center">
                                ${digitalStatusBadge(documentData)}
                            </td>


                            <td
                                class="px-4 py-3.5 text-sm font-mono text-on-surface-variant truncate max-w-[200px]"
                                title="${escapeHtml(namaFile || '-')}"
                            >

                                ${
                                    namaFile
                                    ? `
                                        <span class="inline-flex items-center gap-1.5 bg-surface-container-low border border-outline-variant/50 px-2.5 py-1 rounded text-xs font-mono text-on-surface truncate max-w-[190px]">

                                            <span class="material-symbols-outlined text-[14px] text-on-surface-variant">
                                                attach_file
                                            </span>

                                            ${escapeHtml(namaFile)}

                                        </span>
                                    `
                                    : `
                                        <span class="text-xs text-on-surface-variant/60 font-sans italic">
                                            -
                                        </span>
                                    `
                                }

                            </td>


                            <td class="px-4 py-3.5 text-xs text-on-surface-variant font-medium whitespace-nowrap text-left">

                                ${formatDate(tanggal)}

                            </td>


                            <td class="px-4 py-3.5 whitespace-nowrap text-center">

                                <div class="inline-flex items-center gap-1 bg-surface-container-low/60 p-1 rounded-lg border border-outline-variant/40">

                                    ${
                                        hasDigitalFile
                                        ? `
                                            <button
                                                type="button"
                                                onclick="previewDocument(${documentId})"
                                                class="p-1.5 rounded-md text-on-surface-variant hover:text-primary hover:bg-primary/10 transition-colors"
                                                title="Lihat / Preview Dokumen"
                                            >

                                                <span class="material-symbols-outlined text-[18px]">
                                                    visibility
                                                </span>

                                            </button>


                                            <button
                                                type="button"
                                                onclick="downloadDocument(${documentId})"
                                                class="p-1.5 rounded-md text-on-surface-variant hover:text-emerald-600 hover:bg-emerald-50 transition-colors"
                                                title="Unduh Dokumen"
                                            >

                                                <span class="material-symbols-outlined text-[18px]">
                                                    download
                                                </span>

                                            </button>


                                            <button
                                                type="button"
                                                onclick="window.location.href = GANTI_DOKUMEN_URL + '/${documentId}/ganti'"
                                                class="p-1.5 rounded-md text-on-surface-variant hover:text-amber-600 hover:bg-amber-50 transition-colors"
                                                title="Ganti Dokumen"
                                            >

                                                <span class="material-symbols-outlined text-[18px]">
                                                    sync
                                                </span>

                                            </button>
                                        `
                                        : `
                                            <button
                                                type="button"
                                                disabled
                                                class="p-1.5 rounded-md text-gray-300 cursor-not-allowed"
                                                title="File belum diupload"
                                            >

                                                <span class="material-symbols-outlined text-[18px]">
                                                    visibility_off
                                                </span>

                                            </button>


                                            <button
                                                type="button"
                                                disabled
                                                class="p-1.5 rounded-md text-gray-300 cursor-not-allowed"
                                                title="File belum diupload"
                                            >

                                                <span class="material-symbols-outlined text-[18px]">
                                                    download
                                                </span>

                                            </button>
                                        `
                                    }


                                    ${
                                        documentId
                                        ? `
                                            <button
                                                type="button"
                                                onclick="deleteDocument(${documentId})"
                                                class="p-1.5 rounded-md text-on-surface-variant hover:text-rose-600 hover:bg-rose-50 transition-colors"
                                                title="Hapus Dokumen"
                                            >

                                                <span class="material-symbols-outlined text-[18px]">
                                                    delete
                                                </span>

                                            </button>
                                        `
                                        : ''
                                    }

                                </div>

                            </td>

                        </tr>
                    `;

                }
            ).join('');
    }


    /*
    |--------------------------------------------------------------------------
    | LOAD NASABAH
    |--------------------------------------------------------------------------
    */

    async function loadNasabah()
    {
        try {

            const response =
                await fetch(
                    NASABAH_API,
                    {
                        method: 'GET',
                        headers: getHeaders()
                    }
                );

            const result =
                await handleResponse(
                    response
                );

            if (!result) {
                return NASABAH_AWAL;
            }

            return result.data || result;

        } catch (error) {

            return NASABAH_AWAL;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | LOAD LOKASI
    |--------------------------------------------------------------------------
    */

    async function loadLokasi()
    {
        try {

            const response =
                await fetch(
                    LOKASI_API,
                    {
                        method: 'GET',
                        headers: getHeaders()
                    }
                );


            /*
             * Endpoint lokasi bersifat opsional.
             */

            if (
                response.status === 404
            ) {

                return LOKASI_AWAL;
            }


            const result =
                await handleResponse(
                    response
                );

            if (!result) {
                return LOKASI_AWAL;
            }


            const data =
                result.data?.data ||
                result.data ||
                result;


            return (
                data.lokasi_arsip ||
                data.lokasiArsip ||
                data
            );

        } catch (error) {

            console.warn(
                'API lokasi arsip tidak tersedia, memakai data halaman:',
                error
            );

            return LOKASI_AWAL;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | LOAD DOKUMEN
    |--------------------------------------------------------------------------
    */

    async function loadDokumen()
    {
        try {

            const response =
                await fetch(
                    DOKUMEN_API,
                    {
                        method: 'GET',
                        headers: getHeaders()
                    }
                );


            if (
                response.status === 404
            ) {

                return DOKUMEN_AWAL || [];
            }


            const result =
                await handleResponse(
                    response
                );

            if (!result) {
                return DOKUMEN_AWAL || [];
            }


            if (
                Array.isArray(
                    result.data
                )
            ) {

                return result.data;
            }


            if (
                result.data &&
                Array.isArray(
                    result.data.data
                )
            ) {

                return result.data.data;
            }


            if (
                Array.isArray(result)
            ) {

                return result;
            }


            return DOKUMEN_AWAL || [];

        } catch (error) {

            return DOKUMEN_AWAL || [];
        }
    }


    /*
    |--------------------------------------------------------------------------
    | LOAD DETAIL
    |--------------------------------------------------------------------------
    */

    async function loadDetail()
    {
        try {

            const [
                nasabah,
                lokasi,
                dokumen
            ] = await Promise.all([
                loadNasabah(),
                loadLokasi(),
                loadDokumen()
            ]);


            renderNasabah(
                nasabah
            );

            renderLokasi(
                lokasi
            );

            renderDocuments(
                dokumen
            );


            loadingState.classList.add(
                'hidden'
            );

            detailContent.classList.remove(
                'hidden'
            );

        } catch (error) {

            console.error(
                'Error detail nasabah:',
                error
            );


            loadingState.classList.add(
                'hidden'
            );


            showAlert(
                error.message ||
                'Gagal memuat data nasabah.',
                'error'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH DOKUMEN
    |--------------------------------------------------------------------------
    */

    const searchDokumen =
        document.getElementById(
            'searchDokumen'
        );


    if (searchDokumen) {

        searchDokumen.addEventListener(
            'input',
            function () {

                const keyword =
                    this.value
                        .trim()
                        .toLowerCase();


                if (!keyword) {

                    renderDocuments(
                        allDocuments
                    );

                    return;
                }


                const filtered =
                    allDocuments.filter(
                        (documentData) => {

                            const jenis =
                                getDocumentTypeName(
                                    documentData
                                );


                            const namaFile =
                                documentData.nama_file ||
                                documentData.filename ||
                                documentData.file_name ||
                                '';


                            return (
                                String(jenis)
                                    .toLowerCase()
                                    .includes(keyword)
                                ||
                                String(namaFile)
                                    .toLowerCase()
                                    .includes(keyword)
                            );

                        }
                    );


                renderDocuments(
                    filtered
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | NONAKTIFKAN NASABAH
    |--------------------------------------------------------------------------
    */

    const btnNonaktifkan =
        document.getElementById(
            'btnNonaktifkan'
        );


    if (btnNonaktifkan) {

        btnNonaktifkan.addEventListener(
            'click',
            async function () {

                const yakin =
                    confirm(
                        'Apakah Anda yakin ingin menonaktifkan nasabah ini?'
                    );


                if (!yakin) {
                    return;
                }


                const button =
                    this;

                const text =
                    document.getElementById(
                        'nonaktifkanText'
                    );


                button.disabled =
                    true;

                button.classList.add(
                    'opacity-60',
                    'cursor-not-allowed'
                );

                text.textContent =
                    'Memproses...';


                try {

                    const response =
                        await fetch(
                            NONAKTIFKAN_API,
                            {
                                method: 'PATCH',
                                headers: getHeaders()
                            }
                        );


                    const result =
                        await handleResponse(
                            response
                        );


                    if (!result) {
                        return;
                    }


                    showAlert(
                        result.message ||
                        'Nasabah berhasil dinonaktifkan.',
                        'success'
                    );


                    setTimeout(
                        () => {
                            loadDetail();
                        },
                        500
                    );


                } catch (error) {

                    console.error(
                        'Error nonaktifkan nasabah:',
                        error
                    );


                    showAlert(
                        error.message ||
                        'Gagal menonaktifkan nasabah.',
                        'error'
                    );


                    button.disabled =
                        false;

                    button.classList.remove(
                        'opacity-60',
                        'cursor-not-allowed'
                    );

                    text.textContent =
                        'Nonaktifkan Nasabah';
                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | PREVIEW DOCUMENT
    |--------------------------------------------------------------------------
    */

    async function getDocumentFile(
        documentId,
        action
    )
    {
        const response =
            await fetch(
                `/api/dokumen/${documentId}/${action}`,
                {
                    method: 'GET',
                    headers: getHeaders()
                }
            );


        if (response.ok) {
            return response;
        }


        let message =
            'File dokumen tidak dapat diakses.';


        try {

            const result =
                await response.json();

            message =
                result.message ||
                message;

        } catch (error) {

            // Response bukan JSON.
        }


        throw new Error(
            message
        );
    }


    async function previewDocument(
        documentId
    )
    {
        if (!documentId) {

            showAlert(
                'File dokumen belum tersedia.',
                'error'
            );

            return;
        }


        const previewWindow =
            window.open(
                '',
                '_blank'
            );


        try {

            const response =
                await getDocumentFile(
                    documentId,
                    'preview'
                );


            const blob =
                await response.blob();

            const objectUrl =
                URL.createObjectURL(
                    blob
                );


            if (previewWindow) {

                previewWindow.location.href =
                    objectUrl;

            } else {

                window.open(
                    objectUrl,
                    '_blank'
                );

            }


            setTimeout(
                () =>
                    URL.revokeObjectURL(
                        objectUrl
                    ),
                60000
            );

        } catch (error) {

            if (previewWindow) {
                previewWindow.close();
            }


            showAlert(
                error.message ||
                'Gagal membuka preview dokumen.',
                'error'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD DOCUMENT
    |--------------------------------------------------------------------------
    */

    async function downloadDocument(
        documentId
    )
    {
        if (!documentId) {

            showAlert(
                'File dokumen belum tersedia.',
                'error'
            );

            return;
        }


        try {

            const response =
                await getDocumentFile(
                    documentId,
                    'download'
                );


            const blob =
                await response.blob();

            const objectUrl =
                URL.createObjectURL(
                    blob
                );


            const disposition =
                response.headers.get(
                    'Content-Disposition'
                ) || '';


            const filenameMatch =
                disposition.match(
                    /filename="?([^";]+)"?/i
                );


            const link =
                document.createElement(
                    'a'
                );


            link.href =
                objectUrl;

            link.download =
                filenameMatch
                    ? filenameMatch[1]
                    : 'dokumen';


            document.body.appendChild(
                link
            );

            link.click();

            document.body.removeChild(
                link
            );


            setTimeout(
                () =>
                    URL.revokeObjectURL(
                        objectUrl
                    ),
                1000
            );

        } catch (error) {

            showAlert(
                error.message ||
                'Gagal mengunduh dokumen.',
                'error'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS DOKUMEN
    |--------------------------------------------------------------------------
    */

    async function deleteDocument(
        documentId
    )
    {
        if (!documentId) {
            return;
        }


        const confirmed =
            confirm(
                'Yakin ingin menghapus dokumen ini? File dan datanya tidak dapat dikembalikan.'
            );


        if (!confirmed) {
            return;
        }


        try {

            const response =
                await fetch(
                    `/api/dokumen/${documentId}`,
                    {
                        method: 'DELETE',
                        headers: getHeaders()
                    }
                );


            const result =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    result.message ||
                    'Gagal menghapus dokumen.'
                );
            }


            showAlert(
                result.message ||
                'Dokumen berhasil dihapus.',
                'success'
            );


            await loadDetail();

        } catch (error) {

            showAlert(
                error.message ||
                'Gagal menghapus dokumen.',
                'error'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | INITIAL LOAD
    |--------------------------------------------------------------------------
    */

    if (NASABAH_AWAL) {

        renderNasabah(
            NASABAH_AWAL
        );

        renderLokasi(
            LOKASI_AWAL
        );

        renderDocuments(
            DOKUMEN_AWAL
        );


        if (loadingState) {

            loadingState.classList.add(
                'hidden'
            );

        }


        if (detailContent) {

            detailContent.classList.remove(
                'hidden'
            );

        }

    }


    loadDetail();

</script>

@endpush