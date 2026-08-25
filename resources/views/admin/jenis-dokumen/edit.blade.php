@extends('layouts.admin')

@section('title', 'SIP-PANDU | Edit Jenis Dokumen')

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

    <span class="text-sm font-medium text-primary">
        Edit
    </span>

@endsection


@section('content')

    {{-- Page Header --}}
    <div class="max-w-3xl mx-auto">

        <div class="mb-6">

            <h1 class="text-2xl font-semibold text-on-surface">
                Edit Jenis Dokumen
            </h1>

            <p class="mt-1 text-sm text-secondary">
                Perbarui informasi kategori dokumen untuk sistem pengarsipan.
            </p>

        </div>


        {{-- Alert --}}
        <div
            id="alertMessage"
            class="hidden mb-5 px-4 py-3 rounded-lg text-sm border"
        ></div>


        {{-- Form Card --}}
        <div
            class="bg-surface-container-lowest
                   rounded-xl
                   border border-outline-variant
                   p-6
                   shadow-sm"
        >

            <form id="formEditJenisDokumen">

                <div class="flex flex-col gap-6">

                    {{-- Nama Kategori --}}
                    <div class="flex flex-col gap-2">

                        <label
                            for="nama_dokumen"
                            class="text-xs font-medium text-on-surface"
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
                            value="{{ $jenisDokumen->nama_dokumen }}"
                            maxlength="100"
                            required
                            class="w-full h-10
                                   px-3 py-2
                                   rounded-lg
                                   bg-surface
                                   border border-outline-variant
                                   text-sm
                                   text-on-surface
                                   focus:outline-none
                                   focus:ring-1
                                   focus:ring-primary
                                   focus:border-primary
                                   transition-all"
                        >

                        <p class="text-xs text-on-surface-variant">
                            Nama singkat dan jelas untuk kategori ini.
                        </p>

                    </div>


                    {{-- Deskripsi --}}
                    <div class="flex flex-col gap-2">

                        <label
                            for="deskripsi"
                            class="text-xs font-medium text-on-surface"
                        >
                            Deskripsi
                        </label>

                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            rows="4"
                            maxlength="250"
                            class="w-full
                                   px-3 py-2
                                   rounded-lg
                                   bg-surface
                                   border border-outline-variant
                                   text-sm
                                   text-on-surface
                                   focus:outline-none
                                   focus:ring-1
                                   focus:ring-primary
                                   focus:border-primary
                                   transition-all
                                   resize-none"
                        >{{ $jenisDokumen->deskripsi }}</textarea>

                        <p class="text-xs text-on-surface-variant">
                            Penjelasan mendetail mengenai jenis dokumen yang masuk dalam kategori ini.
                        </p>

                    </div>


                    {{-- Status Aktif --}}
                    <div
                        class="flex items-center justify-between
                               p-4
                               rounded-lg
                               bg-surface
                               border border-outline-variant"
                    >

                        <div class="pr-4">

                            <label
                                class="text-xs font-medium
                                       text-on-surface
                                       block mb-1"
                            >
                                Status Kategori
                            </label>

                            <p class="text-xs text-on-surface-variant">
                                Nonaktifkan kategori ini jika tidak lagi digunakan.
                                Dokumen lama akan tetap tersimpan.
                            </p>

                        </div>


                        {{-- Toggle --}}
                        <label
                            class="relative inline-flex
                                   items-center
                                   cursor-pointer
                                   shrink-0"
                        >

                            <input
                                id="statusToggle"
                                type="checkbox"
                                class="sr-only peer"
                                {{ $jenisDokumen->status === 'aktif' ? 'checked' : '' }}
                            >

                            <div
                                class="w-11 h-6
                                       bg-surface-variant
                                       peer-focus:outline-none
                                       peer-focus:ring-2
                                       peer-focus:ring-primary
                                       rounded-full

                                       after:content-['']
                                       after:absolute
                                       after:top-[2px]
                                       after:left-[2px]

                                       after:bg-white
                                       after:border-gray-300
                                       after:border
                                       after:rounded-full

                                       after:h-5
                                       after:w-5

                                       after:transition-all

                                       peer-checked:after:translate-x-full
                                       peer-checked:after:border-white
                                       peer-checked:bg-primary-container"
                            ></div>

                        </label>

                    </div>

                </div>


                {{-- Action --}}
                <div
                    class="mt-6 pt-6
                           border-t border-outline-variant
                           flex items-center justify-end gap-3"
                >

                    {{-- Batal --}}
                    <a
                        href="{{ route('admin.jenis-dokumen') }}"
                        class="h-10
                               px-4
                               rounded-lg
                               text-xs font-medium
                               border border-outline-variant
                               text-secondary
                               bg-surface-container-lowest
                               hover:bg-surface-container-low
                               focus:outline-none
                               focus:ring-2
                               focus:ring-primary
                               transition-colors
                               flex items-center"
                    >
                        Batal
                    </a>


                    {{-- Simpan Perubahan --}}
                    <button
                        type="submit"
                        id="btnSimpan"
                        class="h-10
                               px-4
                               rounded-lg
                               text-xs font-medium
                               bg-primary-container
                               text-white
                               border border-transparent
                               hover:bg-primary
                               focus:outline-none
                               focus:ring-2
                               focus:ring-primary
                               transition-colors
                               flex items-center gap-2
                               shadow-sm"
                    >

                        <span
                            id="loadingIcon"
                            class="material-symbols-outlined
                                   text-[18px]
                                   hidden"
                        >
                            progress_activity
                        </span>

                        <span id="buttonText">
                            Simpan Perubahan
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
    | API
    |--------------------------------------------------------------------------
    */

    const API_URL =
        '/api/jenis-dokumen/{{ $jenisDokumen->id }}';


    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const form =
        document.getElementById('formEditJenisDokumen');

    const btnSimpan =
        document.getElementById('btnSimpan');

    const buttonText =
        document.getElementById('buttonText');

    const loadingIcon =
        document.getElementById('loadingIcon');

    const alertMessage =
        document.getElementById('alertMessage');

    const statusToggle =
        document.getElementById('statusToggle');


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
    | Loading
    |--------------------------------------------------------------------------
    */

    function setLoading(loading)
    {
        btnSimpan.disabled = loading;

        if (loading) {

            loadingIcon.classList.remove('hidden');

            loadingIcon.classList.add('animate-spin');

            buttonText.textContent =
                'Menyimpan...';

            btnSimpan.classList.add(
                'opacity-70',
                'cursor-not-allowed'
            );

        } else {

            loadingIcon.classList.add('hidden');

            loadingIcon.classList.remove('animate-spin');

            buttonText.textContent =
                'Simpan Perubahan';

            btnSimpan.classList.remove(
                'opacity-70',
                'cursor-not-allowed'
            );

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Submit
    |--------------------------------------------------------------------------
    */

    form.addEventListener(
        'submit',
        async function(event)
        {
            event.preventDefault();


            const namaDokumen =
                document
                    .getElementById('nama_dokumen')
                    .value
                    .trim();


            const deskripsi =
                document
                    .getElementById('deskripsi')
                    .value
                    .trim();


            /*
            |--------------------------------------------------------------------------
            | Validasi
            |--------------------------------------------------------------------------
            */

            if (!namaDokumen) {

                showAlert(
                    'Nama kategori dokumen wajib diisi.',
                    'error'
                );

                return;
            }


            setLoading(true);


            try {

                const response =
                    await fetch(API_URL, {

                        method: 'PUT',

                        headers: getHeaders(),

                        body: JSON.stringify({

                            nama_dokumen:
                                namaDokumen,

                            deskripsi:
                                deskripsi || null

                        })

                    });


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
                | Validation Error
                |--------------------------------------------------------------------------
                */

                if (response.status === 422) {

                    let message =
                        'Data yang dimasukkan tidak valid.';


                    if (result.errors) {

                        const errors =
                            Object.values(
                                result.errors
                            ).flat();


                        if (errors.length > 0) {

                            message =
                                errors[0];

                        }

                    }


                    showAlert(
                        message,
                        'error'
                    );

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Error
                |--------------------------------------------------------------------------
                */

                if (!response.ok) {

                    throw new Error(
                        result.message ||
                        'Gagal memperbarui jenis dokumen.'
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Berhasil
                |--------------------------------------------------------------------------
                */

                showAlert(
                    result.message ||
                    'Jenis dokumen berhasil diperbarui.',
                    'success'
                );


                /*
                |--------------------------------------------------------------------------
                | Kembali ke daftar
                |--------------------------------------------------------------------------
                */

                setTimeout(
                    function()
                    {
                        window.location.href =
                            "{{ route('admin.jenis-dokumen') }}";
                    },
                    1000
                );

            } catch (error) {

                console.error(error);

                showAlert(
                    error.message ||
                    'Terjadi kesalahan saat menyimpan perubahan.',
                    'error'
                );

            } finally {

                setLoading(false);

            }

        }
    );

</script>

@endpush