<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\User;

class TransactionController extends Controller
{
    public function create(Request $request)
    {
        // Pastikan ada setidaknya 1 user untuk dipakai sementara (karena belum ada fitur login)
        $user = User::firstOrCreate(
            ['email' => 'user@moneyme.test'],
            ['name' => 'User Pertama', 'password' => bcrypt('password')]
        );

        // Pastikan ada beberapa kategori dasar agar dropdown tidak kosong
        if (Category::count() == 0) {
            Category::create(['user_id' => $user->id, 'name' => 'Gaji', 'type' => 'income']);
            Category::create(['user_id' => $user->id, 'name' => 'Makan', 'type' => 'expense']);
            Category::create(['user_id' => $user->id, 'name' => 'Transportasi', 'type' => 'expense']);
            Category::create(['user_id' => $user->id, 'name' => 'Lainnya', 'type' => 'expense']);
        }

        $type = $request->query('type');
        
        $categoriesQuery = Category::orderBy('name');
        if ($type === 'income' || $type === 'expense') {
            $categoriesQuery->where('type', $type);
        }
        
        $categories = $categoriesQuery->get();

        return view('transactions.create', compact('categories', 'type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $category = Category::findOrFail($request->category_id);
        $user = User::first(); // Ambil user default

        Transaction::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'amount' => $request->amount,
            'type' => $category->type, // Tipe mengikuti kategori
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function quickAction(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:transaction_templates,id',
        ]);

        $template = \App\Models\TransactionTemplate::findOrFail($request->template_id);
        
        Transaction::create([
            'user_id' => $template->user_id,
            'category_id' => $template->category_id,
            'amount' => $template->amount,
            'type' => $template->type,
            'description' => $template->name,
            'date' => \Carbon\Carbon::now()->format('Y-m-d'),
        ]);

        return redirect()->route('dashboard')->with('success', "Transaksi '{$template->name}' berhasil dicatat!");
    }
}
