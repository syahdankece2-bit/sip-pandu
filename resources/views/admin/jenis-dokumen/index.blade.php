@extends('layouts.admin')

@section('title', 'SIP-PANDU | Jenis Dokumen')

@section('breadcrumb')

<a
    href="{{ route('admin.dashboard') }}"
    class="text-sm text-on-surface-variant hover:text-primary transition-colors"
>
    Beranda
</a>

<span class="material-symbols-outlined text-[18px]">
    chevron_right
</span>

<span class="text-sm font-medium text-on-surface">
    Jenis Dokumen
</span>

@endsection

@section('content')

{{-- =========================================================
     PAGE HEADER
========================================================== --}}

<div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">

    <div>

        <h1 class="text-2xl font-semibold text-on-surface">
            Jenis Dokumen
        </h1>

        <p class="mt-1 text-sm text-on-surface-variant">
            Manajemen kategori dan persyaratan dokumen nasabah.
        </p>

    </div>


    {{-- Tombol Tambah --}}

    <button
        type="button"
        id="btnTambah"
        class="inline-flex items-center justify-center gap-2
               bg-primary-container text-white
               hover:bg-primary
               px-4 py-2.5
               rounded-lg
               text-sm font-medium
               transition-colors"
    >

        <span class="material-symbols-outlined text-[20px]">
            add
        </span>

        Tambah Jenis Dokumen

    </button>

</div>


{{-- =========================================================
     ALERT
========================================================== --}}

<div
    id="alertMessage"
    class="hidden mb-5 px-4 py-3 rounded-lg text-sm"
></div>


{{-- =========================================================
     DATA CONTAINER
========================================================== --}}

<div class="bg-surface-container-lowest border border-outline-variant rounded-lg overflow-hidden">


    {{-- =====================================================
         TOOLBAR
    ====================================================== --}}

    <div
        class="p-4 border-b border-outline-variant
               flex flex-col sm:flex-row
               sm:items-center sm:justify-between
               gap-4"
    >

        {{-- Jumlah data --}}

        <div class="flex items-center gap-2">

            <span class="text-sm text-on-surface-variant">
                Tampilkan
            </span>

            <select
                id="perPage"
                class="border border-outline-variant
                       rounded-lg
                       py-1.5 px-2
                       text-sm
                       text-on-surface
                       bg-surface
                       focus:ring-primary-container
                       focus:border-primary-container"
            >

                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>

            </select>

            <span class="text-sm text-on-surface-variant">
                entri
            </span>

        </div>


        {{-- Search --}}

        <div class="relative w-full sm:w-72">

            <div
                class="absolute inset-y-0 left-0
                       flex items-center pl-3
                       pointer-events-none"
            >

                <span class="material-symbols-outlined text-outline text-[20px]">
                    search
                </span>

            </div>


            <input
                type="text"
                id="searchInput"
                placeholder="Cari dokumen..."
                class="w-full
                       bg-surface
                       border border-outline-variant
                       text-on-surface
                       rounded-lg
                       pl-10 pr-3 py-2
                       text-sm
                       focus:ring-1
                       focus:ring-primary-container
                       focus:border-primary-container"
            >

        </div>

    </div>


    {{-- =====================================================
         LOADING STATE
    ====================================================== --}}

    <div
        id="loadingState"
        class="py-12 flex flex-col items-center justify-center"
    >

        <span class="material-symbols-outlined text-4xl text-primary animate-spin">
            progress_activity
        </span>

        <p class="mt-3 text-sm text-on-surface-variant">
            Memuat data jenis dokumen...
        </p>

    </div>


    {{-- =====================================================
         EMPTY STATE
    ====================================================== --}}

    <div
        id="emptyState"
        class="hidden py-12 text-center"
    >

        <span class="material-symbols-outlined text-5xl text-outline">
            description
        </span>

        <p class="mt-3 text-sm font-medium text-on-surface">
            Belum ada jenis dokumen
        </p>

        <p class="mt-1 text-sm text-on-surface-variant">
            Data jenis dokumen belum tersedia.
        </p>

    </div>


    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div
        id="tableContainer"
        class="hidden overflow-x-auto"
    >

        <table class="w-full text-left">

            <thead
                class="bg-surface-container-low
                       border-b border-outline-variant"
            >

                <tr>

                    <th
                        class="px-6 py-3 text-xs font-semibold
                               uppercase text-on-surface-variant"
                    >
                        No
                    </th>

                    <th
                        class="px-6 py-3 text-xs font-semibold
                               uppercase text-on-surface-variant"
                    >
                        Nama Dokumen
                    </th>

                    <th
                        class="px-6 py-3 text-xs font-semibold
                               uppercase text-on-surface-variant"
                    >
                        Deskripsi
                    </th>

                    <th
                        class="px-6 py-3 text-xs font-semibold
                               uppercase text-on-surface-variant
                               text-center"
                    >
                        Status
                    </th>

                    <th
                        class="px-6 py-3 text-xs font-semibold
                               uppercase text-on-surface-variant
                               text-right"
                    >
                        Aksi
                    </th>

                </tr>

            </thead>


            {{-- PENTING:
                 JavaScript akan memasukkan data ke tbody ini.
            --}}

            <tbody
                id="jenisDokumenTable"
                class="divide-y divide-outline-variant"
            ></tbody>

        </table>

    </div>


    {{-- =====================================================
         TABLE FOOTER
    ====================================================== --}}

    <div
        id="tableFooter"
        class="hidden px-4 py-3
               border-t border-outline-variant
               flex items-center justify-between
               gap-4"
    >

        <p
            id="totalInfo"
            class="text-sm text-on-surface-variant"
        >
            Menampilkan 0 data
        </p>

    </div>

