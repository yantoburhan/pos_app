<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $rules= [
        'name' => 'required|unique',
        'address' => 'required|min:0',
        'phone' => 'required|min:0',
        'fax' => 'nullable',
    ];


// custom attribute
    protected $attributes = [
        'name' => 'nama',
        'address' => 'alamat',
        'phone' => 'telepon',
        'fax' => 'faximile',
    ];

// custom message
    protected $messages= [
        '*.required' => ':Attribute tidak boleh kosong.',
        '*.min' => ':Attribute minimal bernilai :value',
        '*.unique' => ':Attribute sudah terdaftar.'
    ];

    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Supplier::class);
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Supplier::class);

        // validasi data
        $rules = $this->rules;
        $rules['name'] = 'required|unique:suppliers,name';
        $validated = $request->validate($rules, $this->messages,$this->attributes);

        // simpan data
        $simpan = Supplier::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'fax' => $request->fax,
        ]);
        return to_route('suppliers.index')->with('success', 'Data Supplier berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('suppliers.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {

        Gate::authorize('update', $supplier);

        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        Gate::authorize('update', $supplier);

        // validasi data
        $rules = $this->rules;
        $rules['name'] = 'required|unique:suppliers,name,' . $supplier->id;
        $validated = $request->validate($rules, $this->messages,$this->attributes);

        // simpan data
        $supplier->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'fax' => $request->fax,
        ]);
        return to_route('suppliers.index')->with('success', 'Data Supplier berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        Gate::authorize('delete', $supplier);
        $supplier->delete();
        return back()->with('success', 'Data Supplier berhasil dihapus.');
    }
}
