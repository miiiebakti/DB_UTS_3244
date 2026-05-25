<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $partners = Partner::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', '%' . $search . '%');
        })
        ->orderBy('id', 'asc')
        ->get();

        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo_url' => 'required',
            'description' => 'nullable',
            'website' => 'nullable'
        ]);

        Partner::create([
            'name' => $request->name,
            'logo_url' => $request->logo_url,
            'description' => $request->description,
            'website' => $request->website
        ]);

        return redirect()
            ->route('partners.index')
            ->with('success', 'Partner berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $partner = Partner::findOrFail($id);

        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'logo_url' => 'required',
            'description' => 'nullable',
            'website' => 'nullable'
        ]);

        $partner = Partner::findOrFail($id);

        $partner->update([
            'name' => $request->name,
            'logo_url' => $request->logo_url,
            'description' => $request->description,
            'website' => $request->website
        ]);

        return redirect()
            ->route('partners.index')
            ->with('success', 'Partner berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $partner = Partner::findOrFail($id);

        $partner->delete();

        return redirect()
            ->route('partners.index')
            ->with('success', 'Partner berhasil dihapus');
    }
}