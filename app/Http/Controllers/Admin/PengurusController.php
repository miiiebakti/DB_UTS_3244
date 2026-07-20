<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $penguruses = Pengurus::with('jabatan')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('admin.pengurus.index', compact('penguruses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jabatans = Jabatan::all();

        return view('admin.pengurus.create', compact('jabatans'));
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jabatan_id' => 'required|exists:jabatans,id',
            'name'        => 'required|max:100',
            'description' => 'nullable|max:255',
            'salary'      => 'required|numeric',
        ]);

        Pengurus::create($validated);

        return redirect()
            ->route('pengurus.index')
            ->with('success', 'Data pengurus berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengurus $penguru)
    {
        $jabatans = Jabatan::all();

        return view('admin.pengurus.edit', [
            'pengurus' => $penguru,
            'jabatans' => $jabatans,
        ]);
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Pengurus $penguru)
    {
        $validated = $request->validate([
            'jabatan_id' => 'required|exists:jabatans,id',
            'name'        => 'required|max:100',
            'description' => 'nullable|max:255',
            'salary'      => 'required|numeric',
        ]);

        $penguru->update($validated);

        return redirect()
            ->route('pengurus.index')
            ->with('success', 'Data pengurus berhasil diupdate.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Pengurus $penguru)
    {
        $penguru->delete();

        return redirect()
            ->route('pengurus.index')
            ->with('success', 'Data pengurus berhasil dihapus.');
    }
}