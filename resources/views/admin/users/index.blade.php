@extends('layouts.admin')

@section('title', 'SIP-PANDU | Kelola User')

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
    Kelola User
</span>
@endsection

@section('content')

{{-- ALERT NOTIFICATION --}}

<div
    id="alertMessage"
    class="hidden mb-5 px-4 py-3 rounded-lg text-sm border font-medium"
></div>

{{-- PAGE HEADER --}}

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="font-headline-md text-headline-md text-on-surface font-semibold">
            Kelola User
        </h2>
        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
            Manajemen akses admin dan petugas sistem.
        </p>
    </div>

<a
    href="{{ route('admin.users.create') }}"
    class="inline-flex items-center justify-center gap-2 bg-primary-container text-on-primary px-4 py-2.5 rounded-lg hover:bg-primary transition-colors font-label-md text-label-md font-medium shadow-sm"
>
    <span class="material-symbols-outlined text-[18px]">add</span>
    Tambah User
</a>

</div>

{{-- DATA TABLE CARD --}}

<div class="bg-surface-container-lowest rounded-lg border border-outline-variant overflow-hidden shadow-sm">

{{-- TABLE CONTROLS --}}
<div class="p-4 border-b border-outline-variant flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-surface-container-lowest">

    {{-- SHOW PER PAGE --}}
    <div class="flex items-center gap-2">
        <span class="font-label-md text-label-md text-on-surface-variant">
            Tampilkan
        </span>

        <select
            id="perPageSelect"
            class="border border-outline-variant rounded px-2 py-1 bg-surface-container-lowest font-body-sm text-body-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none"
        >
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>

        <span class="font-label-md text-label-md text-on-surface-variant">
            entri
        </span>
    </div>

    {{-- SEARCH & FILTER TOOLBAR --}}
    <div class="flex flex-wrap items-center gap-2">

        {{-- SEARCH INPUT --}}
        <div class="relative flex-1 sm:w-64">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">
                search
            </span>

            <input
                type="text"
                id="searchUserInput"
                placeholder="Cari nama, username, ID..."
                class="pl-9 pr-4 py-1.5 w-full rounded bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-sm text-body-sm text-on-surface transition-all"
            />
        </div>

        {{-- FILTER ROLE --}}
        <select
            id="filterRole"
            class="border border-outline-variant rounded px-3 py-1.5 bg-surface-container-lowest font-body-sm text-body-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none"
        >
            <option value="">Semua Peran</option>
            <option value="admin">Admin</option>
            <option value="petugas">Petugas</option>
        </select>

        {{-- FILTER STATUS --}}
        <select
            id="filterStatus"
            class="border border-outline-variant rounded px-3 py-1.5 bg-surface-container-lowest font-body-sm text-body-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none"
        >
            <option value="">Semua Status</option>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Non-aktif</option>
        </select>

    </div>

</div>

{{-- TABLE CONTAINER --}}
<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse min-w-[800px]">

        <thead>
            <tr class="bg-surface-container-low border-b border-outline-variant font-label-bold text-label-bold text-on-surface uppercase tracking-wider text-xs">
                <th class="p-3.5 pl-5">Nama & User</th>
                <th class="p-3.5">Email</th>
                <th class="p-3.5">Peran</th>
                <th class="p-3.5">Status</th>
                <th class="p-3.5 pr-5 text-right">Aksi</th>
            </tr>
        </thead>

        <tbody
            id="userTableBody"
            class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant/60"
        >
        </tbody>

    </table>
</div>

{{-- EMPTY STATE --}}
<div id="emptyUserState" class="hidden p-10 text-center">

    <div class="w-12 h-12 rounded-full bg-surface-container-low text-on-surface-variant flex items-center justify-center mx-auto mb-3">
        <span class="material-symbols-outlined text-2xl">
            group_off
        </span>
    </div>

    <p class="text-sm font-semibold text-on-surface">
        Data User Tidak Ditemukan
    </p>

    <p class="text-xs text-on-surface-variant mt-1">
        Tidak ada data user yang sesuai dengan pencarian atau filter Anda.
    </p>

</div>

{{-- PAGINATION & FOOTER --}}
<div class="p-4 border-t border-outline-variant flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-surface-container-lowest">

    <span
        id="paginationInfo"
        class="font-label-md text-label-md text-on-surface-variant"
    >
        Menampilkan 0 data
    </span>

    <div
        id="paginationControls"
        class="flex gap-1"
    >
    </div>

