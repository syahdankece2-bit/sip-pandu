@extends('layouts.user')

@section('title', 'Data Nasabah')

@section('content')

<div class="p-6 md:p-8">

    {{-- Header Halaman --}}
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-900">
            Data Nasabah
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Daftar arsip dokumen nasabah yang tercatat dalam sistem.
        </p>
    </div>


    {{-- Filter --}}
    <div class="bg-white border border-slate-200 rounded-lg p-5 mb-6">

        <form
            method="GET"
            action="{{ route('user.nasabah.index') }}"
            class="grid grid-cols-1 md:grid-cols-2 gap-4"
        >

            {{-- Search --}}
            <div>
                <label
                    for="search"
                    class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2"
                >
                    Pencarian Nasabah
                </label>

                <div class="relative">

                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"
                    >
                        search
                    </span>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Nomor Nasabah atau Nama..."
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-md text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                    >

                </div>
            </div>


            {{-- Status --}}
            <div>
                <label
                    for="status"
                    class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2"
                >
                    Status Nasabah
                </label>

                <select
                    id="status"
                    name="status"
                    onchange="this.form.submit()"
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-md text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                >

                    <option value="">
                        Semua Status
                    </option>

                    <option
                        value="aktif"
                        {{ request('status') === 'aktif' ? 'selected' : '' }}
                    >
                        Aktif
                    </option>

                    <option
                        value="nonaktif"
                        {{ request('status') === 'nonaktif' ? 'selected' : '' }}
                    >
                        Non-Aktif
                    </option>

                </select>
            </div>

        </form>

    </div>


    {{-- Tabel Data Nasabah --}}
    <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse">

                {{-- Header --}}
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">

                        <th class="py-3 px-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Nomor Nasabah
                        </th>

                        <th class="py-3 px-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Nama Lengkap
                        </th>

                        <th class="py-3 px-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Lokasi Arsip
                        </th>

                        <th class="py-3 px-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Status
                        </th>

                        <th class="py-3 px-4 text-xs font-semibold uppercase tracking-wider text-slate-500 text-right">
                            Aksi
                        </th>

                    </tr>
                </thead>


                {{-- Body --}}
                <tbody class="text-sm text-slate-700">

                    @forelse ($nasabah as $item)

                        <tr class="border-b border-slate-200 hover:bg-blue-50 transition-colors">

                            {{-- Nomor Nasabah --}}
                            <td class="py-4 px-4">

                                <span class="font-mono text-sm font-medium text-slate-900">
                                    {{ $item->nomor_nasabah }}
                                </span>

                            </td>


                            {{-- Nama --}}
                            <td class="py-4 px-4">

                                <span class="font-medium text-slate-900">
                                    {{ $item->nama }}
                                </span>

                            </td>


                            {{-- Lokasi Arsip --}}
                            <td class="py-4 px-4">

                                @if ($item->lokasiArsip)

                                    <div class="flex items-center gap-1 text-xs text-slate-500">

                                        <span>
                                            Rak {{ $item->lokasiArsip->rak }}
                                        </span>

                                        <span class="material-symbols-outlined text-[14px]">
                                            chevron_right
                                        </span>

                                        <span>
                                            Map {{ $item->lokasiArsip->nomor_map }}
                                        </span>

                                        <span class="material-symbols-outlined text-[14px]">
                                            chevron_right
                                        </span>

                                        <span class="font-semibold text-slate-900">
                                            {{ $item->lokasiArsip->posisi }}
                                        </span>

                                    </div>

                                @else

                                    <span class="text-xs text-slate-400 italic">
                                        Belum ada lokasi arsip
                                    </span>

                                @endif

                            </td>


                            {{-- Status --}}
                            <td class="py-4 px-4">

                                @if ($item->status === 'aktif')

                                    <span class="inline-flex items-center px-2.5 py-1 rounded bg-green-100 text-green-700 text-[11px] font-semibold uppercase tracking-wider">
                                        Aktif
                                    </span>

                                @else

                                    <span class="inline-flex items-center px-2.5 py-1 rounded bg-red-100 text-red-700 text-[11px] font-semibold uppercase tracking-wider">
                                        Non-Aktif
                                    </span>

                                @endif

                            </td>


                            {{-- Aksi --}}
                            <td class="py-4 px-4 text-right">

                                <a
                                    href="{{ route('user.nasabah.show', $item) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded transition-colors"
                                >

                                    Lihat Detail

                                    <span class="material-symbols-outlined text-[17px]">
                                        arrow_forward
                                    </span>

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="py-12 px-4 text-center"
                            >

                                <div class="flex flex-col items-center justify-center">

                                    <span class="material-symbols-outlined text-5xl text-slate-300">
                                        person_search
                                    </span>

                                    <p class="mt-3 text-sm font-medium text-slate-600">
                                        Data nasabah tidak ditemukan
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Belum ada data yang sesuai dengan pencarian.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if ($nasabah->hasPages() || $nasabah->total() > 0)

            <div class="px-4 py-4 border-t border-slate-200 bg-white flex flex-col sm:flex-row justify-between items-center gap-4">

                {{-- Info --}}
                <div class="text-xs text-slate-500">

                    Menampilkan

                    <span class="font-medium text-slate-700">
                        {{ $nasabah->firstItem() ?? 0 }}
                    </span>

                    -

                    <span class="font-medium text-slate-700">
                        {{ $nasabah->lastItem() ?? 0 }}
                    </span>

                    dari

                    <span class="font-medium text-slate-700">
                        {{ $nasabah->total() }}
                    </span>

                    data

                </div>


                {{-- Pagination --}}
                @if ($nasabah->hasPages())

                    <div class="flex items-center gap-1">

                        {{-- Previous --}}
                        @if ($nasabah->onFirstPage())

                            <span class="w-8 h-8 flex items-center justify-center border border-slate-200 rounded text-slate-300">
                                <span class="material-symbols-outlined text-[18px]">
                                    chevron_left
                                </span>
                            </span>

                        @else

                            <a
                                href="{{ $nasabah->previousPageUrl() }}"
                                class="w-8 h-8 flex items-center justify-center border border-slate-200 rounded text-slate-600 hover:bg-slate-50"
                            >
                                <span class="material-symbols-outlined text-[18px]">
                                    chevron_left
                                </span>
                            </a>

                        @endif


                        {{-- Page Numbers --}}
                        @foreach ($nasabah->getUrlRange(1, $nasabah->lastPage()) as $page => $url)

                            @if ($page == $nasabah->currentPage())

                                <span class="w-8 h-8 flex items-center justify-center bg-blue-600 text-white rounded text-xs font-semibold">
                                    {{ $page }}
                                </span>

                            @else

                                <a
                                    href="{{ $url }}"
                                    class="w-8 h-8 flex items-center justify-center border border-slate-200 text-slate-600 hover:bg-slate-50 rounded text-xs"
                                >
                                    {{ $page }}
                                </a>

                            @endif

                        @endforeach


                        {{-- Next --}}
                        @if ($nasabah->hasMorePages())

                            <a
                                href="{{ $nasabah->nextPageUrl() }}"
                                class="w-8 h-8 flex items-center justify-center border border-slate-200 rounded text-slate-600 hover:bg-slate-50"
                            >
                                <span class="material-symbols-outlined text-[18px]">
                                    chevron_right
                                </span>
                            </a>

                        @else

                            <span class="w-8 h-8 flex items-center justify-center border border-slate-200 rounded text-slate-300">
                                <span class="material-symbols-outlined text-[18px]">
                                    chevron_right
                                </span>
                            </span>

                        @endif

                    </div>

                @endif

            </div>

        @endif

    </div>

</div>

@endsection