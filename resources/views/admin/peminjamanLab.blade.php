@extends('layouts.app')

@section('title', 'Admin - Kelola Peminjaman')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Daftar Pengajuan Peminjaman</h1>

    {{-- AREA FILTER BARU --}}
    <div class="bg-white p-4 rounded-lg shadow-sm mb-6 border border-gray-200">
        <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            
            {{-- Filter Lab --}}
            <div class="w-full md:w-1/4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter Laboratorium</label>
                <select name="lab_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2 border">
                    <option value="">-- Semua Lab --</option>
                    @foreach($labs as $lab)
                        <option value="{{ $lab->id_lab }}" {{ request('lab_id') == $lab->id_lab ? 'selected' : '' }}>
                            {{ $lab->nama_lab }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Status --}}
            <div class="w-full md:w-1/4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter Status</label>
                <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2 border">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            {{-- Tombol Filter & Reset --}}
            <div class="flex gap-2">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition shadow">
                    Terapkan Filter
                </button>
                
                @if(request('lab_id') || request('status'))
                    <a href="{{ route('admin.peminjaman.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition shadow text-center flex items-center">
                        Reset
                    </a>
                @endif
            </div>

        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mahasiswa</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lab & Waktu</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kegiatan</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Surat</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjaman as $item)
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 font-bold">{{ $item->nama_peminjam }}</p>
                        <p class="text-gray-600 text-xs">NIM: {{ $item->nim }}</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 font-bold">{{ $item->nama_lab }}</p>
                        <p class="text-gray-600">{{ $item->tanggal }}</p>
                        <span class="text-indigo-600 font-semibold">{{ substr($item->jam_mulai, 0, 5) }} - {{ substr($item->jam_selesai, 0, 5) }}</span>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $item->kegiatan }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <a href="{{ asset('storage/' . $item->surat_file) }}" target="_blank" class="text-blue-500 hover:underline">
                            Lihat File
                        </a>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        @if($item->status == 'pending')
                            <span class="relative inline-block px-3 py-1 font-semibold text-yellow-900 leading-tight">
                                <span aria-hidden="true" class="absolute inset-0 bg-yellow-200 opacity-50 rounded-full"></span>
                                <span class="relative">Pending</span>
                            </span>
                        @elseif($item->status == 'disetujui')
                            <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                <span aria-hidden="true" class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Disetujui</span>
                            </span>
                        @else
                            <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                <span aria-hidden="true" class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                <span class="relative">Ditolak</span>
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        @if($item->status == 'pending')
                            <div class="flex gap-2">
                                {{-- Tombol Approve --}}
                                <form action="{{ route('admin.peminjaman.approve', $item->id) }}" method="POST" onsubmit="return confirm('Yakin setujui peminjaman ini?')">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-xs">
                                        ✓ Terima
                                    </button>
                                </form>

                                {{-- Tombol Reject (Memicu Modal/Form Kecil) --}}
                                <button onclick="openRejectModal({{ $item->id }})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">
                                    ✕ Tolak
                                </button>
                            </div>
                        @else
                            <span class="text-gray-400 text-xs">Selesai</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Sederhana untuk Alasan Penolakan --}}
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Tolak Peminjaman</h3>
            <div class="mt-2 px-7 py-3">
                <form id="rejectForm" method="POST">
                    @csrf
                    <textarea name="alasan_penolakan" class="w-full border p-2 rounded" placeholder="Masukkan alasan penolakan..." required></textarea>
                    <div class="items-center px-4 py-3">
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                            Kirim Penolakan
                        </button>
                        <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="mt-3 px-4 py-2 bg-gray-300 text-black text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openRejectModal(id) {
        // Set action form sesuai ID yang diklik
        let form = document.getElementById('rejectForm');
        form.action = "/admin/peminjaman/" + id + "/reject";
        
        // Tampilkan modal
        document.getElementById('rejectModal').classList.remove('hidden');
    }
</script>
@endsection