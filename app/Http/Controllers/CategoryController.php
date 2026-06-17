<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Kategori;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Kategori::withCount('tiket')->latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori',
        ]);

        Kategori::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Kategori $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Kategori $category)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $category->id,
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy(Kategori $category)
    {
        if ($category->tiket()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Tidak bisa menghapus kategori yang masih memiliki ticket!');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
