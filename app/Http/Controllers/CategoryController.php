<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->with('user', 'products')->get();
        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Category::class);
        // terima data dari form modal
        $validated = Validator::validate($request->all(), [
            'name' => 'required|string|unique:categories,name',
        ], [
            'name.required' => 'Nama kategori tidak boleh kosong.',
            'name.string' => 'Penulisan nama kategori tidak Valid.',
            'name.unique' => 'Nama kategori sudah terdaftar'
        ]);

        Category::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
        ]);

        return back()->with('success', 'Data kategori berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        Gate::authorize('update', $category);
        // dd($request->all());
        $request->validate([
            'name' => 'required|unique:categories,name, '. $category->id,

        ], [
            'name.required' => 'Nama kategori tidak boleh kosong.',
            'name.string' => 'Nama kategori sudah terdaftar.'
        ]);

        $category->update([
            'name'=> $request->name
        ]);
        return back()->with('success', 'Data kategori berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Gate::authorize('delete', $category);
        $category->delete();
        return back()->with('success', 'Data kategori berhasil dihapus');
    }
}
