@extends('layouts.admin')

@section('title', 'SIP-PANDU | Ganti Dokumen')

@section('breadcrumb')
<a href="{{ route('admin.dashboard') }}" class="text-sm text-on-surface-variant hover:text-primary transition-colors">Beranda</a>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
<a href="{{ route('admin.nasabah.index') }}" class="text-sm text-on-surface-variant hover:text-primary transition-colors">Data Nasabah</a>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
<a href="{{ route('admin.nasabah.show', $nasabah->id) }}" class="text-sm text-on-surface-variant hover:text-primary transition-colors">{{ $nasabah->nama }}</a>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
<span class="text-sm text-primary font-medium">Ganti Dokumen</span>
@endsection

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-on-surface mb-1">Ganti Dokumen Digital</h1>
    <p class="text-sm text-on-surface-variant">File lama akan diganti dengan file baru untuk jenis dokumen yang sama.</p>
</div>

<div id="alertMessage" class="hidden mb-5 px-4 py-3 rounded-lg text-sm border"></div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
    <aside class="lg:col-span-4">
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 shrink-0 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px]">person</span>
                </div>
                <div class="min-w-0">
                    <h2 class="text-lg font-semibold text-on-surface break-words">{{ $nasabah->nama }}</h2>
                    <p class="mt-1 font-mono text-sm text-on-surface-variant">{{ $nasabah->nomor_nasabah }}</p>
                </div>
            </div>

            <div class="mt-5 pt-5 border-t border-outline-variant">
                <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">Jenis Dokumen</p>
                <p class="mt-1 text-sm font-medium text-on-surface">{{ $dokumen->jenisDokumen?->nama_dokumen ?? 'Dokumen' }}</p>

                <p class="mt-4 text-xs font-semibold uppercase tracking-wider text-on-surface-variant">File Saat Ini</p>
                <p class="mt-1 break-all text-sm text-on-surface">{{ $dokumen->nama_file ?? '-' }}</p>
            </div>
        </div>
    </aside>

    <section class="lg:col-span-8 bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden">
        <form id="replaceDokumenForm" novalidate>
            <div class="p-5 sm:p-6">
                <label for="fileDokumen" class="block text-sm font-semibold text-on-surface mb-2">
                    Pilih File Pengganti <span class="text-error">*</span>
                </label>

                <label id="dropZone" for="fileDokumen" class="flex cursor-pointer justify-center rounded-xl border-2 border-dashed border-outline-variant bg-surface px-6 py-10 transition-colors hover:border-primary hover:bg-surface-container-low">
                    <span class="text-center">
                        <span class="material-symbols-outlined block text-[48px] text-on-surface-variant">cloud_upload</span>
                        <span class="mt-3 block text-sm font-semibold text-primary">Tarik dan lepas file di sini atau klik untuk memilih</span>
                        <span class="mt-2 block text-xs text-on-surface-variant">PDF, JPG, JPEG, atau PNG — maksimal 10 MB</span>
                    </span>
                </label>

                <input id="fileDokumen" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/jpeg,image/png" required>
                <p id="fileError" class="hidden mt-1.5 text-xs text-error"></p>

                <div id="filePreview" class="hidden mt-5 rounded-lg border border-outline-variant bg-surface-container-low p-4">
                    <div class="flex items-center gap-3">
                        <span id="fileIcon" class="material-symbols-outlined text-primary text-[28px]">description</span>
                        <div class="min-w-0 flex-1">
                            <p id="fileName" class="truncate text-sm font-medium text-on-surface"></p>
                            <p id="fileSize" class="mt-0.5 text-xs text-on-surface-variant"></p>
                        </div>
                        <button id="removeFile" type="button" class="p-1 text-on-surface-variant hover:text-error" title="Hapus file"><span class="material-symbols-outlined text-[20px]">close</span></button>
                    </div>
                </div>

                <div id="emptyFile" class="mt-5 rounded-lg bg-surface-container-low p-4 text-center text-sm italic text-on-surface-variant">Belum ada file pengganti yang dipilih.</div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 px-5 py-4 sm:px-6 border-t border-outline-variant bg-surface">
                <a href="{{ route('admin.nasabah.show', $nasabah->id) }}" class="inline-flex items-center justify-center rounded-lg border border-outline-variant bg-surface-container-lowest px-4 py-2.5 text-sm font-medium text-secondary hover:bg-surface-container-low transition-colors">Batal</a>
                <button id="submitButton" type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary-container px-4 py-2.5 text-sm font-semibold text-on-primary hover:bg-on-primary-fixed-variant transition-colors shadow-sm disabled:opacity-60 disabled:cursor-not-allowed">
                    <span class="material-symbols-outlined text-[18px]">sync</span>
                    <span id="submitText">Ganti Dokumen</span>
                </button>
            </div>
        </form>
    </section>
