<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\CommentImage;
use Illuminate\Support\Facades\Auth;
use Cloudinary;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Comment $comment)
    {
        //コメント
        $input = $request['comment'];
        $comment->fill($input);
        $comment->user_id = Auth::id();
        $comment->save();
        
        //画像
        if($request->file('image_file')){
            foreach($request->file('image_file') as $image){
                $image_url = Cloudinary::upload($image->getRealPath())->getSecurePath();
                $comment_image = new CommentImage();
                $comment_image->img_url = $image_url;
                $comment_image->comment_id = $comment->id;
                $comment_image->save();
            }
        };
        
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
        
        if($request->file('image_file')){
            $comment->commentImages()->delete();
            foreach($request->file('image_file') as $image){
                $image_url = Cloudinary::upload($image->getRealPath())->getSecurePath();
                $comment_image = new CommentImage();
                $comment_image->img_url = $image_url;
                $comment_image->comment_id = $comment->id;
                $comment_image->save();
            }
        };

        return redirect('/search/'. $comment->post->id);
    }
    
    public function delete(Comment $comment)
    {
        $comment->delete();
        return redirect('/search/'. $comment->post->id);
    }
}
