<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller {

    public function logout() {
        auth()->logout();
        return redirect('/');
    }

    public function register(Request $request) {
        $incomingFields = $request->validate(
            [
                'name' => ['required', 'min:3', 'max:20', Rule::unique('users', 'name')],
                'email' => ['required', Rule::unique('users', 'email')],
                'password' => ['required']
            ]
        );

        // Hash user's password before putting it into the db.
        $incomingFields['password'] = bcrypt($incomingFields['password']);

        // Create an instance of a User.
        $user = User::create($incomingFields);

        // Automatically log in the user after creation.
        auth()->login($user);

        // Redirect logged in user to home page.
        return redirect('/');
    }
}
