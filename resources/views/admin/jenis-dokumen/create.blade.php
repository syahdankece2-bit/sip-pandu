@extends('layouts.admin')

@section('title', 'SIP-PANDU | Tambah Jenis Dokumen')

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

    <a
        href="{{ route('admin.jenis-dokumen') }}"
        class="text-sm text-on-surface-variant hover:text-primary transition-colors"
    >
        Jenis Dokumen
    </a>

    <span class="material-symbols-outlined text-[18px]">
        chevron_right
    </span>

    <span class="text-sm font-medium text-on-surface">
        Tambah
    </span>

@endsection


@section('content')

    {{-- Page Header --}}
    <div class="mb-8">

        <h1 class="text-2xl font-semibold text-on-surface">
            Tambah Jenis Dokumen Baru
        </h1>

        <p class="mt-1 text-sm text-on-surface-variant">
            Masukkan informasi detail untuk kategori dokumen baru.
        </p>

    </div>


    {{-- Alert --}}
    <div
        id="alertMessage"
        class="hidden mb-5 px-4 py-3 rounded-lg text-sm border"
    ></div>


    {{-- Form Card --}}
    <div
        class="max-w-3xl
               bg-surface-container-lowest
               border border-outline-variant
               rounded-xl
               shadow-sm
               p-8"
    >

        <form id="formJenisDokumen">

            <div class="space-y-6">

                {{-- Nama Kategori Dokumen --}}
                <div>

                    <label
                        for="nama_dokumen"
                        class="block text-xs font-semibold
                               text-on-surface mb-2"
                    >
                        Nama Kategori Dokumen

                        <span class="text-error">
                            *
                        </span>
                    </label>

                    <input
                        type="text"
                        id="nama_dokumen"
                        name="nama_dokumen"
                        maxlength="100"
                        required
                        placeholder="Misal: Dokumen Kredit, Identitas Diri, dll."
                        class="w-full
                               px-4 py-2
                               border border-outline-variant
                               rounded-lg
                               bg-surface
                               text-sm
                               text-on-surface
                               placeholder:text-on-surface-variant
                               focus:outline-none
                               focus:ring-2
                               focus:ring-primary
                               focus:border-primary
                               transition-shadow"
                    >

                </div>


                {{-- Deskripsi --}}
                <div>

                    <label
                        for="deskripsi"
                        class="block text-xs font-semibold
                               text-on-surface mb-2"
                    >
                        Deskripsi
                    </label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        maxlength="250"
                        rows="4"
                        placeholder="Tambahkan keterangan opsional mengenai kategori dokumen ini..."
                        class="w-full
                               px-4 py-2
                               border border-outline-variant
                               rounded-lg
                               bg-surface
                               text-sm
                               text-on-surface
                               placeholder:text-on-surface-variant
                               focus:outline-none
                               focus:ring-2
                               focus:ring-primary
                               focus:border-primary
                               transition-shadow
                               resize-none"
                    ></textarea>

                    <p class="mt-2 text-xs text-on-surface-variant">
                        Maksimal 250 karakter.
                    </p>

                </div>

            </div>


            {{-- Actions --}}
            <div
                class="mt-8 pt-6
                       border-t border-outline-variant
                       flex items-center justify-end gap-4"
            >

                {{-- Batal --}}
                <a
                    href="{{ route('admin.jenis-dokumen') }}"
                    class="px-6 py-2
                           border border-outline-variant
                           rounded-lg
                           text-secondary
                           text-xs font-medium
                           hover:bg-surface-container-low
                           focus:outline-none
                           focus:ring-2
                           focus:ring-primary
                           transition-colors"
                >
                    Batal
                </a>


                {{-- Simpan --}}
                <button
                    type="submit"
                    id="btnSimpan"
                    class="px-6 py-2
                           bg-primary-container
                           text-white
                           rounded-lg
                           text-xs font-medium
                           hover:bg-primary
                           focus:outline-none
                           focus:ring-2
                           focus:ring-offset-2
                           focus:ring-primary
                           transition-colors
                           shadow-sm
                           inline-flex items-center gap-2"
                >

                    <span
                        id="loadingIcon"
                        class="material-symbols-outlined
                               text-[18px] hidden"
                    >
                        progress_activity
                    </span>

                    <span id="buttonText">
                        Simpan Kategori
                    </span>

                </button>

            </div>

        </form>

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
    | Elements
    |--------------------------------------------------------------------------
    */

    const form = document.getElementById('formJenisDokumen');

    const btnSimpan = document.getElementById('btnSimpan');

    const buttonText = document.getElementById('buttonText');

    const loadingIcon = document.getElementById('loadingIcon');

    const alertMessage = document.getElementById('alertMessage');


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
        alertMessage.textContent = message;

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

        alertMessage.classList.remove('hidden');
    }


    /*
    |--------------------------------------------------------------------------
    | Loading Button
    |--------------------------------------------------------------------------
    */

    function setLoading(loading)
    {
        btnSimpan.disabled = loading;

        if (loading) {

            loadingIcon.classList.remove('hidden');

            loadingIcon.classList.add('animate-spin');

            buttonText.textContent = 'Menyimpan...';

            btnSimpan.classList.add(
                'opacity-70',
                'cursor-not-allowed'
            );

        } else {

            loadingIcon.classList.add('hidden');

            loadingIcon.classList.remove('animate-spin');

            buttonText.textContent = 'Simpan Kategori';

            btnSimpan.classList.remove(
                'opacity-70',
                'cursor-not-allowed'
            );

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Submit Form
    |--------------------------------------------------------------------------
    */

    form.addEventListener('submit', async function(event)
    {
        event.preventDefault();

        const namaDokumen =
            document.getElementById('nama_dokumen').value.trim();

        const deskripsi =
            document.getElementById('deskripsi').value.trim();


        /*
        |--------------------------------------------------------------------------
        | Validasi sederhana
        |--------------------------------------------------------------------------
        */

        if (!namaDokumen) {

            showAlert(
                'Nama kategori dokumen wajib diisi.',
                'error'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Kirim ke API
        |--------------------------------------------------------------------------
        */

        setLoading(true);


        try {

            const response = await fetch(API_URL, {

                method: 'POST',

                headers: getHeaders(),

                body: JSON.stringify({
                    nama_dokumen: namaDokumen,
                    deskripsi: deskripsi || null
                })

            });


            /*
            |--------------------------------------------------------------------------
            | Token tidak valid
            |--------------------------------------------------------------------------
            */

            if (response.status === 401) {

                localStorage.removeItem('sip_pandu_token');

                window.location.href = '/login';

                return;
            }


            const result = await response.json();


            /*
            |--------------------------------------------------------------------------
            | Validation Error
            |--------------------------------------------------------------------------
            */

            if (response.status === 422) {

                let message =
                    'Data yang dimasukkan tidak valid.';

                if (result.errors) {

                    const errors =
                        Object.values(result.errors)
                            .flat();

                    if (errors.length > 0) {

                        message = errors[0];

                    }

                }

                showAlert(message, 'error');

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Error lainnya
            |--------------------------------------------------------------------------
            */

            if (!response.ok) {

                throw new Error(
                    result.message ||
                    'Gagal menambahkan jenis dokumen.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Berhasil
            |--------------------------------------------------------------------------
            */

            showAlert(
                result.message ||
                'Jenis dokumen berhasil ditambahkan.',
                'success'
            );


            /*
            |--------------------------------------------------------------------------
            | Redirect
            |--------------------------------------------------------------------------
            */

            setTimeout(function()
            {

                window.location.href =
                    "{{ route('admin.jenis-dokumen') }}";

            }, 1000);


        } catch (error) {

            console.error(error);

            showAlert(
                error.message ||
                'Terjadi kesalahan saat menyimpan data.',
                'error'
            );

        } finally {

            setLoading(false);

        }

    });

</script>

@endpush