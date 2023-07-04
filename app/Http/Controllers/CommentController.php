<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Comment $comment)
    {
        $input = $request['comment'];
        $comment->fill($input);
        $comment->user_id = Auth::id();
        $comment->save();
        return redirect('/search/'. $comment->post->id);
    }
    
    public function edit(Comment $comment)
    {
        return view('comments/edit')->with(['comment' => $comment]); 
    }
    
    public function update(CommentRequest $request, Comment $comment)
    {
        $input = $request['comment'];
        $comment->fill($input)->save();
        return redirect('/search/'. $comment->post->id);
    }
    
    public function delete(Comment $comment)
    {
        $comment->delete();
        return redirect('/search/'. $comment->post->id);
    }
}
