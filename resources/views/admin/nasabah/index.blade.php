@extends('layouts.admin')

@section('title', 'SIP-PANDU - Data Nasabah')

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

<span class="text-sm text-primary font-medium">
    Data Nasabah
</span>

@endsection

@section('content')

{{-- =========================================================
PAGE HEADER
========================================================= --}}

<div class="mb-6">

<h2 class="text-2xl font-semibold text-on-surface mb-1">
    Data Nasabah
</h2>

<p class="text-sm text-on-surface-variant">
    Kelola arsip dan profil nasabah terdaftar.
</p>

</div>

{{-- =========================================================
ALERT
========================================================= --}}

<div
    id="alertMessage"
    class="hidden mb-5 px-4 py-3 rounded-lg text-sm border"
></div>

{{-- =========================================================
TOOLBAR
========================================================= --}}

<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">

{{-- SEARCH & FILTER --}}

<div class="flex flex-col sm:flex-row w-full md:w-auto items-stretch sm:items-center gap-3">

    {{-- SEARCH --}}

    <div class="relative w-full md:w-80">

        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">
            search
        </span>

        <input
            type="text"
            id="searchInput"
            placeholder="Cari berdasarkan nomor nasabah atau nama..."
            class="w-full pl-10 pr-4 py-2 bg-surface-container-lowest border border-outline-variant rounded-lg text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all"
        >

    </div>


    {{-- STATUS FILTER --}}

    <div class="relative">

        <select
            id="statusFilter"
            class="appearance-none w-full sm:w-auto pl-4 pr-10 py-2 bg-surface-container-lowest border border-outline-variant rounded-lg text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary cursor-pointer"
        >

            <option value="semua">
                Semua Status
            </option>

            <option value="aktif">
                Aktif
            </option>

            <option value="nonaktif">
                Nonaktif
            </option>

        </select>

        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none text-[20px]">
            expand_more
        </span>

    </div>

</div>


{{-- ADD CUSTOMER --}}

<a
    href="{{ route('admin.nasabah.create') }}"
    class="flex items-center justify-center gap-2 px-4 py-2 h-10 bg-primary-container text-on-primary rounded-lg text-sm font-semibold hover:bg-primary transition-colors whitespace-nowrap shadow-sm"
>

    <span class="material-symbols-outlined text-[18px]">
        add
    </span>

    Tambah Nasabah

</a>

</div>

{{-- =========================================================
LOADING
========================================================= --}}

<div
    id="loadingState"
    class="bg-surface-container-lowest border border-outline-variant rounded-xl py-16 text-center"
>

<span class="material-symbols-outlined text-4xl text-primary animate-spin">
    progress_activity
</span>

<p class="mt-3 text-sm text-on-surface-variant">
    Memuat data nasabah...
</p>

</div>

{{-- =========================================================
EMPTY
========================================================= --}}

<div
    id="emptyState"
    class="hidden bg-surface-container-lowest border border-outline-variant rounded-xl py-16 text-center"
>

<span class="material-symbols-outlined text-5xl text-outline">
    person_off
</span>

<p class="mt-3 text-sm font-medium text-on-surface">
    Belum ada data nasabah
</p>

<p class="mt-1 text-sm text-on-surface-variant">
    Data nasabah belum tersedia atau tidak ditemukan.
</p>

</div>

{{-- =========================================================
DATA TABLE
========================================================= --}}

<div
    id="tableContainer"
    class="hidden bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm"
>

<div class="overflow-x-auto">

    <table class="w-full text-left border-collapse">

        <thead class="bg-surface-container-low border-b border-outline-variant">

            <tr class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">

                <th class="px-4 py-3 whitespace-nowrap">
                    Nomor Nasabah
                </th>

                <th class="px-4 py-3 whitespace-nowrap min-w-[180px]">
                    Nama Nasabah
                </th>

                <th class="px-4 py-3 whitespace-nowrap">
                    Lokasi Arsip
                </th>

                <th class="px-4 py-3 whitespace-nowrap text-right">
                    Jumlah Dokumen
                </th>

                <th class="px-4 py-3 whitespace-nowrap">
                    Status
                </th>

                <th class="px-4 py-3 whitespace-nowrap">
                    Terakhir Diperbarui
                </th>

                <th class="px-4 py-3 whitespace-nowrap text-center">
                    Aksi
                </th>

            </tr>

        </thead>


        <tbody
            id="nasabahTable"
            class="text-sm text-on-surface divide-y divide-outline-variant"
        ></tbody>

    </table>

</div>


{{-- =====================================================
     PAGINATION
====================================================== --}}

