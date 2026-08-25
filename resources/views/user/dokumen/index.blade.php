@extends('layouts.user')

@section('title', 'Daftar Dokumen')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">
            Daftar Dokumen
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Kelola dan pantau seluruh arsip dokumen yang tersedia dalam sistem.
        </p>
    </div>


    {{-- Search --}}
    <div class="bg-white border border-slate-200 rounded-lg p-4 mb-6">

        <div class="relative max-w-md">

            <span
                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"
            >
                search
            </span>

            <input
                id="searchDokumen"
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama dokumen, file, atau nasabah..."
                autocomplete="off"
                class="w-full bg-slate-50 border border-slate-200 rounded-lg
                    pl-10 pr-10 py-2.5 text-sm text-slate-900
                    focus:outline-none focus:border-blue-500
                    focus:ring-1 focus:ring-blue-500"
            >

            {{-- Tombol clear --}}
            @if(request('search'))
                <button
                    type="button"
                    id="clearSearch"
                    class="absolute right-3 top-1/2 -translate-y-1/2
                           text-slate-400 hover:text-slate-600"
                    title="Hapus pencarian"
                >
                    <span class="material-symbols-outlined text-[18px]">
                        close
                    </span>
                </button>
            @endif

        </div>

    </div>


    {{-- Document Table --}}
    <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-slate-50 border-b border-slate-200">

                    <tr>

                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase">
                            No
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase">
                            Jenis Dokumen
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase">
                            Nama File
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase">
                            Nasabah
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase">
                            Status Fisik
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase">
                            Status Digital
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase">
                            Diunggah Oleh
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase">
                            Tanggal Upload
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-200">

                    @forelse ($dokumen as $item)

                        <tr class="hover:bg-blue-50/40 transition-colors">

                            {{-- No --}}
                            <td class="px-5 py-4 text-sm text-slate-500">
                                {{ $dokumen->firstItem() + $loop->index }}
                            </td>


                            {{-- Jenis Dokumen --}}
                            <td class="px-5 py-4">

                                <span
                                    class="inline-flex items-center px-2.5 py-1
                                           rounded text-xs font-medium
                                           bg-blue-50 text-blue-700
                                           border border-blue-100"
                                >
                                    {{ $item->jenisDokumen?->nama_dokumen ?? '-' }}
                                </span>

                            </td>


                            {{-- Nama File --}}
                            <td class="px-5 py-4">

                                @if ($item->nama_file)

                                    <div class="flex items-center gap-2">

                                        <span
                                            class="material-symbols-outlined text-red-500 text-[20px]"
                                        >
                                            description
                                        </span>

                                        <span
                                            class="text-sm font-medium text-slate-700
                                                   max-w-[220px] truncate"
                                            title="{{ $item->nama_file }}"
                                        >
                                            {{ $item->nama_file }}
                                        </span>

                                    </div>

                                @else

                                    <span class="text-sm text-slate-400">
                                        Belum ada file
                                    </span>

                                @endif

                            </td>


                            {{-- Nasabah --}}
                            <td class="px-5 py-4">

                                <div class="text-sm font-medium text-slate-700">
                                    {{ $item->nasabah?->nama ?? '-' }}
                                </div>

                                @if ($item->nasabah?->nomor_nasabah)

                                    <div class="text-xs text-slate-400 mt-0.5">
                                        {{ $item->nasabah->nomor_nasabah }}
                                    </div>

                                @endif

                            </td>


                            {{-- Status Fisik --}}
                            <td class="px-5 py-4">

                                @if ($item->status_fisik === 'tersedia')

                                    <span
                                        class="inline-flex items-center gap-1
                                               px-2.5 py-1 rounded text-xs
                                               font-medium
                                               bg-green-50 text-green-700
                                               border border-green-100"
                                    >

                                        <span class="material-symbols-outlined text-[14px]">
                                            inventory_2
                                        </span>

                                        Tersedia

                                    </span>

                                @else

                                    <span
                                        class="inline-flex items-center gap-1
                                               px-2.5 py-1 rounded text-xs
                                               font-medium
                                               bg-red-50 text-red-700
                                               border border-red-100"
                                    >

                                        <span class="material-symbols-outlined text-[14px]">
                                            inventory_2
                                        </span>

                                        Tidak Tersedia

                                    </span>

                                @endif

                            </td>


                            {{-- Status Digital --}}
                            <td class="px-5 py-4">

                                @if ($item->status_digital === 'tersedia')

                                    <span
                                        class="inline-flex items-center gap-1
                                               px-2.5 py-1 rounded text-xs
                                               font-medium
                                               bg-green-50 text-green-700
                                               border border-green-100"
                                    >

                                        <span class="material-symbols-outlined text-[14px]">
                                            cloud_done
                                        </span>

                                        Tersedia

                                    </span>

                                @else

                                    <span
                                        class="inline-flex items-center gap-1
                                               px-2.5 py-1 rounded text-xs
                                               font-medium
                                               bg-amber-50 text-amber-700
                                               border border-amber-100"
                                    >

                                        <span class="material-symbols-outlined text-[14px]">
                                            cloud_off
                                        </span>

                                        Belum Tersedia

                                    </span>

                                @endif

                            </td>


                            {{-- Uploader --}}
                            <td class="px-5 py-4 text-sm text-slate-600">
                                {{ $item->uploader?->name ?? '-' }}
                            </td>


                            {{-- Tanggal Upload --}}
                            <td class="px-5 py-4 text-sm text-slate-500">

                                @if ($item->uploaded_at)

                                    {{ $item->uploaded_at->format('d M Y H:i') }}

                                @else

                                    -

                                @endif

                            </td>


                            {{-- Aksi --}}
                            <td class="px-5 py-4">

                                <div class="flex justify-center gap-2">

                                    @if ($item->path_file)

                                        {{-- Preview --}}
                                        <a
                                            href="{{ route('user.dokumen.preview', $item) }}"
                                            target="_blank"
                                            class="p-2 text-blue-600 hover:bg-blue-50 hover:text-blue-800 rounded transition-colors"
                                            title="Preview dokumen"
                                        >

                                            <span class="material-symbols-outlined text-[20px]">
                                                visibility
                                            </span>

                                        </a>


                                        {{-- Download --}}
                                        <a
                                            href="{{ route('user.dokumen.download', $item) }}"
                                            class="p-2 text-slate-600 hover:bg-slate-100 hover:text-slate-900 rounded transition-colors"
                                            title="Download dokumen"
                                        >

                                            <span class="material-symbols-outlined text-[20px]">
                                                download
                                            </span>

                                        </a>

                                    @else

                                        {{-- Tidak ada file --}}
                                        <span
                                            class="p-2 text-slate-300 cursor-not-allowed"
                                            title="File belum tersedia"
                                        >

                                            <span class="material-symbols-outlined text-[20px]">
                                                cloud_off
                                            </span>

                                        </span>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="9"
                                class="px-5 py-12 text-center"
                            >

                                <div class="flex flex-col items-center">

                                    <span
                                        class="material-symbols-outlined
                                               text-5xl text-slate-300"
                                    >
                                        folder_open
                                    </span>

                                    <p class="mt-3 text-sm font-medium text-slate-600">
                                        Tidak ada dokumen
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        @if(request('search'))
                                            Tidak ada dokumen yang sesuai dengan pencarian "{{ request('search') }}".
                                        @else
                                            Belum ada dokumen yang tersedia dalam sistem.
                                        @endif
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if ($dokumen->hasPages())

            <div class="px-5 py-4 border-t border-slate-200">

                {{ $dokumen->links() }}

            </div>

        @endif

    </div>

</div>

@endsection


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchDokumen');
    const clearButton = document.getElementById('clearSearch');

    if (!searchInput) {
        return;
    }

    let searchTimer = null;

    searchInput.addEventListener('input', function () {

        clearTimeout(searchTimer);

        const search = this.value.trim();

        searchTimer = setTimeout(function () {

            const url = new URL(window.location.href);

            /*
             * Jika search kosong:
             * hapus parameter search dan page.
             */
            if (search === '') {

                url.searchParams.delete('search');

            } else {

                /*
                 * Jika ada isi:
                 * masukkan parameter search.
                 */
                url.searchParams.set('search', search);
            }

            /*
             * Setiap pencarian dimulai dari halaman pertama.
             */
            url.searchParams.delete('page');

            window.location.href = url.toString();

        }, 500);
    });


    /*
     * Tombol X untuk menghapus pencarian.
     */
    if (clearButton) {

        clearButton.addEventListener('click', function () {

            const url = new URL(window.location.href);

            url.searchParams.delete('search');
            url.searchParams.delete('page');

            window.location.href = url.toString();

        });

    }

});
</script>

@endpush