</div>

</div>

{{-- MODAL TAMBAH / EDIT USER --}}

<div
    id="userModal"
    class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden p-4 backdrop-blur-sm"
>
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-xl w-full max-w-lg overflow-hidden transition-all">

    {{-- MODAL HEADER --}}
    <div class="px-6 py-4 border-b border-outline-variant flex items-center justify-between bg-surface-container-low">

        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-[22px]">
                manage_accounts
            </span>

            <h3
                id="modalTitle"
                class="font-title-sm text-title-sm text-on-surface"
            >
                Tambah User Baru
            </h3>
        </div>

        <button
            type="button"
            id="btnCloseModal"
            class="text-on-surface-variant hover:text-on-surface p-1 rounded hover:bg-surface-container-high transition-colors"
        >
            <span class="material-symbols-outlined text-[20px]">
                close
            </span>
        </button>

    </div>

    {{-- MODAL FORM --}}
    <form
        id="userForm"
        class="p-6 space-y-4"
    >

        <input
            type="hidden"
            id="userId"
        />

        {{-- NAMA LENGKAP --}}
        <div>
            <label class="block text-xs font-semibold text-on-surface uppercase tracking-wider mb-1.5">
                Nama Lengkap <span class="text-error">*</span>
            </label>

            <input
                type="text"
                id="inputName"
                required
                placeholder="Masukkan nama lengkap"
                class="w-full px-3.5 py-2 rounded bg-surface-container-low border border-outline-variant text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none"
            />
        </div>

        {{-- ID PEGAWAI --}}
        <div>
            <label class="block text-xs font-semibold text-on-surface uppercase tracking-wider mb-1.5">
                ID Pegawai <span class="text-error">*</span>
            </label>

            <input
                type="text"
                id="inputIdPegawai"
                required
                placeholder="Masukkan NIP / ID Pegawai"
                class="w-full px-3.5 py-2 rounded bg-surface-container-low border border-outline-variant text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none"
            />
        </div>

        {{-- USERNAME --}}
        <div>
            <label class="block text-xs font-semibold text-on-surface uppercase tracking-wider mb-1.5">
                Username <span class="text-error">*</span>
            </label>

            <input
                type="text"
                id="inputUsername"
                required
                placeholder="Masukkan username login"
                class="w-full px-3.5 py-2 rounded bg-surface-container-low border border-outline-variant text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none"
            />
        </div>

        {{-- EMAIL --}}
        <div>
            <label class="block text-xs font-semibold text-on-surface uppercase tracking-wider mb-1.5">
                Email
            </label>

            <input
                type="email"
                id="inputEmail"
                placeholder="nama@bank.co.id"
                class="w-full px-3.5 py-2 rounded bg-surface-container-low border border-outline-variant text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none"
            />
        </div>

        {{-- PASSWORD --}}
        <div>
            <label class="block text-xs font-semibold text-on-surface uppercase tracking-wider mb-1.5">
                Password
                <span id="passwordRequired" class="text-error">*</span>
            </label>

            <input
                type="password"
                id="inputPassword"
                placeholder="Minimal 8 karakter"
                class="w-full px-3.5 py-2 rounded bg-surface-container-low border border-outline-variant text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none"
            />

            <p
                id="passwordHelp"
                class="text-[11px] text-on-surface-variant mt-1 hidden"
            >
                Kosongkan password jika tidak ingin mengganti password lama.
            </p>
        </div>

        {{-- MODAL FOOTER --}}
        <div class="pt-4 border-t border-outline-variant flex items-center justify-end gap-3">

            <button
                type="button"
                id="btnCancelModal"
                class="px-4 py-2 rounded border border-outline-variant text-on-surface-variant hover:bg-surface-container-low text-xs font-medium transition-colors"
            >
                Batal
            </button>

            <button
                type="submit"
                id="btnSubmitModal"
                class="px-4 py-2 rounded bg-primary text-on-primary hover:bg-primary-container text-xs font-medium transition-colors flex items-center gap-1.5 shadow-sm"
            >
                <span class="material-symbols-outlined text-[16px]">
                    save
                </span>

                <span id="submitText">
                    Simpan User
                </span>
            </button>

        </div>

    </form>

</div>

</div>

@endsection

@push('scripts')