<div class="flex items-center justify-between px-4 py-3 border-t border-outline-variant bg-surface-container-lowest">

    <div
        id="paginationInfo"
        class="text-sm text-on-surface-variant"
    >
        Menampilkan 0 nasabah
    </div>


    <div class="flex gap-1">

        <button
            type="button"
            id="prevPage"
            class="p-1 rounded text-on-surface hover:bg-surface-container hover:text-on-surface transition-colors disabled:opacity-40 disabled:cursor-not-allowed"
        >

            <span class="material-symbols-outlined text-[20px]">
                chevron_left
            </span>

        </button>


        <button
            type="button"
            id="nextPage"
            class="p-1 rounded text-on-surface hover:bg-surface-container hover:text-on-surface transition-colors disabled:opacity-40 disabled:cursor-not-allowed"
        >

            <span class="material-symbols-outlined text-[20px]">
                chevron_right
            </span>

        </button>

    </div>

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

    const API_URL = '/api/nasabah';


    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    */

    let currentPage = 1;

    let totalPages = 1;


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
        const alert =
            document.getElementById('alertMessage');

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
    | Load Data
    |--------------------------------------------------------------------------
    */

    async function loadNasabah(page = 1)
    {
        const loading =
            document.getElementById('loadingState');

        const empty =
            document.getElementById('emptyState');

        const table =
            document.getElementById('tableContainer');


        const search =
            document.getElementById('searchInput').value.trim();


        const status =
            document.getElementById('statusFilter').value;


        try {

            loading.classList.remove('hidden');

            empty.classList.add('hidden');

            table.classList.add('hidden');


            /*
            |--------------------------------------------------------------------------
            | URL
            |--------------------------------------------------------------------------
            */

            const params =
                new URLSearchParams();


            params.append('page', page);


            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            if (search) {

                params.append('search', search);

            }


            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            if (
                status !== 'semua'
            ) {

                params.append('status', status);

            }


            /*
            |--------------------------------------------------------------------------
            | Request
            |--------------------------------------------------------------------------
            */

            const response =
                await fetch(
                    `${API_URL}?${params.toString()}`,
                    {
                        method: 'GET',
                        headers: getHeaders()
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Token Tidak Valid
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


            /*
            |--------------------------------------------------------------------------
            | JSON
            |--------------------------------------------------------------------------
            */

            const result =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    result.message ||
                    'Gagal mengambil data nasabah.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Pagination
            |--------------------------------------------------------------------------
            */

            currentPage =
                result.current_page || 1;

            totalPages =
                result.last_page || 1;


            /*
            |--------------------------------------------------------------------------
            | Render
            |--------------------------------------------------------------------------
            */

            renderTable(
                result.data || []
            );


            updatePagination(
                result
            );


        } catch (error) {

            console.error(error);

            showAlert(
                error.message ||
                'Terjadi kesalahan saat mengambil data nasabah.',
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

    function renderTable(data)
    {
        const tbody =
            document.getElementById('nasabahTable');

        const table =
            document.getElementById('tableContainer');

        const empty =
            document.getElementById('emptyState');


        tbody.innerHTML = '';


        /*
        |--------------------------------------------------------------------------
        | Empty
        |--------------------------------------------------------------------------
        */

        if (data.length === 0) {

            table.classList.add('hidden');

            empty.classList.remove('hidden');

            return;

        }


        empty.classList.add('hidden');

        table.classList.remove('hidden');


        /*
        |--------------------------------------------------------------------------
        | Generate Row
        |--------------------------------------------------------------------------
        */

        data.forEach(item => {

            const row =
                document.createElement('tr');


            row.className =
                'hover:bg-surface-container-low transition-colors';


            const lokasi =
                item.lokasi_arsip;


            let lokasiText =
                '-';


            if (lokasi) {

                lokasiText =
                    `Rak ${lokasi.rak} - Map ${lokasi.nomor_map}`;

                if (lokasi.posisi) {

                    lokasiText +=
                        ` - Posisi ${lokasi.posisi}`;

                }

            }


            const statusAktif =
                item.status === 'aktif';


            const updatedAt =
                formatDate(item.updated_at);


            row.innerHTML = `

                <td class="px-4 py-3 font-mono text-xs text-on-surface-variant">
                    ${escapeHtml(item.nomor_nasabah)}
                </td>


                <td class="px-4 py-3 font-medium">
                    ${escapeHtml(item.nama)}
                </td>


                <td class="px-4 py-3">

                    <div class="flex items-center gap-1.5">

                        <span class="material-symbols-outlined text-[16px] text-secondary">
                            ${lokasi ? 'folder_open' : 'inventory_2'}
                        </span>

                        ${escapeHtml(lokasiText)}

                    </div>

                </td>


                <td class="px-4 py-3 text-right">

                    ${item.dokumen_count || 0} Dokumen

                </td>


                <td class="px-4 py-3">

                    ${
                        statusAktif

                        ? `

                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-green-50 text-green-700 border border-green-100">
                                Aktif
                            </span>

                        `

                        : `

                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-red-50 text-red-700 border border-red-100">
                                Nonaktif
                            </span>

                        `
                    }

                </td>


                <td class="px-4 py-3 text-on-surface-variant text-sm">

                    ${updatedAt}

                </td>


                <td class="px-4 py-3 text-center whitespace-nowrap">

                    <button
                        type="button"
                        class="detail-button inline-flex items-center justify-center px-3 py-1.5 border border-outline-variant rounded bg-surface-container-lowest text-primary hover:bg-surface-container transition-colors text-xs font-medium h-8"
                        data-id="${item.id}"
                    >
                        Detail
                    </button>


                    ${
                        statusAktif

                        ? `

                            <button
                                type="button"
                                class="deactivate-button inline-flex items-center justify-center px-3 py-1.5 border border-outline-variant rounded bg-surface-container-lowest text-error hover:bg-error-container transition-colors h-8 ml-2"
                                data-id="${item.id}"
                                title="Nonaktifkan"
                            >

                                <span class="material-symbols-outlined text-[18px]">
                                    delete
                                </span>

                            </button>

                        `

                        : ''
                    }

                </td>

            `;


            tbody.appendChild(row);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    function updatePagination(result)
    {
        const info =
            document.getElementById('paginationInfo');


        const from =
            result.from || 0;

        const to =
            result.to || 0;

        const total =
            result.total || 0;


        info.innerHTML = `

            Menampilkan

            <span class="font-medium text-on-surface">
                ${from}-${to}
            </span>

            dari

            <span class="font-medium text-on-surface">
                ${total}
            </span>

            nasabah

        `;


        document.getElementById('prevPage').disabled =
            currentPage <= 1;


        document.getElementById('nextPage').disabled =
            currentPage >= totalPages;

    }


    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    let searchTimer;


    document
        .getElementById('searchInput')
        .addEventListener('input', function () {

            clearTimeout(searchTimer);


            searchTimer =
                setTimeout(() => {

                    loadNasabah(1);

                }, 400);

        });


    /*
    |--------------------------------------------------------------------------
    | Filter Status
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('statusFilter')
        .addEventListener('change', function () {

            loadNasabah(1);

        });


    /*
    |--------------------------------------------------------------------------
    | Pagination Previous
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('prevPage')
        .addEventListener('click', function () {

            if (currentPage > 1) {

                loadNasabah(
                    currentPage - 1
                );

            }

        });


    /*
    |--------------------------------------------------------------------------
    | Pagination Next
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('nextPage')
        .addEventListener('click', function () {

            if (currentPage < totalPages) {

                loadNasabah(
                    currentPage + 1
                );

            }

        });


    /*
    |--------------------------------------------------------------------------
    | Detail & Nonaktifkan
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('nasabahTable')
        .addEventListener('click', async function (event) {


            /*
            |--------------------------------------------------------------------------
            | Detail
            |--------------------------------------------------------------------------
            */

            const detailButton =
                event.target.closest('.detail-button');


            if (detailButton) {

                const id =
                    detailButton.dataset.id;


                window.location.href =
                    `/admin/nasabah/${id}`;

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Nonaktifkan
            |--------------------------------------------------------------------------
            */

            const deactivateButton =
                event.target.closest('.deactivate-button');


            if (!deactivateButton) {

                return;

            }


            const id =
                deactivateButton.dataset.id;


            const konfirmasi =
                confirm(
                    'Apakah Anda yakin ingin menonaktifkan nasabah ini?'
                );


            if (!konfirmasi) {

                return;

            }


            try {

                const response =
                    await fetch(
                        `${API_URL}/${id}/nonaktifkan`,
                        {
                            method: 'PATCH',
                            headers: getHeaders()
                        }
                    );


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


                if (!response.ok) {

                    throw new Error(
                        result.message ||
                        'Gagal menonaktifkan nasabah.'
                    );

                }


                showAlert(
                    result.message ||
                    'Nasabah berhasil dinonaktifkan.',
                    'success'
                );


                await loadNasabah(
                    currentPage
                );


            } catch (error) {

                console.error(error);

                showAlert(
                    error.message ||
                    'Terjadi kesalahan saat menonaktifkan nasabah.',
                    'error'
                );

            }

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
            value ?? '';

        return div.innerHTML;
    }


    /*
    |--------------------------------------------------------------------------
    | Format Date
    |--------------------------------------------------------------------------
    */

    function formatDate(dateString)
    {
        if (!dateString) {

            return '-';

        }


        const date =
            new Date(dateString);


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
    | Initial Load
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            loadNasabah(1);

        }
    );

</script>

@endpush