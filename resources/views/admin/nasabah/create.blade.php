@extends('layouts.admin')

@section('title', 'SIP-PANDU | Tambah Nasabah')

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
    Tambah Nasabah
</span>

@endsection

@section('content')

{{-- =========================================================
PAGE HEADER
========================================================== --}}

<div class="mb-6">

    <h1 class="text-2xl font-semibold text-on-surface mb-1">
        Tambah Data Nasabah
    </h1>

    <p class="text-sm text-on-surface-variant">
        Tambahkan identitas dasar nasabah dan lokasi arsip fisiknya.
    </p>

</div>


{{-- =========================================================
ALERT
========================================================== --}}

<div
    id="alertMessage"
    class="hidden mb-5 px-4 py-3 rounded-lg text-sm border"
></div>


{{-- =========================================================
FORM
========================================================== --}}

<form
    id="nasabahForm"
    class="max-w-5xl grid grid-cols-1 lg:grid-cols-12 gap-6 items-start"
>


{{-- =====================================================
     INFORMASI NASABAH
====================================================== --}}

<div
    class="lg:col-span-8
           bg-surface-container-lowest
           rounded-xl
           border border-outline-variant
           p-6
           shadow-sm"
>

    <h2
        class="text-lg font-semibold text-on-surface
               mb-5
               flex items-center gap-2"
    >

        <span class="material-symbols-outlined text-primary">
            person
        </span>

        Informasi Nasabah

    </h2>


    <div class="space-y-5">


        {{-- =================================================
             NOMOR NASABAH
        ================================================== --}}

        <div>

            <label
                for="nomor_nasabah"
                class="block text-xs font-medium
                       text-on-surface-variant mb-1.5"
            >
                Nomor Nasabah
                <span class="text-error">*</span>
            </label>


            <input
                type="text"
                id="nomor_nasabah"
                name="nomor_nasabah"
                placeholder="Contoh: 00011"
                required
                maxlength="50"
                autocomplete="off"
                class="w-full
                       bg-surface-container-lowest
                       border border-outline-variant
                       rounded-lg
                       px-3 py-2.5
                       text-sm
                       text-on-surface
                       focus:outline-none
                       focus:border-primary
                       focus:ring-1
                       focus:ring-primary
                       transition-colors"
            >


            <p class="mt-1.5 text-xs text-on-surface-variant">
                Nomor identitas nasabah yang digunakan dalam sistem.
            </p>

        </div>


        {{-- =================================================
             NAMA NASABAH
        ================================================== --}}

        <div>

            <label
                for="nama"
                class="block text-xs font-medium
                       text-on-surface-variant mb-1.5"
            >
                Nama Lengkap
                <span class="text-error">*</span>
            </label>


            <input
                type="text"
                id="nama"
                name="nama"
                placeholder="Masukkan nama lengkap nasabah"
                required
                maxlength="255"
                autocomplete="off"
                class="w-full
                       bg-surface-container-lowest
                       border border-outline-variant
                       rounded-lg
                       px-3 py-2.5
                       text-sm
                       text-on-surface
                       focus:outline-none
                       focus:border-primary
                       focus:ring-1
                       focus:ring-primary
                       transition-colors"
            >

        </div>


        {{-- =================================================
             INFO
        ================================================== --}}

        <div
            class="p-4
                   rounded-lg
                   bg-surface-container-low
                   border border-outline-variant"
        >

            <div class="flex items-start gap-2">

                <span
                    class="material-symbols-outlined
                           text-secondary
                           text-[18px]"
                >
                    info
                </span>

                <p class="text-xs text-on-surface-variant leading-5">
                    Data identitas lainnya seperti NIK, nomor KK, dan
                    NPWP tidak diperlukan pada tahap pendaftaran nasabah.
                    Dokumen identitas dapat dikelola melalui arsip digital.
                </p>

            </div>

        </div>


    </div>

</div>



{{-- =====================================================
     LOKASI ARSIP
====================================================== --}}

