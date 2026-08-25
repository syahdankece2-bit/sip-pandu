@extends('layouts.user')

@section('title', 'Upload Dokumen')

@section('content')

<div class="p-6 md:p-8">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-slate-500 mb-6">

        <a
            href="{{ route('user.dashboard') }}"
            class="hover:text-blue-600 flex items-center"
        >
            <span class="material-symbols-outlined text-[18px]">
                home
            </span>
        </a>

        <span class="material-symbols-outlined text-[16px]">
            chevron_right
        </span>

        <a
            href="{{ route('user.nasabah.index') }}"
            class="hover:text-blue-600"
        >
            Data Nasabah
        </a>

        <span class="material-symbols-outlined text-[16px]">
            chevron_right
        </span>

        <a
            href="{{ route('user.nasabah.show', $nasabah) }}"
            class="hover:text-blue-600"
        >
            {{ $nasabah->nama }}
        </a>

        <span class="material-symbols-outlined text-[16px]">
            chevron_right
        </span>

        <span class="text-slate-900 font-medium">
            Upload Dokumen
        </span>

    </div>


    {{-- Header --}}
    <div class="mb-6">

        <h1 class="text-2xl font-semibold text-slate-900">
            Upload Dokumen
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Tambahkan dokumen digital untuk nasabah yang dipilih.
        </p>

    </div>


    {{-- Informasi Nasabah --}}
    <div class="bg-white border border-slate-200 rounded-lg p-6 mb-6">

        <div class="flex items-center gap-4">

            <div
                class="w-14 h-14 rounded-lg bg-slate-100
                       flex items-center justify-center
                       text-slate-700"
            >

                <span class="material-symbols-outlined text-[30px]">
                    person
                </span>

            </div>

            <div>

                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    Nasabah
                </p>

                <h2 class="text-lg font-semibold text-slate-900">
                    {{ $nasabah->nama }}
                </h2>

                <p class="text-sm text-slate-500 font-mono">
                    {{ $nasabah->nomor_nasabah }}
                </p>

            </div>

        </div>

    </div>


    {{-- Form Upload --}}
    <div class="bg-white border border-slate-200 rounded-lg overflow-hidden max-w-3xl">

        {{-- Form Header --}}
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">

            <div class="flex items-center gap-3">

                <div
                    class="w-10 h-10 rounded-lg bg-blue-50
                           flex items-center justify-center text-blue-600"
                >

                    <span class="material-symbols-outlined">
                        upload_file
                    </span>

                </div>

                <div>

                    <h3 class="text-base font-semibold text-slate-900">
                        Form Upload Dokumen
                    </h3>

                    <p class="text-xs text-slate-500 mt-0.5">
                        Pastikan dokumen yang diunggah sesuai dengan jenisnya.
                    </p>

                </div>

            </div>

        </div>


        {{-- Form --}}
        <form
            action="{{ route('user.nasabah.dokumen.store', $nasabah) }}"
            method="POST"
            enctype="multipart/form-data"
            class="p-6"
        >

            @csrf


            {{-- Error Validation --}}
            @if ($errors->any())

                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">

                    <div class="flex items-start gap-3">

                        <span class="material-symbols-outlined text-red-600">
                            error
                        </span>

                        <div>

                            <p class="text-sm font-semibold text-red-700">
                                Upload dokumen gagal
                            </p>

                            <ul class="mt-1 text-sm text-red-600 list-disc list-inside">

                                @foreach ($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif


            {{-- Jenis Dokumen --}}
            <div class="mb-5">

                <label
                    for="jenis_dokumen_id"
                    class="block text-sm font-semibold text-slate-700 mb-2"
                >
                    Jenis Dokumen
                    <span class="text-red-500">*</span>
                </label>

                <select
                    id="jenis_dokumen_id"
                    name="jenis_dokumen_id"
                    required
                    class="w-full rounded-lg border border-slate-300
                           bg-white px-4 py-2.5 text-sm text-slate-900
                           focus:outline-none focus:border-blue-500
                           focus:ring-1 focus:ring-blue-500"
                >

                    <option value="">
                        -- Pilih Jenis Dokumen --
                    </option>

                    @foreach ($jenisDokumen as $jenis)

                        <option
                            value="{{ $jenis->id }}"
                            {{ old('jenis_dokumen_id') == $jenis->id ? 'selected' : '' }}
                        >
                            {{ $jenis->nama_dokumen }}
                        </option>

                    @endforeach

                </select>

                @error('jenis_dokumen_id')

                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- File --}}
            <div class="mb-6">

                <label
                    for="file"
                    class="block text-sm font-semibold text-slate-700 mb-2"
                >
                    File Dokumen
                    <span class="text-red-500">*</span>
                </label>


                <label
                    for="file"
                    class="block border-2 border-dashed border-slate-300
                           rounded-lg p-8 text-center cursor-pointer
                           hover:border-blue-400 hover:bg-blue-50/30
                           transition-colors"
                >

                    <span
                        class="material-symbols-outlined
                               text-5xl text-slate-300"
                    >
                        cloud_upload
                    </span>

                    <p class="mt-3 text-sm font-medium text-slate-700">
                        Klik untuk memilih file
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Format PDF, JPG, JPEG, PNG. Maksimal 5 MB.
                    </p>

                    <p
                        id="fileName"
                        class="mt-3 text-sm font-medium text-blue-600 hidden"
                    ></p>

                    <input
                        id="file"
                        type="file"
                        name="file"
                        accept=".pdf,.jpg,.jpeg,.png"
                        required
                        class="hidden"
                    >

                </label>


                @error('file')

                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- Informasi --}}
            <div class="mb-6 p-4 rounded-lg bg-blue-50 border border-blue-100">

                <div class="flex items-start gap-3">

                    <span class="material-symbols-outlined text-blue-600">
                        info
                    </span>

                    <div>

                        <p class="text-sm font-medium text-blue-800">
                            Informasi
                        </p>

                        <p class="mt-1 text-xs leading-5 text-blue-700">
                            Setelah file berhasil diunggah, dokumen akan
                            tersimpan pada sistem dan dapat dilihat melalui
                            halaman dokumen nasabah.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Action --}}
            <div
                class="flex flex-col-reverse sm:flex-row
                       justify-end gap-3 pt-5
                       border-t border-slate-200"
            >

                <a
                    href="{{ route('user.nasabah.show', $nasabah) }}"
                    class="inline-flex items-center justify-center gap-2
                           px-4 py-2.5 border border-slate-300
                           text-slate-700 text-sm font-medium
                           rounded-lg hover:bg-slate-50
                           transition-colors"
                >

                    <span class="material-symbols-outlined text-[18px]">
                        arrow_back
                    </span>

                    Batal

                </a>


                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2
                           px-4 py-2.5 bg-secondary
                           text-white text-sm font-medium
                           rounded-lg hover:bg-secondary-container
                           transition-colors"
                >

                    <span class="material-symbols-outlined text-[18px]">
                        upload
                    </span>

                    Upload Dokumen

                </button>

            </div>

        </form>

    </div>

</div>

@endsection


@push('scripts')

<script>

    const fileInput = document.getElementById('file');
    const fileName = document.getElementById('fileName');

    fileInput.addEventListener('change', function () {

        if (this.files.length > 0) {

            fileName.textContent =
                'File dipilih: ' + this.files[0].name;

            fileName.classList.remove('hidden');

        } else {

            fileName.textContent = '';
            fileName.classList.add('hidden');

        }

    });

</script>

@endpush