<?php

namespace App\Http\Controllers;

use App\Models\TransactionTemplate;
use App\Models\Category;
use Illuminate\Http\Request;

class TransactionTemplateController extends Controller
{
    // Menampilkan daftar template milik user & form tambah template
    public function index()
    {
        // CATATAN: Karena belum ada fitur Login, kita pakai user pertama (Dummy)
        // Nanti jika ada Auth, ganti menjadi: auth()->user()->id
        $userId = \App\Models\User::first()->id ?? 1;

        $templates = TransactionTemplate::where('user_id', $userId)->get();
        $categories = Category::all();

        return view('templates.index', compact('templates', 'categories'));
    }

    // Menyimpan template baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string|max:10'
        ]);

        $userId = \App\Models\User::first()->id ?? 1; // Dummy user
        $category = Category::findOrFail($request->category_id);

        TransactionTemplate::create([
            'user_id' => $userId,
            'category_id' => $category->id,
            'name' => $request->name,
            'amount' => $request->amount,
            'type' => $category->type, // Ikuti tipe kategorinya
            'icon' => $request->icon ?? '⚡',
        ]);

        return redirect()->route('templates.index')->with('success', 'Template berhasil ditambahkan!');
    }

    // Menghapus template
    public function destroy(TransactionTemplate $template)
    {
        $template->delete();
        return redirect()->route('templates.index')->with('success', 'Template berhasil dihapus!');
    }
}
