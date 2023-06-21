<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Period;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Post $post)
    {
        return view('posts/search')->with(['posts' => $post->getPaginateByLimit(5)]);
    }
    
    public function show(Post $post)
    {
        return view('posts/show')->with(['post' => $post]);
    }
    
    public function create(Period $period, Category $category)
    {
        return view('posts/create')->with(['periods' => $period->get(), 'categories' => $category->get()]);  //periodsとcategoriesテーブルから値を取得する必要がある。
    }
    
    public function store(PostRequest $request, Post $post)
    {
        // #(ハッシュタグ)で始まる単語を取得。結果は、$matchesに多次元配列で代入される。
        preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $request->tag_name, $matches);
        
        // $match[0]に#(ハッシュタグ)あり、$match[1]に#(ハッシュタグ)なしの結果が入ってくるので、$match[1]で#(ハッシュタグ)なしの結果のみを使う。
        $tags = [];
        foreach($matches[1] as $tag){
            $record = Tag::firstOrCreate(['name' => $tag]);// firstOrCreateメソッドで、tags_tableのnameカラムに該当のない$tagは新規登録される。
            array_push($tags, $record);// $recordを配列に追加(=$tags)
        };
        
        $tags_id = [];
        foreach($tags as $tag){
            array_push($tags_id, $tag['id']);
        };
        
        // dd($tags_id);
        
        $input = $request['post'];
        $post->fill($input);
        $post->user_id = Auth::id();
        $post->save();
        
        $post->tags()->attach($tags_id);
        
        return redirect('/search/'. $post->id);
        
    }
}
