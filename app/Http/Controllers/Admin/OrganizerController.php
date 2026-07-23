<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OrganizerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $organizers = User::where('role', 'organizer')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('id')
            ->get();

        return view('admin.organizers.index', compact('organizers'));
    }

    public function create()
    {
        return view('admin.organizers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'organizer'
        ]);

        return redirect()
            ->route('organizers.index')
            ->with('success', 'Organizer berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $organizer = User::where('role', 'organizer')->findOrFail($id);

        return view('admin.organizers.edit', compact('organizer'));
    }

    public function update(Request $request, $id)
    {
        $organizer = User::where('role', 'organizer')->findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $organizer->id,
            'password' => 'nullable|min:6'
        ]);

        $organizer->name = $request->name;
        $organizer->email = $request->email;

        if ($request->filled('password')) {
            $organizer->password = Hash::make($request->password);
        }

        $organizer->save();

        return redirect()
            ->route('organizers.index')
            ->with('success', 'Organizer berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $organizer = User::where('role', 'organizer')->findOrFail($id);

        $organizer->delete();

        return redirect()
            ->route('organizers.index')
            ->with('success', 'Organizer berhasil dihapus.');
    }
}