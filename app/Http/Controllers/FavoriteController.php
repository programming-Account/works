<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function favorite(Request $request, Post $post)
    {
        $favorite = new Favorite();
        $favorite->post_id = $post->id;
        $favorite->user_id = Auth::id();
        $favorite->save();
        return back();
    }
    
    public function unfavorite(Request $request, Post $post)
    {
        $user_id = Auth::id();
        $favorite = Favorite::where(['post_id'=>$post->id, 'user_id'=>$user_id])->first();
        $favorite->delete();
        return back();
    }
}
