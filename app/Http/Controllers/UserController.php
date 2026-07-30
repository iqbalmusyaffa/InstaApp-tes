<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(\App\Models\User $user)
    {
        $user->load(['posts' => function($query) {
            $query->latest();
        }]);

        return view('users.show', compact('user'));
    }
}
