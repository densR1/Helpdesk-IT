<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Kategori;
use Illuminate\Http\Request;

class FaqController extends Controller
{
public function index()
{
    $faqs = Faq::with('kategori')
        ->latest()
        ->get();

    return view('faq.index', compact('faqs'));
}

    public function create()
    {
        $categories = Kategori::all();
        return view('faq.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'question' => 'required',
            'answer' => 'nullable',
            'file' => 'nullable|file|mimes:jpg,png,pdf|max:2048'
        ]);

        $data = $request->only(['question', 'answer', 'kategori_id']);

        $data['is_active'] = false;

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('faq_files', 'public');
        }

        Faq::create($data);

        return redirect()->route('faq.index')->with('success', 'FAQ berhasil ditambahkan');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $categories = Kategori::all();

        return view('faq.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $data = $request->only(['question', 'answer', 'kategori_id']);

        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('faq_files', 'public');
        }

        $faq->update($data);

        return redirect()->route('faq.index')->with('success', 'FAQ berhasil diupdate');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return back()->with('success', 'FAQ berhasil dihapus');
    }

    // USER
    public function user()
    {
        $search = request('search');
        $category = request('category');

        $faqs = Faq::with('kategori')
            ->where('is_active', true)
            ->when($search, function ($query) use ($search) {
                $query->where('question', 'like', "%{$search}%");
            })
            ->when($category, function ($query) use ($category) {
                $query->where('kategori_id', $category);
            })
            ->latest()
            ->paginate(7);

        $categories = Kategori::all();

        return view('faq.user', compact('faqs', 'categories'));
    }

    // PUBLIC
    public function public()
    {
        $faqs = Faq::with('kategori')
            ->where('is_active', true)
            ->latest()
            ->paginate(7);

        return view('faq.public', compact('faqs'));
    }
}