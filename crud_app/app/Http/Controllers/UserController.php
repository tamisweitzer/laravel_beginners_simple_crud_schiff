<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {


    public function register(Request $request) {
        $incomingFields = $request->validate(
            [
                'name' => ['required', 'min:3', 'max:20'],
                'email' => 'required',
                'password' => 'required'
            ]
        );

        // Hash user's password before putting it into the db.
        $incomingFields['password'] = bcrypt($incomingFields['password']);

        // Create an instance of a User.
        User::create($incomingFields);

        return 'hello from controller';
    }
}
