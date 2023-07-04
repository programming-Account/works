<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(User $user)
    {
        return view('/users/personal_posts')->with(['posts' => $user->getByUser(), 'user' => $user]);
    }
}