<div class="lg:col-span-4 flex flex-col gap-6">


    {{-- =================================================
         CARD LOKASI ARSIP
    ================================================== --}}

    <div
        class="bg-surface-container-lowest
               rounded-xl
               border border-outline-variant
               p-6
               shadow-sm"
    >

        <h2
            class="text-lg font-semibold text-on-surface
                   mb-5
                   flex items-center gap-2"
        >

            <span class="material-symbols-outlined text-primary">
                folder_open
            </span>

            Lokasi Arsip Fisik

        </h2>


        <div class="space-y-5">


            {{-- =================================================
                 RAK
            ================================================== --}}

            <div>

                <label
                    for="rak"
                    class="block text-xs font-medium
                           text-on-surface-variant mb-1.5"
                >
                    Rak
                </label>


                <input
                    type="text"
                    id="rak"
                    name="rak"
                    maxlength="100"
                    placeholder="Contoh: C"
                    class="w-full
                           bg-surface-container-lowest
                           border border-outline-variant
                           rounded-lg
                           px-3 py-2.5
                           text-sm
                           text-on-surface
                           focus:outline-none
                           focus:border-primary
                           focus:ring-1
                           focus:ring-primary
                           transition-colors"
                >

            </div>


            {{-- =================================================
                 NOMOR MAP
            ================================================== --}}

            <div>

                <label
                    for="nomor_map"
                    class="block text-xs font-medium
                           text-on-surface-variant mb-1.5"
                >
                    Nomor Map
                </label>


                <input
                    type="text"
                    id="nomor_map"
                    name="nomor_map"
                    maxlength="100"
                    placeholder="Contoh: 030"
                    class="w-full
                           bg-surface-container-lowest
                           border border-outline-variant
                           rounded-lg
                           px-3 py-2.5
                           text-sm
                           text-on-surface
                           focus:outline-none
                           focus:border-primary
                           focus:ring-1
                           focus:ring-primary
                           transition-colors"
                >

            </div>


            {{-- =================================================
                 POSISI
            ================================================== --}}

            <div>

                <label
                    for="posisi"
                    class="block text-xs font-medium
                           text-on-surface-variant mb-1.5"
                >
                    Posisi
                </label>


                <input
                    type="text"
                    id="posisi"
                    name="posisi"
                    maxlength="100"
                    placeholder="Contoh: 05"
                    class="w-full
                           bg-surface-container-lowest
                           border border-outline-variant
                           rounded-lg
                           px-3 py-2.5
                           text-sm
                           text-on-surface
                           focus:outline-none
                           focus:border-primary
                           focus:ring-1
                           focus:ring-primary
                           transition-colors"
                >

            </div>

        </div>


        {{-- =================================================
             INFO LOKASI
        ================================================== --}}

        <div
            class="mt-5
                   p-3
                   rounded-lg
                   bg-surface-container-low
                   border border-outline-variant"
        >

            <div class="flex items-start gap-2">

                <span
                    class="material-symbols-outlined
                           text-secondary
                           text-[18px]"
                >
                    info
                </span>

                <p class="text-xs text-on-surface-variant leading-5">
                    Lokasi arsip digunakan untuk membantu petugas
                    menemukan dokumen fisik nasabah.
                </p>

            </div>

        </div>

    </div>



    {{-- =================================================
         ACTION BUTTON
    ================================================== --}}

    <div
        class="bg-surface-container-lowest
               rounded-xl
               border border-outline-variant
               p-4
               flex flex-col sm:flex-row
               lg:flex-col
               justify-end
               gap-3
               shadow-sm"
    >

        <a
            href="{{ route('admin.nasabah.index') }}"
            class="inline-flex
                   items-center
                   justify-center
                   gap-2
                   px-4 py-2.5
                   rounded-lg
                   border border-outline-variant
                   text-secondary
                   text-sm font-medium
                   hover:bg-surface-container-low
                   transition-colors"
        >

            <span class="material-symbols-outlined text-[18px]">
                arrow_back
            </span>

            Batal

        </a>


        <button
            type="submit"
            id="btnSimpan"
            class="inline-flex
                   items-center
                   justify-center
                   gap-2
                   px-4 py-2.5
                   rounded-lg
                   bg-primary-container
                   text-white
                   text-sm font-medium
                   hover:bg-primary
                   transition-colors
                   disabled:opacity-60
                   disabled:cursor-not-allowed"
        >

            <span
                id="saveIcon"
                class="material-symbols-outlined text-[18px]"
            >
                save
            </span>

            <span id="saveText">
                Simpan Nasabah
            </span>

        </button>

    </div>

</div>

</form>

@endsection


@push('scripts')

