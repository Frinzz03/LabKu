@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10">

    <h1 class="text-3xl font-bold mb-6 text-gray-800">Peminjaman Barang</h1>

    <div class="bg-white shadow-md rounded-xl p-6">

        <h2 class="text-2xl font-semibold mb-5 text-blue-700">Daftar Barang</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="border rounded-xl shadow-sm p-4 bg-gray-50 hover:shadow-lg transition">
                <img src="https://via.placeholder.com/200"
                    class="w-full h-40 object-cover rounded-md mb-3">

                <h3 class="font-bold text-lg">Nama Barang</h3>
                <p class="text-gray-600 text-sm">Merek Barang</p>

                <p class="mt-2 text-gray-700 text-sm">
                    Spesifikasi
                </p>

                <button
                    class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition">
                    Pinjam
                </button>
            </div>

        </div>

    </div>
</div>
@endsection
