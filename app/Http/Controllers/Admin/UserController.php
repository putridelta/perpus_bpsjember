<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of users with search and filters.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $selectedRole = $request->query('role');
        $selectedStatus = $request->query('status');

        $query = User::withCount('readingLogs');

        if (! empty($search)) {
            $term = trim($search);
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('phone', 'like', "%{$term}%");
            });
        }

        if (! empty($selectedRole) && $selectedRole !== 'all') {
            $query->where('role', $selectedRole);
        }

        if (! empty($selectedStatus) && $selectedStatus !== 'all') {
            $query->where('status', $selectedStatus);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $memberCount = User::where('role', 'user')->count();
        $activeCount = User::where('status', 'active')->count();

        return view('admin.users.index', compact(
            'users',
            'search',
            'selectedRole',
            'selectedStatus',
            'totalUsers',
            'adminCount',
            'memberCount',
            'activeCount'
        ));
    }

    /**
     * Show form to create new user.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store newly created user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:admin,user'],
            'status' => ['required', 'in:active,inactive'],
            'phone' => ['nullable', 'string', 'max:30'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => $validated['status'],
            'phone' => $validated['phone'],
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna baru "'.$user->name.'" berhasil ditambahkan.');
    }

    /**
     * Display the specified user detail.
     */
    public function show(User $user): View
    {
        $user->load(['readingLogs.book', 'favorites.book']);
        $uniqueBooksReadCount = $user->readingLogs()->distinct('book_id')->count('book_id');
        $recentReads = $user->readingLogs()->with('book.category')->latest()->take(10)->get();
        $favorites = $user->favorites()->with('book.category')->latest()->get();

        return view('admin.users.show', compact('user', 'uniqueBooksReadCount', 'recentReads', 'favorites'));
    }

    /**
     * Show form to edit user.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user data.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', 'in:admin,user'],
            'status' => ['required', 'in:active,inactive'],
            'phone' => ['nullable', 'string', 'max:30'],
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan pengguna lain.',
        ]);

        // Prevent admin from deactivating or demoting themselves
        if ($user->id === Auth::id()) {
            if ($validated['status'] === 'inactive') {
                return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
            }
            if ($validated['role'] !== 'admin') {
                return back()->with('error', 'Anda tidak dapat mencabut hak akses admin Anda sendiri.');
            }
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->status = $validated['status'];
        $user->phone = $validated['phone'];

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Data pengguna "'.$user->name.'" berhasil diperbarui.');
    }

    /**
     * Toggle active/inactive status quickly.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat mengubah status akun Anda sendiri.');
        }

        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        $statusText = $user->status === 'active' ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', 'Status akun '.$user->name.' berhasil '.$statusText.'.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna "'.$userName.'" berhasil dihapus.');
    }
}
