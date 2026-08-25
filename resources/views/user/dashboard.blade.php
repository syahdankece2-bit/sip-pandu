@extends('layouts.user')

@section('title', 'Dashboard Petugas')

@section('content')

    {{-- =========================================================
        WELCOME & SEARCH
    ========================================================== --}}
    <section class="flex flex-col items-center justify-center py-xl mb-lg">

        <h2 class="font-headline-md text-headline-md text-on-background mb-lg text-center">
            Dashboard Petugas SIP-PANDU
        </h2>

        <form
            action="{{ route('user.nasabah.index') }}"
            method="GET"
            class="w-full max-w-2xl relative"
        >

            {{-- Search Icon --}}
            <span
                class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline"
            >
                search
            </span>

            {{-- Search Input --}}
            <input
                type="text"
                name="search"
                placeholder="Masukkan nomor nasabah atau nama..."
                autocomplete="off"
                class="w-full pl-12 pr-24 py-lg font-body-lg text-body-lg
                       rounded-DEFAULT border border-outline-variant
                       bg-surface-container-lowest
                       focus:ring-2 focus:ring-secondary
                       focus:border-secondary outline-none
                       transition-shadow shadow-sm"
            >

            {{-- Search Button --}}
            <button
                type="submit"
                class="absolute right-xs top-xs bottom-xs
                       bg-secondary text-on-secondary
                       px-lg rounded-DEFAULT
                       font-label-md text-label-md
                       hover:bg-secondary-container
                       transition-colors"
            >
                CARI
            </button>

        </form>

    </section>


    {{-- =========================================================
        STATISTICS
    ========================================================== --}}
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-md">


        {{-- =====================================================
            TOTAL NASABAH
        ====================================================== --}}
        <div
            class="bg-surface-container-lowest
                   border border-outline-variant
                   rounded-lg p-lg
                   flex flex-col justify-between
                   hover:bg-surface-container-low
                   transition-colors group"
        >

            <div class="flex items-center justify-between mb-md">

                <h3
                    class="font-label-md text-label-md
                           text-on-surface-variant
                           uppercase tracking-wider"
                >
                    Total Nasabah
                </h3>

                <span
                    class="material-symbols-outlined
                           text-outline
                           group-hover:text-secondary
                           transition-colors"
                >
                    group
                </span>

            </div>


            <div>

                <p
                    class="font-headline-lg text-headline-lg
                           text-on-background"
                >
                    {{ number_format($totalNasabah) }}
                </p>

                <p
                    class="font-body-md text-body-md
                           text-outline mt-xs"
                >
                    Total nasabah terdaftar
                </p>

            </div>

        </div>


        {{-- =====================================================
            DOKUMEN DIGITAL TERSEDIA
        ====================================================== --}}
        <div
            class="bg-surface-container-lowest
                   border border-outline-variant
                   rounded-lg p-lg
                   flex flex-col justify-between
                   hover:bg-surface-container-low
                   transition-colors group"
        >

            <div class="flex items-center justify-between mb-md">

                <h3
                    class="font-label-md text-label-md
                           text-on-surface-variant
                           uppercase tracking-wider"
                >
                    Dokumen Digital Tersedia
                </h3>

                <span
                    class="material-symbols-outlined
                           text-outline
                           group-hover:text-secondary
                           transition-colors"
                >
                    verified
                </span>

            </div>


            <div>

                <p
                    class="font-headline-lg text-headline-lg
                           text-on-background"
                >
                    {{ number_format($dokumenDigitalTersedia) }}
                </p>

                <p
                    class="font-body-md text-body-md
                           text-outline mt-xs"
                >
                    Dokumen digital tersedia
                </p>

            </div>

        </div>


        {{-- =====================================================
            BELUM TERSEDIA
        ====================================================== --}}
        <div
            class="bg-surface-container-lowest
                   border border-outline-variant
                   rounded-lg p-lg
                   flex flex-col justify-between
                   hover:bg-error-container
                   transition-colors group"
        >

            <div class="flex items-center justify-between mb-md">

                <h3
                    class="font-label-md text-label-md
                           text-on-surface-variant
                           uppercase tracking-wider"
                >
                    Belum Tersedia
                </h3>

                <span
                    class="material-symbols-outlined
                           text-error
                           group-hover:text-on-error-container
                           transition-colors"
                >
                    warning
                </span>

            </div>


            <div>

                <p
                    class="font-headline-lg text-headline-lg
                           text-error
                           group-hover:text-on-error-container"
                >
                    {{ number_format($dokumenBelumTersedia) }}
                </p>

                <p
                    class="font-body-md text-body-md
                           text-outline
                           group-hover:text-on-error-container
                           mt-xs"
                >
                    Perlu digitalisasi
                </p>

            </div>

        </div>


        {{-- =====================================================
            DOKUMEN HARI INI
        ====================================================== --}}
        <div
            class="bg-surface-container-lowest
                   border border-outline-variant
                   rounded-lg p-lg
                   flex flex-col justify-between
                   hover:bg-surface-container-low
                   transition-colors group"
        >

            <div class="flex items-center justify-between mb-md">

                <h3
                    class="font-label-md text-label-md
                           text-on-surface-variant
                           uppercase tracking-wider"
                >
                    Dokumen Terbaru
                </h3>

                <span
                    class="material-symbols-outlined
                           text-outline
                           group-hover:text-secondary
                           transition-colors"
                >
                    update
                </span>

            </div>


            <div>

                <p
                    class="font-headline-lg text-headline-lg
                           text-on-background"
                >
                    {{ number_format($dokumenHariIni) }}
                </p>

                <p
                    class="font-body-md text-body-md
                           text-outline mt-xs"
                >
                    Diunggah hari ini
                </p>

            </div>

        </div>

    </section>


    {{-- =========================================================
        BOTTOM CONTENT
    ========================================================== --}}
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-xl mt-lg">


        {{-- =====================================================
            NASABAH TERBARU
        ====================================================== --}}
        <div
            class="bg-surface-container-lowest
                   border border-outline-variant
                   rounded-lg overflow-hidden
                   flex flex-col"
        >

            {{-- Header --}}
            <div
                class="bg-surface-container
                       p-md
                       border-b border-outline-variant"
            >

                <h3
                    class="font-label-md text-label-md
                           text-on-surface uppercase
                           flex items-center gap-sm"
                >

                    <span class="material-symbols-outlined text-secondary">
                        history
                    </span>

                    Nasabah Terbaru

                </h3>

            </div>


            {{-- Table --}}
            <div class="flex-1 overflow-auto">

                <table class="w-full text-left border-collapse">

                    <tbody>

                        @forelse ($nasabahTerbaru as $nasabah)

                            <tr
                                onclick="window.location='{{ route('user.nasabah.show', $nasabah) }}'"
                                class="border-b border-outline-variant
                                       hover:bg-surface-container-low
                                       transition-colors cursor-pointer"
                            >

                                {{-- Nasabah --}}
                                <td class="p-md py-sm">

                                    <div
                                        class="font-body-md text-body-md
                                               text-on-background font-medium"
                                    >
                                        {{ $nasabah->nama }}
                                    </div>

                                    <div
                                        class="font-mono-md text-mono-md
                                               text-outline"
                                    >
                                        CIF: {{ $nasabah->nomor_nasabah }}
                                    </div>

                                </td>


                                {{-- Lokasi --}}
                                <td class="p-md py-sm text-right">

                                    @if ($nasabah->lokasiArsip)

                                        <div
                                            class="inline-flex items-center gap-xs
                                                   px-sm py-xs
                                                   bg-surface-container
                                                   border border-outline-variant
                                                   rounded-DEFAULT
                                                   font-mono-md text-mono-md
                                                   text-on-surface-variant"
                                        >

                                            <span
                                                class="material-symbols-outlined text-xs"
                                            >
                                                folder_open
                                            </span>

                                            Rak {{ $nasabah->lokasiArsip->rak }}
                                            -
                                            Map {{ $nasabah->lokasiArsip->nomor_map }}

                                        </div>

                                    @else

                                        <span
                                            class="text-xs text-outline"
                                        >
                                            Lokasi belum tersedia
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="2"
                                    class="p-xl text-center"
                                >

                                    <span
                                        class="material-symbols-outlined
                                               text-4xl text-outline"
                                    >
                                        group_off
                                    </span>

                                    <p
                                        class="mt-sm
                                               text-sm
                                               text-on-surface-variant"
                                    >
                                        Belum ada data nasabah.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Footer --}}
            <div
                class="p-sm
                       bg-surface-container
                       text-center
                       border-t border-outline-variant"
            >

                <a
                    href="{{ route('user.nasabah.index') }}"
                    class="font-label-md text-label-md
                           text-secondary hover:underline"
                >
                    Lihat Semua Nasabah
                </a>

            </div>

        </div>



        {{-- =====================================================
            DOKUMEN TERBARU
        ====================================================== --}}
        <div
            class="bg-surface-container-lowest
                   border border-outline-variant
                   rounded-lg overflow-hidden
                   flex flex-col"
        >

            {{-- Header --}}
            <div
                class="bg-surface-container
                       p-md
                       border-b border-outline-variant
                       flex justify-between items-center"
            >

                <h3
                    class="font-label-md text-label-md
                           text-on-surface uppercase
                           flex items-center gap-sm"
                >

                    <span class="material-symbols-outlined text-secondary">
                        post_add
                    </span>

                    Dokumen Terbaru

                </h3>

            </div>


            {{-- Document List --}}
            <div
                class="flex-1 overflow-auto
                       p-md flex flex-col gap-sm"
            >

                @forelse ($dokumenTerbaru as $dokumen)

                    <div
                        class="flex items-start gap-md
                               p-sm
                               border border-outline-variant
                               rounded-DEFAULT
                               hover:border-secondary
                               transition-colors
                               bg-surface"
                    >

                        {{-- Icon --}}
                        <div
                            class="p-sm
                                   bg-secondary-fixed
                                   text-on-secondary-fixed
                                   rounded-DEFAULT
                                   flex items-center justify-center"
                        >

                            <span class="material-symbols-outlined">
                                description
                            </span>

                        </div>


                        {{-- Information --}}
                        <div class="flex-1 min-w-0">

                            <h4
                                class="font-body-md text-body-md
                                       font-medium text-on-background
                                       truncate"
                                title="{{ $dokumen->nama_file }}"
                            >
                                {{ $dokumen->nama_file ?? 'Belum ada file' }}
                            </h4>


                            <p
                                class="font-mono-md text-mono-md
                                       text-outline text-xs"
                            >

                                @if ($dokumen->uploaded_at)

                                    Diunggah:
                                    {{ $dokumen->uploaded_at->format('d M Y H:i') }}

                                @else

                                    Belum diunggah

                                @endif

                                • Oleh:
                                {{ $dokumen->uploader?->name ?? '-' }}

                            </p>

                        </div>


                        {{-- Status Baru --}}
                        @if (
                            $dokumen->uploaded_at &&
                            $dokumen->uploaded_at->isToday()
                        )

                            <span
                                class="font-label-md text-label-md
                                       text-secondary
                                       bg-surface-container-highest
                                       px-2 py-1
                                       rounded-DEFAULT"
                            >
                                Baru
                            </span>

                        @endif

                    </div>

                @empty

                    <div
                        class="flex-1
                               flex flex-col
                               items-center
                               justify-center
                               py-xl"
                    >

                        <span
                            class="material-symbols-outlined
                                   text-5xl text-outline"
                        >
                            folder_open
                        </span>

                        <p
                            class="mt-md
                                   text-sm
                                   font-medium
                                   text-on-surface"
                        >
                            Belum ada dokumen
                        </p>

                        <p
                            class="mt-xs
                                   text-xs
                                   text-outline"
                        >
                            Belum terdapat dokumen di dalam sistem.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- Footer --}}
            <div
                class="p-sm
                       bg-surface-container
                       text-center
                       border-t border-outline-variant"
            >

                <a
                    href="{{ route('user.dokumen.index') }}"
                    class="font-label-md text-label-md
                           text-secondary hover:underline"
                >
                    Lihat Semua Dokumen
                </a>

            </div>

        </div>

    </section>

@endsection