<script>

    /*
    |--------------------------------------------------------------------------
    | INITIAL DATA & CONSTANTS
    |--------------------------------------------------------------------------
    */

    const USERS_AWAL = @json($users);
    const USERS_API = '/api/users';

    let allUsers = Array.isArray(USERS_AWAL)
        ? USERS_AWAL
        : [];

    let filteredUsers = [...allUsers];

    let currentPage = 1;
    let perPage = 10;


    /*
    |--------------------------------------------------------------------------
    | AUTH HEADERS
    |--------------------------------------------------------------------------
    */

    function getHeaders() {

        const token = localStorage.getItem('sip_pandu_token');

        const headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN':
                document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute('content') || ''
        };

        if (
            token &&
            token !== 'null' &&
            token !== 'undefined'
        ) {
            headers['Authorization'] = `Bearer ${token}`;
        }

        return headers;
    }


    /*
    |--------------------------------------------------------------------------
    | ALERT HELPER
    |--------------------------------------------------------------------------
    */

    function showAlert(
        message,
        type = 'success'
    ) {

        const alert =
            document.getElementById('alertMessage');

        alert.textContent = message;

        alert.className =
            'mb-5 px-4 py-3 rounded-lg text-sm border font-medium ';

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

        alert.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        setTimeout(() => {
            alert.classList.add('hidden');
        }, 4000);
    }


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(str) {

        if (!str) {
            return '-';
        }

        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }


    /*
    |--------------------------------------------------------------------------
    | GET INITIALS FOR AVATAR
    |--------------------------------------------------------------------------
    */

    function getInitials(name) {

        if (!name) {
            return 'US';
        }

        const parts =
            name.trim().split(' ');

        if (parts.length >= 2) {

            return (
                parts[0][0] +
                parts[1][0]
            ).toUpperCase();
        }

        return name
            .slice(0, 2)
            .toUpperCase();
    }


    /*
    |--------------------------------------------------------------------------
    | AVATAR COLOR PALETTE
    |--------------------------------------------------------------------------
    */

    function getAvatarBg(name) {

        const colors = [
            'bg-secondary-container text-on-secondary-container',
            'bg-tertiary-container text-on-tertiary-container',
            'bg-primary-container text-on-primary-container',
            'bg-surface-variant text-on-surface-variant'
        ];

        let hash = 0;

        for (
            let i = 0;
            i < (name || '').length;
            i++
        ) {
            hash += name.charCodeAt(i);
        }

        return colors[
            hash % colors.length
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | GET AVATAR URL
    |--------------------------------------------------------------------------
    */

    function getAvatarUrl(user) {

        if (
            !user ||
            !user.avatar_url
        ) {
            return null;
        }

        return user.avatar_url;
    }


    /*
    |--------------------------------------------------------------------------
    | RENDER AVATAR
    |--------------------------------------------------------------------------
    */

    function renderAvatar(user) {

        const initials =
            getInitials(user.name);

        const avatarBg =
            getAvatarBg(user.name);

        const avatarUrl =
            getAvatarUrl(user);

        if (avatarUrl) {

            return `
                <img
                    src="${escapeHtml(avatarUrl)}"
                    alt="${escapeHtml(user.name)}"
                    class="w-8 h-8 rounded-full object-cover border border-outline-variant flex-shrink-0"
                    onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');"
                >

                <div
                    class="hidden w-8 h-8 rounded-full ${avatarBg} items-center justify-center font-bold text-xs flex-shrink-0"
                >
                    ${initials}
                </div>
            `;

        }

        return `
            <div
                class="w-8 h-8 rounded-full ${avatarBg} flex items-center justify-center font-bold text-xs flex-shrink-0"
            >
                ${initials}
            </div>
        `;
    }


    /*
    |--------------------------------------------------------------------------
    | RENDER TABLE
    |--------------------------------------------------------------------------
    */

    function renderUserTable() {

        const tbody =
            document.getElementById(
                'userTableBody'
            );

        const emptyState =
            document.getElementById(
                'emptyUserState'
            );

        const paginationInfo =
            document.getElementById(
                'paginationInfo'
            );

        const paginationControls =
            document.getElementById(
                'paginationControls'
            );


        /*
        |--------------------------------------------------------------------------
        | EMPTY DATA
        |--------------------------------------------------------------------------
        */

        if (
            filteredUsers.length === 0
        ) {

            tbody.innerHTML = '';

            emptyState.classList.remove(
                'hidden'
            );

            paginationInfo.textContent =
                'Menampilkan 0 data';

            paginationControls.innerHTML =
                '';

            return;
        }


        emptyState.classList.add(
            'hidden'
        );


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        const totalItems =
            filteredUsers.length;

        const totalPages =
            Math.ceil(
                totalItems / perPage
            );

        if (
            currentPage > totalPages
        ) {
            currentPage = totalPages;
        }

        if (
            currentPage < 1
        ) {
            currentPage = 1;
        }

        const startIndex =
            (currentPage - 1) *
            perPage;

        const endIndex =
            Math.min(
                startIndex + perPage,
                totalItems
            );

        const pageUsers =
            filteredUsers.slice(
                startIndex,
                endIndex
            );


        /*
        |--------------------------------------------------------------------------
        | TABLE ROWS
        |--------------------------------------------------------------------------
        */

        tbody.innerHTML =
            pageUsers.map(user => {

                const isAktif =
                    String(
                        user.status || ''
                    ).toLowerCase() === 'aktif';

                const isPetugas =
                    String(
                        user.role || ''
                    ).toLowerCase() === 'petugas';


                return `
                    <tr
                        class="border-b border-outline-variant/60 hover:bg-surface-bright transition-colors ${!isAktif ? 'bg-surface-bright/50' : ''}"
                    >

                        {{-- NAMA & USER --}}
                        <td class="p-3.5 pl-5">

                            <div
                                class="flex items-center gap-3 ${!isAktif ? 'opacity-60' : ''}"
                            >

                                ${renderAvatar(user)}

                                <div>

                                    <div class="font-medium text-on-surface">
                                        ${escapeHtml(user.name)}
                                    </div>

                                    <div class="text-xs text-on-surface-variant font-mono">

                                        ${escapeHtml(user.username)}

                                        ${
                                            user.id_pegawai
                                                ? '• ID: ' +
                                                  escapeHtml(user.id_pegawai)
                                                : ''
                                        }

                                    </div>

                                </div>

                            </div>

                        </td>


                        {{-- EMAIL --}}
                        <td
                            class="p-3.5 text-on-surface-variant text-sm ${!isAktif ? 'opacity-60' : ''}"
                        >
                            ${escapeHtml(user.email || '-')}
                        </td>


                        {{-- ROLE --}}
                        <td
                            class="p-3.5 ${!isAktif ? 'opacity-60' : ''}"
                        >

                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold ${
                                    user.role === 'admin'
                                        ? 'bg-primary/10 text-primary border border-primary/20'
                                        : 'bg-surface-container text-on-surface-variant border border-outline-variant'
                                }"
                            >
                                ${
                                    user.role
                                        ? user.role
                                            .charAt(0)
                                            .toUpperCase() +
                                          user.role.slice(1)
                                        : 'User'
                                }
                            </span>

                        </td>


                        {{-- STATUS --}}
                        <td class="p-3.5">

                            ${
                                isAktif

                                    ? `
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-[#E6F4EA] text-[#137333] border border-[#CEEAD6]"
                                        >
                                            Aktif
                                        </span>
                                      `

                                    : `
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-[#FCE8E6] text-[#C5221F] border border-[#FAD2CF]"
                                        >
                                            Non-aktif
                                        </span>
                                      `
                            }

                        </td>


                        {{-- AKSI --}}
                        <td
                            class="p-3.5 pr-5 text-right"
                        >

                            <div
                                class="flex items-center justify-end gap-1.5"
                            >

                                ${
                                    isPetugas

                                        ? `

                                            {{-- EDIT --}}
                                            <button
                                                type="button"
                                                onclick="editUser(${user.id})"
                                                class="w-8 h-8 rounded border border-outline-variant text-on-surface-variant hover:text-primary hover:border-primary hover:bg-surface-container transition-all flex items-center justify-center"
                                                title="Edit User"
                                            >
                                                <span class="material-symbols-outlined text-[18px]">
                                                    edit
                                                </span>
                                            </button>


                                            {{-- AKTIF / NONAKTIF --}}
                                            <button
                                                type="button"
                                                onclick="toggleUserStatus(${user.id}, ${isAktif})"
                                                class="w-8 h-8 rounded border border-outline-variant ${
                                                    isAktif
                                                        ? 'text-amber-700 hover:bg-amber-50 hover:border-amber-600'
                                                        : 'text-emerald-700 hover:bg-emerald-50 hover:border-emerald-600'
                                                } transition-all flex items-center justify-center"
                                                title="${
                                                    isAktif
                                                        ? 'Nonaktifkan'
                                                        : 'Aktifkan'
                                                }"
                                            >
                                                <span class="material-symbols-outlined text-[18px]">
                                                    ${
                                                        isAktif
                                                            ? 'block'
                                                            : 'check_circle'
                                                    }
                                                </span>
                                            </button>


                                            {{-- DELETE --}}
                                            <button
                                                type="button"
                                                onclick="deleteUser(${user.id})"
                                                class="w-8 h-8 rounded border border-outline-variant text-error hover:bg-error-container hover:border-error transition-all flex items-center justify-center"
                                                title="Hapus Permanen"
                                            >
                                                <span class="material-symbols-outlined text-[18px]">
                                                    delete
                                                </span>
                                            </button>

                                          `

                                        : `
                                            <span
                                                class="text-xs text-on-surface-variant/50 italic px-2"
                                            >
                                                Super Admin
                                            </span>
                                          `
                                }

                            </div>

                        </td>

                    </tr>
                `;

            }).join('');


        /*
        |--------------------------------------------------------------------------
        | PAGINATION INFO
        |--------------------------------------------------------------------------
        */

        paginationInfo.textContent =
            `Menampilkan ${startIndex + 1} hingga ${endIndex} dari ${totalItems} entri`;


        /*
        |--------------------------------------------------------------------------
        | PAGINATION BUTTONS
        |--------------------------------------------------------------------------
        */

        let navHtml = '';


        // Previous
        navHtml += `
            <button
                type="button"
                onclick="changePage(${currentPage - 1})"
                ${
                    currentPage === 1
                        ? `
                            disabled
                            class="px-3 py-1 border border-outline-variant rounded text-on-surface-variant opacity-40 cursor-not-allowed font-label-md text-label-md"
                          `
                        : `
                            class="px-3 py-1 border border-outline-variant rounded text-on-surface-variant hover:bg-surface-container-low transition-colors font-label-md text-label-md"
                          `
                }
            >
                Sebelumnya
            </button>
        `;


        // Page numbers
        for (
            let p = 1;
            p <= totalPages;
            p++
        ) {

            if (
                p === currentPage
            ) {

                navHtml += `
                    <button
                        type="button"
                        class="px-3 py-1 bg-primary text-on-primary rounded font-label-md text-label-md font-semibold"
                    >
                        ${p}
                    </button>
                `;

            } else if (
                p === 1 ||
                p === totalPages ||
                (
                    p >= currentPage - 1 &&
                    p <= currentPage + 1
                )
            ) {

                navHtml += `
                    <button
                        type="button"
                        onclick="changePage(${p})"
                        class="px-3 py-1 border border-outline-variant rounded text-on-surface-variant hover:bg-surface-container-low transition-colors font-label-md text-label-md"
                    >
                        ${p}
                    </button>
                `;
            }
        }


        // Next
        navHtml += `
            <button
                type="button"
                onclick="changePage(${currentPage + 1})"
                ${
                    currentPage === totalPages ||
                    totalPages === 0
                        ? `
                            disabled
                            class="px-3 py-1 border border-outline-variant rounded text-on-surface-variant opacity-40 cursor-not-allowed font-label-md text-label-md"
                          `
                        : `
                            class="px-3 py-1 border border-outline-variant rounded text-on-surface-variant hover:bg-surface-container-low transition-colors font-label-md text-label-md"
                          `
                }
            >
                Selanjutnya
            </button>
        `;


        paginationControls.innerHTML =
            navHtml;
    }


    /*
    |--------------------------------------------------------------------------
    | CHANGE PAGE
    |--------------------------------------------------------------------------
    */

    function changePage(page) {

        currentPage = page;

        renderUserTable();
    }


    /*
    |--------------------------------------------------------------------------
    | FILTER & SEARCH
    |--------------------------------------------------------------------------
    */

    function applyFilters() {

        const searchKeyword =
            document
                .getElementById('searchUserInput')
                .value
                .trim()
                .toLowerCase();

        const roleKeyword =
            document
                .getElementById('filterRole')
                .value
                .toLowerCase();

        const statusKeyword =
            document
                .getElementById('filterStatus')
                .value
                .toLowerCase();


        filteredUsers =
            allUsers.filter(user => {

                const matchSearch =
                    (user.name || '')
                        .toLowerCase()
                        .includes(searchKeyword)

                    ||

                    (user.username || '')
                        .toLowerCase()
                        .includes(searchKeyword)

                    ||

                    (user.id_pegawai || '')
                        .toLowerCase()
                        .includes(searchKeyword)

                    ||

                    (user.email || '')
                        .toLowerCase()
                        .includes(searchKeyword);


                const matchRole =
                    !roleKeyword ||

                    String(
                        user.role || ''
                    ).toLowerCase() ===
                    roleKeyword;


                const matchStatus =
                    !statusKeyword ||

                    String(
                        user.status || ''
                    ).toLowerCase() ===
                    statusKeyword;


                return (
                    matchSearch &&
                    matchRole &&
                    matchStatus
                );
            });


        currentPage = 1;

        renderUserTable();
    }


    /*
    |--------------------------------------------------------------------------
    | FILTER EVENTS
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('searchUserInput')
        .addEventListener(
            'input',
            applyFilters
        );

    document
        .getElementById('filterRole')
        .addEventListener(
            'change',
            applyFilters
        );

    document
        .getElementById('filterStatus')
        .addEventListener(
            'change',
            applyFilters
        );


    document
        .getElementById('perPageSelect')
        .addEventListener(
            'change',
            function () {

                perPage =
                    parseInt(this.value) ||
                    10;

                currentPage = 1;

                renderUserTable();
            }
        );


    /*
    |--------------------------------------------------------------------------
    | FETCH FRESH DATA FROM API
    |--------------------------------------------------------------------------
    */

    async function fetchUsers() {

        try {

            const response =
                await fetch(
                    USERS_API,
                    {
                        method: 'GET',
                        headers: getHeaders()
                    }
                );


            if (!response.ok) {
                return;
            }


            const result =
                await response.json();


            if (
                result &&
                Array.isArray(result.data)
            ) {

                allUsers =
                    result.data;

                applyFilters();
            }

        } catch (e) {

            console.warn(
                'Gagal sync data API, menggunakan data awal Blade:',
                e
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | MODAL LOGIC
    |--------------------------------------------------------------------------
    */

    const userModal =
        document.getElementById(
            'userModal'
        );

    const modalTitle =
        document.getElementById(
            'modalTitle'
        );

    const userForm =
        document.getElementById(
            'userForm'
        );

    const userIdInput =
        document.getElementById(
            'userId'
        );

    const nameInput =
        document.getElementById(
            'inputName'
        );

    const idPegawaiInput =
        document.getElementById(
            'inputIdPegawai'
        );

    const usernameInput =
        document.getElementById(
            'inputUsername'
        );

    const emailInput =
        document.getElementById(
            'inputEmail'
        );

    const passwordInput =
        document.getElementById(
            'inputPassword'
        );

    const passwordRequired =
        document.getElementById(
            'passwordRequired'
        );

    const passwordHelp =
        document.getElementById(
            'passwordHelp'
        );

    const submitText =
        document.getElementById(
            'submitText'
        );


    /*
    |--------------------------------------------------------------------------
    | OPEN CREATE MODAL
    |--------------------------------------------------------------------------
    */

    function openCreateModal() {

        userIdInput.value = '';

        modalTitle.textContent =
            'Tambah User Baru';

        submitText.textContent =
            'Simpan User';

        userForm.reset();

        passwordInput.required =
            true;

        passwordRequired.classList
            .remove('hidden');

        passwordHelp.classList
            .add('hidden');

        userModal.classList
            .remove('hidden');
    }


    /*
    |--------------------------------------------------------------------------
    | CLOSE MODAL
    |--------------------------------------------------------------------------
    */

    function closeModal() {

        userModal.classList
            .add('hidden');
    }


    /*
    |--------------------------------------------------------------------------
    | MODAL BUTTON EVENTS
    |--------------------------------------------------------------------------
    */

    const btnTambahUser =
        document.getElementById(
            'btnTambahUser'
        );

    if (btnTambahUser) {

        btnTambahUser.addEventListener(
            'click',
            openCreateModal
        );
    }


    const btnCloseModal =
        document.getElementById(
            'btnCloseModal'
        );

    if (btnCloseModal) {

        btnCloseModal.addEventListener(
            'click',
            closeModal
        );
    }


    const btnCancelModal =
        document.getElementById(
            'btnCancelModal'
        );

    if (btnCancelModal) {

        btnCancelModal.addEventListener(
            'click',
            closeModal
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT USER
    |--------------------------------------------------------------------------
    */

    function editUser(id) {

        window.location.href =
            `/admin/users/${id}/edit`;
    }


    /*
    |--------------------------------------------------------------------------
    | SUBMIT FORM CREATE / UPDATE
    |--------------------------------------------------------------------------
    */

    if (userForm) {

        userForm.addEventListener(
            'submit',
            async function (e) {

                e.preventDefault();


                const id =
                    userIdInput.value;

                const isEdit =
                    Boolean(id);


                const payload = {

                    name:
                        nameInput.value.trim(),

                    id_pegawai:
                        idPegawaiInput.value.trim(),

                    username:
                        usernameInput.value.trim(),

                    email:
                        emailInput.value.trim() ||
                        null,
                };


                if (
                    passwordInput.value.trim()
                ) {

                    payload.password =
                        passwordInput.value.trim();
                }


                const url =
                    isEdit
                        ? `${USERS_API}/${id}`
                        : USERS_API;

                const method =
                    isEdit
                        ? 'PUT'
                        : 'POST';


                const btnSubmit =
                    document.getElementById(
                        'btnSubmitModal'
                    );


                btnSubmit.disabled =
                    true;

                btnSubmit.classList.add(
                    'opacity-50'
                );


                try {

                    const response =
                        await fetch(
                            url,
                            {
                                method: method,
                                headers: getHeaders(),
                                body: JSON.stringify(payload)
                            }
                        );


                    const result =
                        await response.json();


                    if (!response.ok) {

                        throw new Error(
                            result.message ||
                            'Gagal menyimpan data user.'
                        );
                    }


                    showAlert(
                        result.message ||
                        (
                            isEdit
                                ? 'Data user berhasil diperbarui.'
                                : 'Petugas baru berhasil ditambahkan.'
                        ),
                        'success'
                    );


                    closeModal();

                    fetchUsers();


                } catch (err) {

                    showAlert(
                        err.message ||
                        'Terjadi kesalahan.',
                        'error'
                    );

                } finally {

                    btnSubmit.disabled =
                        false;

                    btnSubmit.classList.remove(
                        'opacity-50'
                    );
                }
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TOGGLE USER STATUS
    |--------------------------------------------------------------------------
    */

    async function toggleUserStatus(
        id,
        currentlyActive
    ) {

        const actionText =
            currentlyActive
                ? 'menonaktifkan'
                : 'mengaktifkan kembali';


        if (
            !confirm(
                `Apakah Anda yakin ingin ${actionText} user ini?`
            )
        ) {
            return;
        }


        const endpoint =
            currentlyActive
                ? `${USERS_API}/${id}/nonaktifkan`
                : `${USERS_API}/${id}/aktifkan`;


        try {

            const response =
                await fetch(
                    endpoint,
                    {
                        method: 'PATCH',
                        headers: getHeaders()
                    }
                );


            const result =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    result.message ||
                    `Gagal ${actionText} user.`
                );
            }


            showAlert(
                result.message ||
                'User berhasil diubah statusnya.',
                'success'
            );


            fetchUsers();


        } catch (err) {

            showAlert(
                err.message ||
                'Terjadi kesalahan.',
                'error'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE USER PERMANEN
    |--------------------------------------------------------------------------
    */

    async function deleteUser(id) {

        const user =
            allUsers.find(
                u =>
                    Number(u.id) ===
                    Number(id)
            );


        const name =
            user
                ? user.name
                : 'user ini';


        if (
            !confirm(
                `Apakah Anda yakin ingin MENGHAPUS PERMANEN user "${name}"? Data yang dihapus tidak dapat dikembalikan.`
            )
        ) {
            return;
        }


        try {

            const response =
                await fetch(
                    `${USERS_API}/${id}`,
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
                    'Gagal menghapus user.'
                );
            }


            showAlert(
                result.message ||
                'User berhasil dihapus.',
                'success'
            );


            fetchUsers();


        } catch (err) {

            showAlert(
                err.message ||
                'Terjadi kesalahan saat menghapus user.',
                'error'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | INITIAL RUN
    |--------------------------------------------------------------------------
    */

    renderUserTable();

    fetchUsers();

</script>

@endpush