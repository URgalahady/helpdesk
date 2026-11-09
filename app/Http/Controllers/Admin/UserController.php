<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizeAdmin();

        $query = User::query()->whereIn('role', ['mahasiswa', 'dosen'])->orderBy('name');

        if ($request->filled('role') && in_array($request->role, ['mahasiswa', 'dosen'], true)) {
            $query->where('role', $request->role);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('nim', 'like', "%{$q}%")
                    ->orWhere('nidn_nip', 'like', "%{$q}%");
            });
        }

        $users = $query->paginate(15)->withQueryString();

        $stats = [
            'mahasiswa' => User::where('role', 'mahasiswa')->count(),
            'dosen' => User::where('role', 'dosen')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function edit(User $user): View
    {
        $this->authorizeAdmin();

        if (! in_array($user->role, ['mahasiswa', 'dosen', 'admin'], true)) {
            abort(404);
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'nim' => ['sometimes', 'nullable', 'string', 'max:50'],
            'nidn_nip' => ['sometimes', 'nullable', 'string', 'max:50'],
            'jurusan' => ['sometimes', 'nullable', 'string', 'max:255'],
            'program_studi' => ['sometimes', 'nullable', 'string', 'max:255'],
            'semester' => ['sometimes', 'nullable', 'string', 'max:20'],
            'status_pengajar' => ['sometimes', 'nullable', 'string', 'max:100'],
        ]);

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Profil pengguna berhasil diperbarui.');
    }

    protected function authorizeAdmin(): void
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
    }
}
