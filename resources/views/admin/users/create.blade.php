@extends('layouts.admin')

@section('title', 'SIP-PANDU | Tambah User')

@section('breadcrumb')
<a
    href="{{ route('admin.dashboard') }}"
    class="text-sm text-on-surface-variant hover:text-primary transition-colors"
>
    Beranda
</a>
<span class="material-symbols-outlined text-[18px] text-on-surface-variant">
    chevron_right
</span>
<a
    href="{{ route('admin.users') }}"
    class="text-sm text-on-surface-variant hover:text-primary transition-colors"
>
    Kelola User
</a>
<span class="material-symbols-outlined text-[18px] text-on-surface-variant">
    chevron_right
</span>
<span class="text-sm font-medium text-primary">
    Tambah User
</span>
@endsection

@section('content')

{{-- PAGE HEADER --}}
<div class="mb-8">
    <h1 class="text-2xl font-semibold text-on-surface">
        Tambah User Baru
    </h1>
    <p class="mt-1 text-sm text-on-surface-variant">
        Masukkan informasi akun untuk menambahkan petugas atau admin baru.
    </p>
</div>

{{-- ALERT --}}
<div
    id="alertMessage"
    class="hidden mb-6 px-4 py-3 rounded-lg text-sm border font-medium"
></div>

{{-- FORM CARD --}}
<div class="max-w-3xl bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-8">

    <form id="formTambahUser">
        <div class="space-y-6">

            {{-- NAMA LENGKAP --}}
            <div>
                <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-on-surface mb-2">
                    Nama Lengkap <span class="text-error">*</span>
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    required
                    placeholder="Contoh: Ahmad Syafiq"
                    class="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface text-sm text-on-surface placeholder:text-on-surface-variant/60 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-shadow"
                />
            </div>

            {{-- ID PEGAWAI --}}
            <div>
                <label for="id_pegawai" class="block text-xs font-semibold uppercase tracking-wider text-on-surface mb-2">
                    ID Pegawai / NIP <span class="text-error">*</span>
                </label>
                <input
                    type="text"
                    id="id_pegawai"
                    name="id_pegawai"
                    required
                    placeholder="Contoh: PEG-2026-001"
                    class="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface text-sm text-on-surface placeholder:text-on-surface-variant/60 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-shadow"
                />
            </div>

            {{-- USERNAME --}}
            <div>
                <label for="username" class="block text-xs font-semibold uppercase tracking-wider text-on-surface mb-2">
                    Username Login <span class="text-error">*</span>
                </label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                    placeholder="Contoh: ahmadsyafiq"
                    class="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface text-sm text-on-surface placeholder:text-on-surface-variant/60 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-shadow"
                />
            </div>

            {{-- EMAIL --}}
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-on-surface mb-2">
                    Alamat Email
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Contoh: ahmad.syafiq@bank.co.id"
                    class="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface text-sm text-on-surface placeholder:text-on-surface-variant/60 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-shadow"
                />
            </div>

            {{-- PASSWORD --}}
            <div>
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-on-surface mb-2">
                    Password <span class="text-error">*</span>
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    minlength="8"
                    placeholder="Minimal 8 karakter"
                    class="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface text-sm text-on-surface placeholder:text-on-surface-variant/60 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-shadow"
                />
            </div>

        </div>

        {{-- ACTIONS --}}
        <div class="mt-8 pt-6 border-t border-outline-variant flex items-center justify-end gap-4">
            
            <a
                href="{{ route('admin.users') }}"
                class="px-6 py-2.5 border border-outline-variant rounded-lg text-secondary text-xs font-medium hover:bg-surface-container-low transition-colors"
            >
                Batal
            </a>

            <button
                type="submit"
                id="btnSimpan"
                class="px-6 py-2.5 bg-primary-container text-white rounded-lg text-xs font-medium hover:bg-primary transition-colors shadow-sm inline-flex items-center gap-2"
            >
                <span id="loadingIcon" class="material-symbols-outlined text-[18px] hidden">
                    progress_activity
                </span>
                <span id="buttonText">
                    Simpan User Baru
                </span>
            </button>

        </div>
    </form>

</div>

@endsection

@push('scripts')
<script>
    const API_URL = '/api/users';

    const form = document.getElementById('formTambahUser');
    const btnSimpan = document.getElementById('btnSimpan');
    const buttonText = document.getElementById('buttonText');
    const loadingIcon = document.getElementById('loadingIcon');
    const alertMessage = document.getElementById('alertMessage');

    function getToken() {
        return localStorage.getItem('sip_pandu_token');
    }

    function getHeaders() {
        const token = localStorage.getItem('sip_pandu_token');
        const headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        };
        if (token && token !== 'null' && token !== 'undefined') {
            headers['Authorization'] = `Bearer ${token}`;
        }
        return headers;
    }

    function showAlert(message, type = 'success') {
        alertMessage.textContent = message;
        alertMessage.className = 'mb-6 px-4 py-3 rounded-lg text-sm border font-medium ';

        if (type === 'success') {
            alertMessage.classList.add('bg-green-50', 'text-green-700', 'border-green-200');
        } else {
            alertMessage.classList.add('bg-red-50', 'text-red-700', 'border-red-200');
        }

        alertMessage.classList.remove('hidden');
        alertMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function setLoading(loading) {
        btnSimpan.disabled = loading;
        if (loading) {
            loadingIcon.classList.remove('hidden');
            loadingIcon.classList.add('animate-spin');
            buttonText.textContent = 'Menyimpan...';
            btnSimpan.classList.add('opacity-70', 'cursor-not-allowed');
        } else {
            loadingIcon.classList.add('hidden');
            loadingIcon.classList.remove('animate-spin');
            buttonText.textContent = 'Simpan User Baru';
            btnSimpan.classList.remove('opacity-70', 'cursor-not-allowed');
        }
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const name = document.getElementById('name').value.trim();
        const id_pegawai = document.getElementById('id_pegawai').value.trim();
        const username = document.getElementById('username').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();

        if (!name || !id_pegawai || !username || !password) {
            showAlert('Mohon lengkapi semua bidang wajib (*).', 'error');
            return;
        }

        setLoading(true);

        try {
            const response = await fetch(API_URL, {
                method: 'POST',
                headers: getHeaders(),
                body: JSON.stringify({
                    name,
                    id_pegawai,
                    username,
                    email: email || null,
                    password
                })
            });

            const result = await response.json();

            if (response.status === 422) {
                let message = 'Data yang dimasukkan tidak valid.';
                if (result.errors) {
                    const errors = Object.values(result.errors).flat();
                    if (errors.length > 0) message = errors[0];
                }
                showAlert(message, 'error');
                return;
            }

            if (!response.ok) {
                throw new Error(result.message || 'Gagal menambahkan user baru.');
            }

            showAlert(result.message || 'Petugas baru berhasil ditambahkan.', 'success');

            setTimeout(() => {
                window.location.href = "{{ route('admin.users') }}";
            }, 1000);

        } catch (error) {
            showAlert(error.message || 'Terjadi kesalahan saat menyimpan data user.', 'error');
        } finally {
            setLoading(false);
        }
    });
</script>
@endpush
