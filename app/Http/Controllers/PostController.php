<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Period;
use App\Models\Tag;
use App\Models\PostImage;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Cloudinary;

class PostController extends Controller
{
    public function index(Request $request, Post $post) //ここにPost $postを記述しなくてもいい理由
    {
        $category_id = null;//if文の外でこの記述がないとエラーが起きる(24行目のif文がヒットしない場合)
        $period_id = null;//if文の外でこの記述がないとエラーが起きる(24行目のif文がヒットしない場合)
        
        //$postインスタンスをカテゴリー、期間で絞り込み
        if($request->period_id){
            $period_id = $request->period_id;
            $post = $post->where('period_id', $period_id);
        };
        if($request->category_id){
            $category_id = $request->category_id;
            $post = $post->where('category_id', $category_id);
        };
        
        //$postインスタンスをタグ検索で絞り込み
        $tag_keyword = $request->input('keyword');//if文の外でこの記述がないとエラーが起きる(33行目のif文がヒットしない場合)
        preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $tag_keyword, $matches);
        $query = Post::query();
        if($matches[1]){
            $post = $post->whereHas('tags', function($query) use ($matches){
                foreach($matches[1] as $keyword ){
                    $query->where('name', 'LIKE', "%{$keyword}%");
                }
            });
        }elseif($tag_keyword && !$matches[1]){
            $post = $post->whereHas('tags', function($query) use ($tag_keyword){
                $query->where('name', 'LIKE', "%{$tag_keyword}%");
            });
        }
        
        //selectボックス用のデータ
        $category = new Category();
        $period = new Period();
        
        return view('posts/search')->with([
            'posts' => $post->with('user')->orderBy('updated_at', 'DESC')->paginate(5), 
            'keyword' => $tag_keyword,
            'category_id' => $category_id,//データ絞り込み用のデータ
            'period_id' => $period_id,//データ絞り込み用のデータ
            'categories' => $category->get(),//selectボックス用のデータ
            'periods' => $period->get(),//selectボックス用のデータ
            ]);
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
            array_push($tags_id, $tag['id']);//$tag['id']は何？->$recordの時にidも取得している。$tagsにidも入ってる
        };
        
        // postの保存
        
        $input = $request['post'];
        $post->fill($input);
        $post->user_id = Auth::id();
        $post->save();
        
        $post->tags()->attach($tags_id); //post_idはいつ・どこで登録されているのか？
        
        //cloudinaryへ画像を送信し、画像のURLを$image_urlに代入している
        if($request->file('image_file')){
            foreach($request->file('image_file') as $image){
                $image_url = Cloudinary::upload($image->getRealPath())->getSecurePath();
                $post_image = new PostImage();
                $post_image->img_url = $image_url;
                $post_image->post_id = $post->id;
                $post_image->save();
            }
        };
        
        return redirect('/search/'. $post->id);
    }
    
    public function edit(Post $post, Period $period, Category $category)
    {
        return view('posts/edit')->with(['post' => $post, 'periods' => $period->get(), 'categories' => $category->get()]);
    }
    
    public function update(PostRequest $request, Post $post)
    {
        preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $request->tag_name, $matches);
        
        $tags = [];
        foreach($matches[1] as $tag){
            $record = Tag::firstOrCreate(['name' => $tag]);
            array_push($tags, $record);
        };
        
        $tags_id = [];
        foreach($tags as $tag){
            array_push($tags_id, $tag['id']);
        };
        
        $input_post = $request['post'];
        $post->update($input_post);
        $post->tags()->detach();
        $post->tags()->attach($tags_id);
        
        //画像の更新
        if($request->file('image_file')){
            $post->postImages()->delete();
            foreach($request->file('image_file') as $image){
                $image_url = Cloudinary::upload($image->getRealPath())->getSecurePath();
                $post_image = new PostImage();
                $post_image->img_url = $image_url;
                $post_image->post_id = $post->id;
                $post_image->save();
            }
        };
        
        return redirect('/users/'. $post->user->id);
    }
    
    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/users/'. $post->user->id);
    }
}
