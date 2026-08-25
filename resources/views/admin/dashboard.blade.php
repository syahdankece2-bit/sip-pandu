@extends('layouts.admin')

@section('title', 'SIP-PANDU - Dashboard Admin')

@section('breadcrumb')
<span class="text-sm font-medium text-on-surface-variant">Beranda / Dashboard</span>
@endsection

@section('content')

{{-- PAGE HEADER --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">

    <div>
        <h2 class="text-2xl font-semibold text-on-surface">Dashboard Admin</h2>
        <p class="text-sm text-on-surface-variant mt-1">
            Kelola data nasabah, arsip fisik, dokumen digital, dan pengguna sistem.
        </p>
    </div>

    {{-- LIVE INDICATOR --}}
    <div class="flex items-center gap-2 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 shadow-sm select-none self-start sm:self-auto">
        <span class="relative flex h-2.5 w-2.5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
        </span>
        <span class="text-xs font-medium text-emerald-700">Live</span>
        <span class="text-xs text-on-surface-variant ml-1">
            Update otomatis setiap 30 detik •
            <span id="lastRefreshed" class="font-medium text-on-surface">{{ now()->format('H:i:s') }}</span>
        </span>
    </div>

</div>


{{-- STATISTICS --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">

    {{-- TOTAL NASABAH --}}
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wide">Total Nasabah</span>
            <div class="p-2 bg-primary/10 rounded-full text-primary">
                <span class="material-symbols-outlined text-[20px]">groups</span>
            </div>
        </div>
        <div class="text-3xl font-bold text-on-surface" id="stat-total-nasabah">
            {{ number_format($totalNasabah) }}
        </div>
        <div class="text-xs mt-2 flex items-center gap-1
            {{ $pertumbuhanNasabah >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
            <span class="material-symbols-outlined text-[14px]">
                {{ $pertumbuhanNasabah >= 0 ? 'trending_up' : 'trending_down' }}
            </span>
            <span id="stat-growth-nasabah">
                {{ $pertumbuhanNasabah >= 0 ? '+' : '' }}{{ $pertumbuhanNasabah }}% bulan ini
                ({{ $nasabahBulanIni }} baru)
            </span>
        </div>
    </div>


    {{-- TOTAL DOKUMEN --}}
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wide">Total Dokumen</span>
            <div class="p-2 bg-primary/10 rounded-full text-primary">
                <span class="material-symbols-outlined text-[20px]">folder_copy</span>
            </div>
        </div>
        <div class="text-3xl font-bold text-on-surface" id="stat-total-dokumen">
            {{ number_format($totalDokumen) }}
        </div>
        <div class="text-xs mt-2 flex items-center gap-1
            {{ $pertumbuhanDokumen >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
            <span class="material-symbols-outlined text-[14px]">
                {{ $pertumbuhanDokumen >= 0 ? 'trending_up' : 'trending_down' }}
            </span>
            <span id="stat-growth-dokumen">
                {{ $pertumbuhanDokumen >= 0 ? '+' : '' }}{{ $pertumbuhanDokumen }}% bulan ini
                ({{ $dokumenBulanIni }} baru)
            </span>
        </div>
    </div>


    {{-- DOKUMEN DIGITAL --}}
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wide">Dokumen Digital</span>
            <div class="p-2 bg-emerald-100 rounded-full text-emerald-700">
                <span class="material-symbols-outlined text-[20px]">cloud_done</span>
            </div>
        </div>
        <div class="text-3xl font-bold text-on-surface" id="stat-dokumen-digital">
            {{ number_format($dokumenDigital) }}
        </div>
        <div class="text-xs text-on-surface-variant mt-2" id="stat-persen-digital">
            {{ $persenDigital }}% dari total dokumen
        </div>
    </div>


    {{-- BELUM DIGITAL --}}
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wide">Belum Digital</span>
            <div class="p-2 bg-red-100 rounded-full text-red-600">
                <span class="material-symbols-outlined text-[20px]">cloud_off</span>
            </div>
        </div>
        <div class="text-3xl font-bold text-on-surface" id="stat-belum-digital">
            {{ number_format($dokumenBelumDigital) }}
        </div>
        <div class="text-xs text-red-500 mt-2 flex items-center gap-1">
            <span class="material-symbols-outlined text-[14px]">warning</span>
            Perlu digitalisasi
        </div>
    </div>


    {{-- PETUGAS AKTIF --}}
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wide">Petugas Aktif</span>
            <div class="p-2 bg-primary/10 rounded-full text-primary">
                <span class="material-symbols-outlined text-[20px]">support_agent</span>
            </div>
        </div>
        <div class="text-3xl font-bold text-on-surface" id="stat-petugas-aktif">
            {{ number_format($petugasAktif) }}
        </div>
        <div class="text-xs text-on-surface-variant mt-2">
            Petugas terdaftar aktif
        </div>
    </div>

</div>


{{-- QUICK ACTIONS --}}
<div class="flex flex-wrap gap-3 mb-6">

    <a
        href="{{ route('admin.nasabah.create') }}"
        class="bg-primary text-white hover:bg-primary/90 font-medium py-2.5 px-4 rounded-lg shadow-sm flex items-center gap-2 transition-colors text-sm"
    >
        <span class="material-symbols-outlined text-[18px]">person_add</span>
        Tambah Nasabah
    </a>

    <a
        href="{{ route('admin.users') }}"
        class="bg-surface-container-lowest hover:bg-surface-container-low border border-outline-variant text-secondary font-medium py-2.5 px-4 rounded-lg shadow-sm flex items-center gap-2 transition-colors text-sm"
    >
        <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
        Kelola User
    </a>

    <a
        href="{{ route('admin.jenis-dokumen') }}"
        class="bg-surface-container-lowest hover:bg-surface-container-low border border-outline-variant text-secondary font-medium py-2.5 px-4 rounded-lg shadow-sm flex items-center gap-2 transition-colors text-sm"
    >
        <span class="material-symbols-outlined text-[18px]">category</span>
        Jenis Dokumen
    </a>

    <a
        href="{{ route('admin.settings') }}"
        class="bg-surface-container-lowest hover:bg-surface-container-low border border-outline-variant text-secondary font-medium py-2.5 px-4 rounded-lg shadow-sm flex items-center gap-2 transition-colors text-sm"
    >
        <span class="material-symbols-outlined text-[18px]">settings</span>
        Pengaturan
    </a>

</div>


{{-- MAIN CONTENT: TABLES --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">


    {{-- NASABAH TERBARU --}}
    <div class="xl:col-span-2 bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden">

        <div class="p-4 border-b border-outline-variant flex justify-between items-center">
            <h3 class="text-base font-semibold text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px] text-primary">group</span>
                Nasabah Terbaru
            </h3>
            <a
                href="{{ route('admin.nasabah.index') }}"
                class="text-primary text-sm font-medium hover:underline"
            >
                Lihat Semua →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-surface-container-low border-b border-outline-variant">
                    <tr class="text-xs font-semibold text-on-surface-variant uppercase">
                        <th class="px-4 py-3">No Nasabah</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Lokasi Arsip</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-outline-variant">

                    @forelse ($nasabahTerbaru as $nasabah)
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="px-4 py-3 font-mono text-primary text-xs">
                                {{ $nasabah->nomor_nasabah }}
                            </td>
                            <td class="px-4 py-3 font-medium text-on-surface">
                                {{ $nasabah->nama }}
                            </td>
                            <td class="px-4 py-3 text-on-surface-variant text-xs">
                                @if ($nasabah->lokasiArsip)
                                    {{ $nasabah->lokasiArsip->rak }}
                                    @if($nasabah->lokasiArsip->nomor_map)
                                        - Map {{ $nasabah->lokasiArsip->nomor_map }}
                                    @endif
                                @else
                                    <span class="text-on-surface-variant/60 italic">Belum diatur</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($nasabah->status === 'aktif')
                                    <span class="px-2 py-0.5 rounded-full text-xs bg-emerald-100 text-emerald-700 font-medium">Aktif</span>
                                @elseif ($nasabah->status === 'nonaktif')
                                    <span class="px-2 py-0.5 rounded-full text-xs bg-red-100 text-red-700 font-medium">Nonaktif</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-xs bg-yellow-100 text-yellow-700 font-medium">{{ ucfirst($nasabah->status) }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <a
                                    href="{{ route('admin.nasabah.show', $nasabah->id) }}"
                                    class="text-primary text-xs font-medium hover:underline"
                                >
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-on-surface-variant text-sm italic">
                                Belum ada data nasabah.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>


    {{-- DOKUMEN TERBARU --}}
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm flex flex-col">

        <div class="p-4 border-b border-outline-variant flex items-center justify-between">
            <h3 class="text-base font-semibold text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px] text-primary">history</span>
                Dokumen Terbaru
            </h3>
            <a
                href="{{ route('admin.nasabah.index') }}"
                class="text-primary text-xs font-medium hover:underline"
            >
                Lihat Semua →
            </a>
        </div>

        <div class="p-4 space-y-3 flex-1">

            @forelse ($dokumenTerbaru as $doc)
                @php
                    $ext = strtolower(pathinfo($doc->nama_file ?? '', PATHINFO_EXTENSION));
                    $iconClass = match($ext) {
                        'pdf'  => 'bg-red-100 text-red-600',
                        'jpg', 'jpeg', 'png', 'gif' => 'bg-purple-100 text-purple-600',
                        'doc', 'docx' => 'bg-blue-100 text-primary',
                        'xls', 'xlsx' => 'bg-green-100 text-green-700',
                        default => 'bg-surface-container text-on-surface-variant',
                    };
                    $icon = match($ext) {
                        'pdf'  => 'picture_as_pdf',
                        'jpg', 'jpeg', 'png', 'gif' => 'image',
                        'doc', 'docx' => 'description',
                        'xls', 'xlsx' => 'table_chart',
                        default => 'insert_drive_file',
                    };
                @endphp

                <div class="flex items-start gap-3 p-2.5 rounded-lg hover:bg-surface-container-low transition-colors">
                    <div class="p-2 rounded-lg {{ $iconClass }} flex-shrink-0">
                        <span class="material-symbols-outlined text-[20px]">{{ $icon }}</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-medium text-sm text-on-surface truncate" title="{{ $doc->nama_file }}">
                            {{ $doc->nama_file ?? 'Dokumen Tanpa Nama' }}
                        </p>
                        <p class="text-xs text-on-surface-variant mt-0.5">
                            {{ $doc->nasabah->nomor_nasabah ?? '-' }}
                            @if($doc->jenisDokumen)
                                • {{ $doc->jenisDokumen->nama }}
                            @endif
                        </p>
                        <p class="text-xs text-on-surface-variant/70 mt-0.5">
                            {{ $doc->uploaded_at ? $doc->uploaded_at->diffForHumans() : $doc->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-8 gap-2 text-on-surface-variant">
                    <span class="material-symbols-outlined text-[40px] opacity-40">folder_open</span>
                    <p class="text-sm italic">Belum ada dokumen yang diunggah.</p>
                </div>
            @endforelse

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
    /*
    |--------------------------------------------------------------------------
    | REAL-TIME STATS AUTO-REFRESH (polling setiap 30 detik)
    |--------------------------------------------------------------------------
    */
    const STATS_URL = '{{ url('/api/dashboard/stats') }}';
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    async function refreshStats() {
        try {
            const response = await fetch(STATS_URL, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                },
                credentials: 'same-origin',
            });

            if (!response.ok) return;

            const data = await response.json();

            // Update stat cards
            const el = (id) => document.getElementById(id);

            if (el('stat-total-nasabah'))   el('stat-total-nasabah').textContent   = data.total_nasabah.toLocaleString('id-ID');
            if (el('stat-total-dokumen'))   el('stat-total-dokumen').textContent   = data.total_dokumen.toLocaleString('id-ID');
            if (el('stat-dokumen-digital')) el('stat-dokumen-digital').textContent = data.dokumen_digital.toLocaleString('id-ID');
            if (el('stat-belum-digital'))   el('stat-belum-digital').textContent   = data.belum_digital.toLocaleString('id-ID');
            if (el('stat-petugas-aktif'))   el('stat-petugas-aktif').textContent   = data.petugas_aktif.toLocaleString('id-ID');
            if (el('stat-persen-digital'))  el('stat-persen-digital').textContent  = `${data.persen_digital}% dari total dokumen`;
            if (el('lastRefreshed'))        el('lastRefreshed').textContent         = data.refreshed_at;

        } catch (err) {
            console.warn('[Dashboard] Gagal mengambil statistik terbaru:', err);
        }
    }

    // Jalankan refresh setiap 30 detik
    setInterval(refreshStats, 30000);
</script>
@endpush