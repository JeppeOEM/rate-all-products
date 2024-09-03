<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller

{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                $attributes = request()->validate([
                'username' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);
            
            $user = User::create($attributes);


    return inertia('FileList');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $attributes = $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:8',
        ]);

        $user->update($attributes);

        return inertia('FileList');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = User::findOrFail($id);
        $user->delete();

        return inertia('Auth/Login');
    }
}
