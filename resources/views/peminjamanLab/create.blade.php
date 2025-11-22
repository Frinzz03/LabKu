@extends('layouts.app')

@section('title', 'Peminjaman Laboratorium')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            {{-- Header --}}
            <div class="flex items-center gap-3 mb-6">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h1 class="text-3xl font-bold text-gray-800">Peminjaman Laboratorium</h1>
            </div>

            {{-- Alert Success --}}
            @if(session('success'))
            <div class="mb-6 bg-green-50 border-2 border-green-300 rounded-lg p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="font-semibold text-green-800">Berhasil!</p>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            {{-- Alert Error Global --}}
            @if($errors->has('error'))
            <div class="mb-6 bg-red-50 border-2 border-red-300 rounded-lg p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="font-semibold text-red-800">Error!</p>
                    <p class="text-sm text-red-700">{{ $errors->first('error') }}</p>
                </div>
            </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    {{-- Pilih Lab --}}
                    <div>
                        <label for="lab_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Pilih Laboratorium <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="lab_id" 
                            id="lab_id" 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('lab_id') border-red-500 @enderror"
                            required
                            onchange="checkAvailability()"
                        >
                            <option value="">-- Pilih Lab --</option>
                            @foreach($labs as $lab)
                                <option value="{{ $lab->id_lab }}" {{ old('lab_id') == $lab->id_lab ? 'selected' : '' }}>
                                    {{ $lab->nama_lab }}
                                </option>
                            @endforeach
                        </select>
                        @error('lab_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Peminjaman --}}
                    <div>
                        <label for="tanggal" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Peminjaman <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            name="tanggal" 
                            id="tanggal" 
                            value="{{ old('tanggal') }}"
                            min="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('tanggal') border-red-500 @enderror"
                            required
                            onchange="checkAvailability()"
                        >
                        @error('tanggal')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jam Mulai dan Selesai --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="jam_mulai" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Jam Mulai <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="time" 
                                name="jam_mulai" 
                                id="jam_mulai" 
                                value="{{ old('jam_mulai') }}"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('jam_mulai') border-red-500 @enderror"
                                required
                                onchange="checkAvailability()"
                            >
                            @error('jam_mulai')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jam_selesai" class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Jam Selesai <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="time" 
                                name="jam_selesai" 
                                id="jam_selesai" 
                                value="{{ old('jam_selesai') }}"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('jam_selesai') border-red-500 @enderror"
                                required
                                onchange="checkAvailability()"
                            >
                            @error('jam_selesai')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Area untuk menampilkan jadwal yang sudah dipesan --}}
                    <div id="availability-info" class="hidden">
                        <div class="bg-red-50 border-2 border-red-300 rounded-lg p-4 flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-red-800">Waktu Tidak Tersedia!</p>
                                <p class="text-sm text-red-700">Laboratorium ini sudah dipesan pada waktu yang Anda pilih. Silakan pilih waktu lain.</p>
                            </div>
                        </div>
                    </div>

                    <div id="booked-slots" class="hidden">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="font-semibold text-gray-700 mb-2">Jadwal yang sudah dipesan:</p>
                            <div id="slots-list" class="space-y-2"></div>
                        </div>
                    </div>

                    {{-- Kegiatan / Keperluan --}}
                    <div>
                        <label for="kegiatan" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kegiatan / Keperluan <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            name="kegiatan" 
                            id="kegiatan" 
                            rows="4"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none @error('kegiatan') border-red-500 @enderror"
                            placeholder="Jelaskan kegiatan atau keperluan peminjaman lab..."
                            required
                        >{{ old('kegiatan') }}</textarea>
                        @error('kegiatan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Upload Surat Peminjaman --}}
                    <div>
                        <label for="surat" class="block text-sm font-semibold text-gray-700 mb-2">
                            Upload Surat Peminjaman (PDF/JPG/PNG) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="file" 
                            name="surat" 
                            id="surat" 
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('surat') border-red-500 @enderror"
                            required
                        >
                        <p class="mt-1 text-xs text-gray-500">Maksimal ukuran file: 2MB</p>
                        @error('surat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <button 
                        type="submit"
                        id="submit-btn"
                        class="w-full py-4 rounded-lg font-semibold text-white transition-all transform hover:scale-[1.02] bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 shadow-lg"
                    >
                        Ajukan Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script untuk cek ketersediaan via AJAX --}}
<script>
function checkAvailability() {
    const labId = document.getElementById('lab_id').value;
    const tanggal = document.getElementById('tanggal').value;
    const jamMulai = document.getElementById('jam_mulai').value;
    const jamSelesai = document.getElementById('jam_selesai').value;

    // Reset tampilan
    document.getElementById('availability-info').classList.add('hidden');
    document.getElementById('booked-slots').classList.add('hidden');
    document.getElementById('submit-btn').disabled = false;
    document.getElementById('submit-btn').classList.remove('bg-gray-400', 'cursor-not-allowed');
    document.getElementById('submit-btn').classList.add('bg-gradient-to-r', 'from-indigo-600', 'to-blue-600');

    if (!labId || !tanggal) {
        return;
    }

    // Kirim AJAX request untuk cek ketersediaan
    fetch(`{{ route('peminjaman.check-availability') }}?lab_id=${labId}&tanggal=${tanggal}&jam_mulai=${jamMulai}&jam_selesai=${jamSelesai}`)
        .then(response => response.json())
        .then(data => {
            // Tampilkan jadwal yang sudah dipesan
            if (data.bookedSlots && data.bookedSlots.length > 0) {
                const slotsList = document.getElementById('slots-list');
                slotsList.innerHTML = '';
                
                data.bookedSlots.forEach(slot => {
                    const div = document.createElement('div');
                    div.className = 'bg-red-100 border border-red-300 rounded px-3 py-2 text-sm text-red-800';
                    div.textContent = `${slot.jam_mulai} - ${slot.jam_selesai} (${slot.kegiatan})`;
                    slotsList.appendChild(div);
                });
                
                document.getElementById('booked-slots').classList.remove('hidden');
            }

            // Jika bentrok
            if (data.isBentrok && jamMulai && jamSelesai) {
                document.getElementById('availability-info').classList.remove('hidden');
                document.getElementById('submit-btn').disabled = true;
                document.getElementById('submit-btn').classList.add('bg-gray-400', 'cursor-not-allowed');
                document.getElementById('submit-btn').classList.remove('bg-gradient-to-r', 'from-indigo-600', 'to-blue-600');
                document.getElementById('submit-btn').textContent = 'Waktu Tidak Tersedia';
            } else {
                document.getElementById('submit-btn').textContent = 'Ajukan Peminjaman';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
</script>
@endsection