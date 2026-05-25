<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $categories = Category::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', '%' . $search . '%');
        })
        ->orderBy('id', 'asc')
        ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required'
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required'
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}