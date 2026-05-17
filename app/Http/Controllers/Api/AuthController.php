<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Fungsi Register untuk User Flutter
    // Fungsi Register untuk User Flutter
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role untuk pendaftar dari mobile
        ]);

        // TAMBAHAN: Buat token langsung setelah berhasil create user
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 201);
    }

    // Fungsi Login untuk mendapatkan Token
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Kredensial salah'], 401);
        }

        // Buat token untuk device ini
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request)
{
    $user = $request->user();

    $request->validate([
        'name' => 'required|string|max:255',
        'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'old_password' => 'nullable|required_with:new_password',
        'new_password' => 'nullable|min:8',
    ]);

    // Update Nama
    $user->name = $request->name;

    // Update Foto jika ada
    if ($request->hasFile('foto_profil')) {
        // Hapus foto lama jika ada
        if ($user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
        }
        $path = $request->file('foto_profil')->store('profiles', 'public');
        $user->foto_profil = $path;
    }

    // Update Password jika diisi
    if ($request->new_password) {
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Password lama salah'], 422);
        }
        $user->password = Hash::make($request->new_password);
    }

    $user->save();

    return response()->json([
        'message' => 'Profil berhasil diperbarui',
        'user' => $user
    ]);
}

    // Fungsi Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Berhasil keluar']);
    }
}
