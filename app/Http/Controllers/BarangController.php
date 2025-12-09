<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::all();
        return view("barang.index", compact("barang"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("barang.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $img = null;
        if ($request->hasFile("foto")) {
            $file = $request->file("foto");
            $img = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/barang'), $img);

        }

        Barang::create([
            'nama_barang'=> $request->nama_barang,
            'merek' => $request->merek,
            'spesifikasi'=> $request->spesifikasi,
            'foto'=> $img,
        ]);

        return redirect()->route('barang.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.show', compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $barang = Barang::findOrFail($id);

        $img = $barang->foto;
        if ($request->hasFile('foto')){
            $file = $request->file('foto');
            $img = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/barang'), $img);
        }

        $barang->update([
            'nama_barang'=> $request->nama_barang,
            'merek'=> $request->merek,
            'spesifikasi'=> $request->spesifikasi,
            'foto'=> $img,
        ]);

        return redirect()->route('barang.index', $barang->id_barang)
        ->with('success', 'Data barang berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')
        ->with('success', 'Data barang berhasil dihapus');
    }
}
