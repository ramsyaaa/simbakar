<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index(){
        return view('settings.changePassword.index');
    }

    public function changePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|different:old_password',
            'confirmation_password' => 'required|same:new_password',
        ], [
            'old_password.required' => 'Kata sandi lama wajib diisi.',
            'new_password.required' => 'Kata sandi baru wajib diisi.',
            'new_password.min' => 'Kata sandi baru minimal terdiri dari 8 karakter.',
            'new_password.different' => 'Kata sandi baru harus berbeda dengan kata sandi lama.',
            'confirmation_password.required' => 'Konfirmasi kata sandi wajib diisi.',
            'confirmation_password.same' => 'Konfirmasi kata sandi harus sama dengan kata sandi baru.',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors([
                'old_password' => 'Kata sandi lama tidak sesuai.',
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        // Kembalikan dengan pesan sukses
        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
