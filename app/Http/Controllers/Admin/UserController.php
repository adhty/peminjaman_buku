<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Anggota;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.user.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('anggota');
        return view('admin.user.show', compact('user'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:100|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(6)],
            'role'     => 'required|in:admin,siswa',
        ], [
            'username.unique'   => 'Username sudah digunakan.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.min'      => 'Password minimal 6 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'username' => $request->username,
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        Anggota::create([
            'user_id' => $user->id,
            'nis' => 'NIS' . $user->id,
            'nama' => $user->name,
            'kelas' => 'Kelas 1',
            'alamat' => null,
            'no_telp' => null,
        ]);

        return redirect()->route('admin.user.index')
            ->with('success', 'User "' . $request->name . '" berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:100|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::min(6)],
            'role'     => 'required|in:admin,siswa',
        ], [
            'username.unique'    => 'Username sudah digunakan.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'username' => $request->username,
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')
            ->with('success', 'Data user "' . $user->name . '" berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun yang sedang digunakan.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.user.index')
            ->with('success', 'User "' . $name . '" berhasil dihapus.');
    }
}
