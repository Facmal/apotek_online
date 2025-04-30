<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserManageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search'); // Ambil input pencarian
        $query = User::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%'); // Filter berdasarkan nama atau email
        }

        return view('be.usermanage.index', [
            'title' => 'User Management',
            'menu' => 'User Management',
            'users' => $query->paginate(5), // Pagination dengan 5 item per halaman
            'search' => $search // Kirim kembali input pencarian ke view
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('be.usermanage.create', [
            'title' => 'Add User',
            'menu' => 'Add User'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $existingUser = DB::table('users')->where('email', '=', $request->email)->value('email');

        if ($existingUser) {
            return view('be.usermanage.create', [
                'title' => 'Add User',
                'menu' => 'Add User',
                'name' => $request->name,
                'jabatan' => $request->jabatan,
                'email' => $request->email,
                'pesan' => 'Email "' . $request->email . '" already exists!'
            ]);
        } else {
            $data = $request->only(['name', 'jabatan', 'email', 'password']);
            $data['password'] = bcrypt($data['password']); // Encrypt password

            // Handle profile image upload
            if ($request->file('img_profile') !== null) {
                $data['img_profile'] = $request->file('img_profile')->store('Profile_Images');
            }

            $user = User::create($data);

            if ($user) {
                return redirect()->route('usermanage.index')->with('pesan', 'User successfully added!');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('be.usermanage.edit', [
            'title' => 'Edit User',
            'menu' => 'Edit User',
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'jabatan' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'current_password' => 'nullable|required_with:password', // Password lama diperlukan jika password baru diisi
            'password' => 'nullable|min:6', // Validasi opsional untuk password baru
        ]);

        // Jika password baru diisi, periksa password lama
        if ($request->password) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('pesan', 'Password lama tidak sesuai.');
            }
        }

        $data = $request->only(['name', 'jabatan', 'email']);
        if ($request->password) {
            $data['password'] = bcrypt($request->password); // Enkripsi password baru
        }

        // Handle profile image update
        if ($request->file('img_profile')) {
            if ($user->img_profile) {
                unlink(storage_path('app/public/' . $user->img_profile));
            }
            $data['img_profile'] = $request->file('img_profile')->store('Profile_Images');
        }

        $user->update($data);

        return redirect()->route('usermanage.index')->with('pesan', 'User successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Delete profile image if exists
        if ($user->img_profile !== null) {
            unlink(storage_path('app/public/' . $user->img_profile));
        }

        $user->delete();

        return redirect()->route('usermanage.index')->with('pesan', 'User successfully deleted!');
    }
}
