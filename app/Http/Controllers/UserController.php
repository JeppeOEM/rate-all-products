<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller

{
 

    public function store(Request $request)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => bcrypt($attributes['password']),
        ]);

        return redirect('Home');
    }


    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $attributes = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:8',
        ]);

        $user->update($attributes);

        return inertia('Home');
    }


    public function destroy(string $id)
    {

        $user = User::findOrFail($id);
        $user->delete();

        return inertia('Auth/Login');
    }
}
