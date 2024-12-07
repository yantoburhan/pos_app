<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    // parameter kedua validate(pesan error kustom)
    public $custom_message =
    [
        '*.required' => ':Attribute tidak boleh kosong.',
        'photo_path.max' => ':Aattribute maksimal berukuran :max kilobytes.',
        '*.max' => ':Attribute maksimal :max karakter.',
        '*.email' => ':Attribute harus berupa email yang valid.',
        '*.unique' => ':Attribute sudah terdaftar.',
        '*.min' => ':Attribute minimal :min karakter.',
        '*.alpha_num' => ':Attribute hanya terdiri dari hufur dan angka.',
        '*.image' => ':Attribute harus berupa gambar.',
        '*.mimes' => 'Format :attribute hanya diizinkan :mimes.'
    ];

    // parameter ketiga validate(kustom attribute)
    public $custom_attribute =
    [
        'name' => 'nama lengkap',
        'email' => 'alamat email',
        'username' => 'nama pengguna',
        'password' => 'kata sandi',
        'phone' => 'nomor telepon',
        'role' => 'jabatan',
        'photo_path' => 'foto profil'
    ];

    public function index() {
        $userLogin = auth()->id();

        if ($userLogin == 1) {
            // panggil semua data user dari tabel
            $users = User::all();
        } else {
            // jika user yang login bukanlah sebagai admin atau role == 1 maka hanya menampilkan data dirinya(yang login) saja
            $users = User::where('id', $userLogin)->get();
        }
        return view('users.index', ['users' => $users]);
    }

    // method menampilkan view form buat user baru
    public function create() {
        Gate::authorize('create', new User);
        return view('users.create');
    }
    // method simpan data user
    public function store(Request $request) {

        Gate::authorize('create', User::class);

        // validasi form
        $validasi = $request->validate([
            // array validasi pasangan name input dan rules
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|min:6|unique:users,username',
            'password' => 'required|min:8|alpha_num',
            'phone' => 'nullable|min:9',
            'role' => 'required',
            'photo_path' => 'nullable|image|max:1024|mimes:jpg,jpeg,png'
        ],
        $this->custom_message,
        $this->custom_attribute
    );

    $alamat = null;
    // periksa apakah ada file foto yang diunggah
    if ($request->hasFile('photo_path')) {
        $alamat = Storage::disk('public')->putFile('foto-profil', $request->file('photo_path'));
    }

    // simpan data form ke database
    $hasil = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'username' => $request->username,
        // kata sandi harus di hash
        'password' => Hash::make($request->password),
        'phone' => $request->phone,
        'role' => $request->role,
        'photo_path' => $alamat
    ]);

    // alihkan halaman jika sukses/gagal
    if($hasil) {
        return redirect()->route('users.index')->with('success', 'Data user berhasil disimpan');
    }

    return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data');

    }
    public function edit($id) {

    Gate::authorize('update', User::find($id));

    // temukan user
    $user = User::find($id);

    // cek jika user tidak ada
    if (!$user) {
        return to_route('users.index');
    }
    return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, $id) {

        Gate::authorize('update', User::find($id));

        // validasi data
        $validasi = $request->validate([
            // array validasi pasangan name input dan rules
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'username' => 'required|min:6|unique:users,username,' . $request->id,
            'phone' => 'nullable|min:9',
            'role' => 'required',
            'photo_path' => 'nullable|image|max:1024|mimes:jpg,jpeg,png'
        ],
        $this->custom_message,
        $this->custom_attribute
    );
        // simpan perubahan data
        $alamat = null;
        // periksa apakah ada file foto yang diunggah
        if ($request->hasFile('photo_path')) {
            $alamat = Storage::disk('public')->putFile('foto-profil', $request->file('photo_path'));
        }
        // proses ubah
        User::find($request->id)->update([
        'name' => $request->name,
        'email' => $request->email,
        'username' => $request->username,
        'phone' => $request->phone,
        'role' => $request->role,
        'photo_path' => $alamat
        ]);

        // alihkan halaman
        return to_route('users.index')->with('success', 'Data user berhasil diubah');
    }
    public function delete($id) {

        Gate::authorize('delete', User::find($id));

        User::find($id)->delete();
        return back()->with('success', 'Data user berhasil dihapus');
    }
}
