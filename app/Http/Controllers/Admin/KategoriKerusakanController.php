<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKerusakan;
use Illuminate\Http\Request;

class KategoriKerusakanController extends Controller
{
    public function index()
    {
        $kategoris = KategoriKerusakan::latest()->paginate(15);
        return view('admin.kategori-kerusakan.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori-kerusakan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'aktif' => ['nullable', 'boolean'],
        ]);

        $validated['aktif'] = $request->boolean('aktif');
        KategoriKerusakan::create($validated);

        return redirect()->route('admin.kategori-kerusakan.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(KategoriKerusakan $kategori_kerusakan)
    {
        return view('admin.kategori-kerusakan.show', ['kategoriKerusakan' => $kategori_kerusakan]);
    }

    public function edit(KategoriKerusakan $kategori_kerusakan)
    {
        return view('admin.kategori-kerusakan.edit', ['kategoriKerusakan' => $kategori_kerusakan]);
    }

    public function update(Request $request, KategoriKerusakan $kategori_kerusakan)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'aktif' => ['nullable', 'boolean'],
        ]);

        $validated['aktif'] = $request->boolean('aktif');
        $kategori_kerusakan->update($validated);

        return redirect()->route('admin.kategori-kerusakan.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(KategoriKerusakan $kategori_kerusakan)
    {
        abort_if($kategori_kerusakan->laporan()->exists(), 422, 'Kategori sudah digunakan pada laporan dan tidak dapat dihapus.');
        $kategori_kerusakan->delete();

        return redirect()->route('admin.kategori-kerusakan.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