</div>
@endsection

@push('scripts')
<script>
    const REPLACE_API = @json(url('/api/dokumen/' . $dokumen->id));
    const DETAIL_URL = @json(route('admin.nasabah.show', $nasabah->id));
    const MAX_FILE_SIZE = 10 * 1024 * 1024;
    const ALLOWED_TYPES = ['application/pdf', 'image/jpeg', 'image/png'];

    const form = document.getElementById('replaceDokumenForm');
    const fileInput = document.getElementById('fileDokumen');
    const dropZone = document.getElementById('dropZone');
    const filePreview = document.getElementById('filePreview');
    const emptyFile = document.getElementById('emptyFile');
    const submitButton = document.getElementById('submitButton');
    const submitText = document.getElementById('submitText');

    function getHeaders() {
        const token = localStorage.getItem('sip_pandu_token');
        return token ? { 'Accept': 'application/json', 'Authorization': `Bearer ${token}` } : { 'Accept': 'application/json' };
    }

    function showAlert(message, type = 'error') {
        const alert = document.getElementById('alertMessage');
        alert.textContent = message;
        alert.className = type === 'success'
            ? 'mb-5 px-4 py-3 rounded-lg text-sm border bg-green-50 border-green-200 text-green-700'
            : 'mb-5 px-4 py-3 rounded-lg text-sm border bg-error-container border-error/30 text-on-error-container';
    }

    function setFileError(message = '') {
        const error = document.getElementById('fileError');
        error.textContent = message;
        error.classList.toggle('hidden', !message);
    }

    function validateFile(file) {
        if (!file) return 'Pilih file pengganti terlebih dahulu.';
        if (!ALLOWED_TYPES.includes(file.type)) return 'Format file harus PDF, JPG, JPEG, atau PNG.';
        if (file.size > MAX_FILE_SIZE) return 'Ukuran file maksimal 10 MB.';
        return '';
    }

    function renderFile(file) {
        const error = validateFile(file);
        setFileError(error);
        if (error) return false;

        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileSize').textContent = `${(file.size / 1024 / 1024).toFixed(2)} MB`;
        document.getElementById('fileIcon').textContent = file.type === 'application/pdf' ? 'picture_as_pdf' : 'image';
        filePreview.classList.remove('hidden');
        emptyFile.classList.add('hidden');
        return true;
    }

    fileInput.addEventListener('change', () => renderFile(fileInput.files[0]));

    ['dragenter', 'dragover'].forEach(name => dropZone.addEventListener(name, event => {
        event.preventDefault();
        dropZone.classList.add('border-primary', 'bg-surface-container-low');
    }));

    ['dragleave', 'drop'].forEach(name => dropZone.addEventListener(name, event => {
        event.preventDefault();
        dropZone.classList.remove('border-primary', 'bg-surface-container-low');
    }));

    dropZone.addEventListener('drop', event => {
        const file = event.dataTransfer.files[0];
        if (!file || !renderFile(file)) return;
        const transfer = new DataTransfer();
        transfer.items.add(file);
        fileInput.files = transfer.files;
    });

    document.getElementById('removeFile').addEventListener('click', () => {
        fileInput.value = '';
        filePreview.classList.add('hidden');
        emptyFile.classList.remove('hidden');
        setFileError();
    });

    form.addEventListener('submit', async event => {
        event.preventDefault();
        const file = fileInput.files[0];
        const error = validateFile(file);
        setFileError(error);
        if (error) return;

        const data = new FormData();
        data.append('_method', 'PUT');
        data.append('file', file);

        submitButton.disabled = true;
        submitText.textContent = 'Mengganti...';

        try {
            const response = await fetch(REPLACE_API, { method: 'POST', headers: getHeaders(), body: data });
            const result = await response.json();
            if (!response.ok) throw new Error(result.message || 'Gagal mengganti dokumen.');

            showAlert(result.message || 'Dokumen berhasil diganti.', 'success');
            setTimeout(() => { window.location.href = DETAIL_URL; }, 650);
        } catch (error) {
            showAlert(error.message || 'Gagal mengganti dokumen.');
            submitButton.disabled = false;
            submitText.textContent = 'Ganti Dokumen';
        }
    });
</script>
@endpush