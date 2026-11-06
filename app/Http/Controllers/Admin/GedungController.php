<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gedung;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GedungController extends Controller
{
    public function index()
    {
        $gedungs = Gedung::latest()->paginate(15);
        return view('admin.gedungs.index', compact('gedungs'));
    }

    public function create()
    {
        return view('admin.gedungs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_gedung' => ['required', 'string', 'max:255'],
            'kode_gedung' => ['nullable', 'string', 'max:50', 'unique:gedungs,kode_gedung'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'aktif' => ['nullable', 'boolean'],
        ]);

        $validated['aktif'] = $request->boolean('aktif');
        Gedung::create($validated);

        return redirect()->route('admin.gedungs.index')->with('success', 'Gedung berhasil ditambahkan.');
    }

    public function show(Gedung $gedung)
    {
        return view('admin.gedungs.show', compact('gedung'));
    }

    public function edit(Gedung $gedung)
    {
        return view('admin.gedungs.edit', compact('gedung'));
    }

    public function update(Request $request, Gedung $gedung)
    {
        $validated = $request->validate([
            'nama_gedung' => ['required', 'string', 'max:255'],
            'kode_gedung' => ['nullable', 'string', 'max:50', Rule::unique('gedungs', 'kode_gedung')->ignore($gedung->id)],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'aktif' => ['nullable', 'boolean'],
        ]);

        $validated['aktif'] = $request->boolean('aktif');
        $gedung->update($validated);

        return redirect()->route('admin.gedungs.index')->with('success', 'Gedung berhasil diperbarui.');
    }

    public function destroy(Gedung $gedung)
    {
        abort_if($gedung->laporan()->exists(), 422, 'Gedung sudah digunakan pada laporan dan tidak dapat dihapus.');
        $gedung->delete();

        return redirect()->route('admin.gedungs.index')->with('success', 'Gedung berhasil dihapus.');
    }
}
