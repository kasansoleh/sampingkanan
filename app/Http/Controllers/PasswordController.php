<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('account.password');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $request->user()->update(['password' => Hash::make($data['password'])]);

        return back()->with('success', 'Password akun Anda berhasil diubah.');
    }

    public function resetUserForm(User $user)
    {
        abort_unless($user->id !== auth()->id(), 404);
        return view('users.password', compact('user'));
    }

    public function resetUser(Request $request, User $user)
    {
        abort_unless($user->id !== auth()->id(), 404);

        $data = $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user->update(['password' => Hash::make($data['password'])]);

        return redirect()->route('users.index')->with('success', 'Password '.$user->name.' berhasil diubah.');
    }
}
