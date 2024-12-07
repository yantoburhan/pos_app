<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{

    // rules validasi
    protected $rules= [
            'stock' => 'nullable',
            'price' => 'required|min:0',
            'selling_price' => 'required|min:0',
            'description' => 'nullable',
        ];


    // custom attribute
    protected $attributes = [
        'name' => 'nama produk',
        'price' => 'harga modal',
        'selling_price' => 'harga jual',
        'description' => 'deskripsi produk',
    ];

    // custom message
    protected $messages= [
        '*.required' => ':Attribute tidak boleh kosong.',
        '*.min' => ':Attribute minimal bernilai :value',
        '*.unique' => ':Attribute sudah terdaftar.'
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // panggil semua data product
        // paginate berfungsi untuk menampilkan produk dalam bentuk halaman
        $products = Product::latest()->with(['user', 'category'])->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ('create' disesuaikan dengan yang ada di policy)
        Gate::authorize('create', Product::class);

        // panggil semua data kategori dan urutkan berdasarkan nama
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        // hanya admin yang boleh simpan data berdasarkan policy yang ada di ProductPolicy
        Gate::authorize('create', Product::class);

        // validasi data
        $rules = $this->rules;
        $rules['name'] = 'required|unique:products,name';
        $validated = $request->validate($rules, $this->messages,$this->attributes);

        // simpan data
        $simpan = Product::create([
            'category_id' => $request->category,
            'user_id' => Auth::id(),
            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price,
            'selling_price' => $request->selling_price,
            'description' => $request->description,
        ]);
        return to_route('products.index')->with('success', 'Data produk berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        Gate::authorize('update', $product);
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        Gate::authorize('update', $product);
        // validasi data
        $rules = $this->rules;
        $rules['name'] = 'required|unique:products,name,' . $product->id;
        $validated = $request->validate($rules, $this->messages,$this->attributes);

        // simpan data
        $product->update([
            'category_id' => $request->category,
            'user_id' => Auth::id(),
            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price,
            'selling_price' => $request->selling_price,
            'description' => $request->description,
        ]);
        return to_route('products.index')->with('success', 'Data produk berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Gate::authorize('delete', $product);
        $product->delete();
        return back()->with('success', 'Data produk berhasil dihapus.');
    }
}
