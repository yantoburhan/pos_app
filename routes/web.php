<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/halo/{nama}', function($nama) {
//     echo "Ha ini ada nasi " . $nama;
// });
// dapat mengisi alamat dengan parameter
Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function() {
    // route menu supplier
    Route::resource('suppliers', SupplierController::class);
    // route menu kategori
    Route::resource('categories', CategoryController::class);
    // Route menu product
    Route::resource('products', ProductController::class);
    // route untuk grup menu user
    Route::prefix('users')->group(function() {
        // tampilan semua user (index)
        Route::get('/index', [UserController::class, 'index'])->name('users.index');
        // tambah user baru (create)
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        // simpan data user baru (store)
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        // ubah user yang ada (edit)
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        // simpan perubahan data (update)
        Route::post('/update', [UserController::class, 'update'])->name('users.update');
        // hapus user (delete)
        Route::post('/{id}/delete', [UserController::class, 'delete'])->name('users.delete');
    });
});