</div>

@endsection

@push('scripts')

<script>

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    */

    const API_URL = '/api/jenis-dokumen';


    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    */

    let jenisDokumenData = [];

    let filteredData = [];


    /*
    |--------------------------------------------------------------------------
    | Token
    |--------------------------------------------------------------------------
    */

    function getToken()
    {
        return localStorage.getItem('sip_pandu_token');
    }


    /*
    |--------------------------------------------------------------------------
    | Headers
    |--------------------------------------------------------------------------
    */

    function getHeaders()
    {
        const token = getToken();

        return {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
        };
    }


    /*
    |--------------------------------------------------------------------------
    | Alert
    |--------------------------------------------------------------------------
    */

    function showAlert(message, type = 'success')
    {
        const alert = document.getElementById('alertMessage');

        alert.textContent = message;

        alert.className =
            'mb-5 px-4 py-3 rounded-lg text-sm border';


        if (type === 'success') {

            alert.classList.add(
                'bg-green-50',
                'text-green-700',
                'border-green-200'
            );

        } else {

            alert.classList.add(
                'bg-red-50',
                'text-red-700',
                'border-red-200'
            );

        }


        alert.classList.remove('hidden');


        setTimeout(() => {

            alert.classList.add('hidden');

        }, 4000);
    }


    /*
    |--------------------------------------------------------------------------
    | Load Data Jenis Dokumen
    |--------------------------------------------------------------------------
    */

    async function loadJenisDokumen()
    {
        const loading =
            document.getElementById('loadingState');

        const empty =
            document.getElementById('emptyState');

        const table =
            document.getElementById('tableContainer');

        const footer =
            document.getElementById('tableFooter');


        try {

            loading.classList.remove('hidden');

            empty.classList.add('hidden');

            table.classList.add('hidden');

            footer.classList.add('hidden');


            /*
            |--------------------------------------------------------------------------
            | Request API
            |--------------------------------------------------------------------------
            */

            const response = await fetch(API_URL, {

                method: 'GET',

                headers: getHeaders()

            });


            /*
            |--------------------------------------------------------------------------
            | Token Tidak Valid
            |--------------------------------------------------------------------------
            */

            if (response.status === 401) {

                localStorage.removeItem('sip_pandu_token');

                window.location.href = '/login';

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Response JSON
            |--------------------------------------------------------------------------
            */

            const result =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    result.message ||
                    'Gagal mengambil data jenis dokumen.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Simpan Data
            |--------------------------------------------------------------------------
            */

            jenisDokumenData =
                result.data || [];

            filteredData =
                [...jenisDokumenData];


            /*
            |--------------------------------------------------------------------------
            | Render
            |--------------------------------------------------------------------------
            */

            renderTable();


        } catch (error) {

            console.error(error);

            showAlert(
                error.message ||
                'Terjadi kesalahan saat mengambil data.',
                'error'
            );


        } finally {

            loading.classList.add('hidden');

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Render Table
    |--------------------------------------------------------------------------
    */

    function renderTable()
    {
        const table =
            document.getElementById('tableContainer');

        const empty =
            document.getElementById('emptyState');

        const footer =
            document.getElementById('tableFooter');

        const tbody =
            document.getElementById('jenisDokumenTable');

        const totalInfo =
            document.getElementById('totalInfo');


        /*
        |--------------------------------------------------------------------------
        | Bersihkan Isi Table
        |--------------------------------------------------------------------------
        */

        tbody.innerHTML = '';


        /*
        |--------------------------------------------------------------------------
        | Jika Data Kosong
        |--------------------------------------------------------------------------
        */

        if (filteredData.length === 0) {

            table.classList.add('hidden');

            footer.classList.add('hidden');

            empty.classList.remove('hidden');

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Tampilkan Table
        |--------------------------------------------------------------------------
        */

        empty.classList.add('hidden');

        table.classList.remove('hidden');

        footer.classList.remove('hidden');


        /*
        |--------------------------------------------------------------------------
        | Generate Row
        |--------------------------------------------------------------------------
        */

        filteredData.forEach((item, index) => {

            const row =
                document.createElement('tr');


            row.className =
                'hover:bg-surface-bright transition-colors';


            const statusAktif =
                item.status === 'aktif';


            row.innerHTML = `

                <td class="px-6 py-4 text-sm text-on-surface-variant">
                    ${index + 1}
                </td>


                <td class="px-6 py-4">

                    <div class="font-medium text-on-surface">
                        ${escapeHtml(item.nama_dokumen)}
                    </div>

                </td>


                <td class="px-6 py-4">

                    <div class="text-sm text-on-surface-variant max-w-xl">
                        ${escapeHtml(item.deskripsi || '-')}
                    </div>

                </td>


                <td class="px-6 py-4 text-center">

                    ${
                        statusAktif

                        ? `

                            <span
                                class="inline-flex items-center
                                       px-2.5 py-1
                                       rounded-full
                                       text-xs font-medium
                                       bg-green-100
                                       text-green-700"
                            >
                                Aktif
                            </span>

                        `

                        : `

                            <span
                                class="inline-flex items-center
                                       px-2.5 py-1
                                       rounded-full
                                       text-xs font-medium
                                       bg-surface-variant
                                       text-on-surface-variant
                                       border border-outline-variant"
                            >
                                Nonaktif
                            </span>

                        `
                    }

                </td>


                <td class="px-6 py-4">

                    <div class="flex justify-end gap-2">


                        {{-- Edit --}}

                        <button
                            type="button"
                            class="edit-button
                                   p-2
                                   text-secondary
                                   hover:text-primary
                                   hover:bg-surface-container
                                   rounded-lg
                                   transition-colors"
                            data-id="${item.id}"
                            title="Edit"
                        >

                            <span class="material-symbols-outlined text-[20px]">
                                edit
                            </span>

                        </button>


                        {{-- Nonaktifkan --}}

                        ${
                            statusAktif

                            ? `

                                <button
                                    type="button"
                                    class="deactivate-button
                                           p-2
                                           text-secondary
                                           hover:text-error
                                           hover:bg-error-container
                                           rounded-lg
                                           transition-colors"
                                    data-id="${item.id}"
                                    title="Nonaktifkan"
                                >

                                    <span class="material-symbols-outlined text-[20px]">
                                        delete
                                    </span>

                                </button>

                            `

                            : ''
                        }

                    </div>

                </td>

            `;


            tbody.appendChild(row);

        });


        /*
        |--------------------------------------------------------------------------
        | Total Data
        |--------------------------------------------------------------------------
        */

        totalInfo.textContent =
            `Menampilkan ${filteredData.length} data`;
    }


    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('searchInput')
        .addEventListener('input', function () {

            const keyword =
                this.value.toLowerCase().trim();


            filteredData =
                jenisDokumenData.filter(item => {

                    const nama =
                        (item.nama_dokumen || '')
                        .toLowerCase();

                    const deskripsi =
                        (item.deskripsi || '')
                        .toLowerCase();


                    return (
                        nama.includes(keyword) ||
                        deskripsi.includes(keyword)
                    );

                });


            renderTable();

        });


    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value)
    {
        const div =
            document.createElement('div');

        div.textContent =
            value;

        return div.innerHTML;
    }


    /*
    |--------------------------------------------------------------------------
    | Button Tambah
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('btnTambah')
        .addEventListener('click', function () {

            window.location.href =
                "{{ route('admin.jenis-dokumen.create') }}";

        });


    /*
    |--------------------------------------------------------------------------
    | Event Edit / Nonaktifkan
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('jenisDokumenTable')
        .addEventListener('click', async function (event) {


            /*
            |--------------------------------------------------------------------------
            | Edit
            |--------------------------------------------------------------------------
            */

            const editButton =
                event.target.closest('.edit-button');


            if (editButton) {

                const id =
                    editButton.dataset.id;

                window.location.href =
                    `/admin/jenis-dokumen/${id}/edit`;

            }


            /*
            |--------------------------------------------------------------------------
            | Nonaktifkan
            |--------------------------------------------------------------------------
            */

            const deactivateButton =
                event.target.closest('.deactivate-button');


            if (deactivateButton) {

                const id =
                    deactivateButton.dataset.id;


                const konfirmasi =
                    confirm(
                        'Apakah Anda yakin ingin menonaktifkan jenis dokumen ini?'
                    );


                if (!konfirmasi) {

                    return;

                }


                try {

                    const response =
                        await fetch(
                            `/api/jenis-dokumen/${id}/nonaktifkan`,
                            {
                                method: 'PATCH',
                                headers: getHeaders()
                            }
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Token tidak valid
                    |--------------------------------------------------------------------------
                    */

                    if (response.status === 401) {

                        localStorage.removeItem(
                            'sip_pandu_token'
                        );

                        window.location.href =
                            '/login';

                        return;

                    }


                    const result =
                        await response.json();


                    /*
                    |--------------------------------------------------------------------------
                    | Error
                    |--------------------------------------------------------------------------
                    */

                    if (!response.ok) {

                        throw new Error(
                            result.message ||
                            'Gagal menonaktifkan jenis dokumen.'
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Berhasil
                    |--------------------------------------------------------------------------
                    */

                    showAlert(
                        result.message ||
                        'Jenis dokumen berhasil dinonaktifkan.',
                        'success'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Refresh data
                    |--------------------------------------------------------------------------
                    */

                    await loadJenisDokumen();


                } catch (error) {

                    console.error(error);

                    showAlert(
                        error.message ||
                        'Terjadi kesalahan saat menonaktifkan jenis dokumen.',
                        'error'
                    );

                }

            }

        });


    /*
    |--------------------------------------------------------------------------
    | Start
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            loadJenisDokumen();

        }
    );

</script>

@endpush