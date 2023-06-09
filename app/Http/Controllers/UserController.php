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
    
    public function showFavorite(User $user)
    {
        return view('/users/favorite')->with(['favorites' => $user->getFavoritesByUser(), 'user' => $user]);
    }
}