<script>

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    */

    const NASABAH_API = '/api/nasabah';

    const LOKASI_API = (nasabahId) => {
        return `/api/nasabah/${nasabahId}/lokasi-arsip`;
    };


    /*
    |--------------------------------------------------------------------------
    | TOKEN
    |--------------------------------------------------------------------------
    */

    function getToken()
    {
        return localStorage.getItem('sip_pandu_token');
    }


    /*
    |--------------------------------------------------------------------------
    | HEADERS
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
    | ALERT
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

        alert.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    }


    /*
    |--------------------------------------------------------------------------
    | FORM SUBMIT
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('nasabahForm')
        .addEventListener('submit', async function (event) {

            event.preventDefault();

            const btnSimpan =
                document.getElementById('btnSimpan');

            const saveIcon =
                document.getElementById('saveIcon');

            const saveText =
                document.getElementById('saveText');


            /*
            |--------------------------------------------------------------------------
            | DATA NASABAH
            |--------------------------------------------------------------------------
            */

            const nomorNasabah =
                document
                    .getElementById('nomor_nasabah')
                    .value
                    .trim();

            const nama =
                document
                    .getElementById('nama')
                    .value
                    .trim();


            /*
            |--------------------------------------------------------------------------
            | DATA LOKASI ARSIP
            |--------------------------------------------------------------------------
            */

            const rak =
                document
                    .getElementById('rak')
                    .value
                    .trim();

            const nomorMap =
                document
                    .getElementById('nomor_map')
                    .value
                    .trim();

            const posisi =
                document
                    .getElementById('posisi')
                    .value
                    .trim();


            /*
            |--------------------------------------------------------------------------
            | VALIDASI
            |--------------------------------------------------------------------------
            */

            if (!nomorNasabah) {

                showAlert(
                    'Nomor nasabah wajib diisi.',
                    'error'
                );

                return;
            }


            if (!nama) {

                showAlert(
                    'Nama nasabah wajib diisi.',
                    'error'
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | LOADING
            |--------------------------------------------------------------------------
            */

            btnSimpan.disabled = true;

            saveIcon.textContent = 'progress_activity';

            saveIcon.classList.add('animate-spin');

            saveText.textContent = 'Menyimpan...';


            try {

                /*
                |--------------------------------------------------------------------------
                | STEP 1
                | Membuat data nasabah
                |--------------------------------------------------------------------------
                */

                const nasabahResponse =
                    await fetch(
                        NASABAH_API,
                        {
                            method: 'POST',

                            headers: getHeaders(),

                            body: JSON.stringify({

                                nomor_nasabah:
                                    nomorNasabah,

                                nama:
                                    nama

                            })
                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | AUTH CHECK
                |--------------------------------------------------------------------------
                */

                if (nasabahResponse.status === 401) {

                    localStorage.removeItem(
                        'sip_pandu_token'
                    );

                    window.location.href =
                        '/login';

                    return;
                }


                const nasabahResult =
                    await nasabahResponse.json();


                /*
                |--------------------------------------------------------------------------
                | API ERROR
                |--------------------------------------------------------------------------
                */

                if (!nasabahResponse.ok) {

                    let message =
                        nasabahResult.message ||
                        'Gagal menambahkan nasabah.';


                    if (
                        nasabahResult.errors &&
                        typeof nasabahResult.errors === 'object'
                    ) {

                        const firstError =
                            Object.values(
                                nasabahResult.errors
                            )[0];


                        if (Array.isArray(firstError)) {

                            message = firstError[0];

                        }

                    }

                    throw new Error(message);
                }


                /*
                |--------------------------------------------------------------------------
                | DATA NASABAH BERHASIL
                |--------------------------------------------------------------------------
                */

                const nasabah =
                    nasabahResult.data;


                /*
                |--------------------------------------------------------------------------
                | STEP 2
                | Simpan lokasi arsip jika diisi
                |--------------------------------------------------------------------------
                */

                if (
                    rak ||
                    nomorMap ||
                    posisi
                ) {

                    const lokasiResponse =
                        await fetch(
                            LOKASI_API(nasabah.id),
                            {
                                method: 'PUT',

                                headers: getHeaders(),

                                body: JSON.stringify({

                                    rak:
                                        rak || null,

                                    nomor_map:
                                        nomorMap || null,

                                    posisi:
                                        posisi || null

                                })
                            }
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | AUTH CHECK LOKASI
                    |--------------------------------------------------------------------------
                    */

                    if (
                        lokasiResponse.status === 401
                    ) {

                        localStorage.removeItem(
                            'sip_pandu_token'
                        );

                        window.location.href =
                            '/login';

                        return;
                    }


                    const lokasiResult =
                        await lokasiResponse.json();


                    /*
                    |--------------------------------------------------------------------------
                    | LOKASI ERROR
                    |--------------------------------------------------------------------------
                    */

                    if (!lokasiResponse.ok) {

                        throw new Error(
                            lokasiResult.message ||
                            'Nasabah berhasil dibuat, tetapi lokasi arsip gagal disimpan.'
                        );
                    }

                }


                /*
                |--------------------------------------------------------------------------
                | BERHASIL
                |--------------------------------------------------------------------------
                */

                showAlert(
                    'Nasabah berhasil ditambahkan.',
                    'success'
                );


                /*
                |--------------------------------------------------------------------------
                | REDIRECT
                |--------------------------------------------------------------------------
                */

                setTimeout(() => {

                    window.location.href =
                        "{{ route('admin.nasabah.index') }}";

                }, 800);


            } catch (error) {

                console.error(
                    'Error tambah nasabah:',
                    error
                );


                showAlert(
                    error.message ||
                    'Terjadi kesalahan saat menyimpan data nasabah.',
                    'error'
                );


                btnSimpan.disabled = false;


                saveIcon.textContent = 'save';

                saveIcon.classList.remove('animate-spin');

                saveText.textContent =
                    'Simpan Nasabah';

            }

        });

</script>

@endpush