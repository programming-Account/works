<x-app-layout>
    <x-slot name="header">
        <div class="header w-full h-40 mb-5 bg-blue-200">
            <div class="navs">
                <ul class="flex justify-end">
                    <li><a href="">プロフィール</a></li>
                    <li><a href="">質問一覧</a></li>
                    <li><a href="">お気に入り</a></li>
                    <li><a href="">ログイン</a></li>
                    <li><a href="">新規登録</a></li>
                </ul>
            </div>
            <div class="search text-center py-10">
                <p class="text-4xl font-bold">Laravel</p>
            </div>
        </div>
    </x-slot>
    <!-- 質問 -->
    <div class="wrapper w-4/5 m-auto py-5 bg-blue-50 border border-black-100">
        <h2 class="w-3/5 m-auto h-8 p-2 border-b-4 border-gray-500 text-center">質問</h2>
        <div class="post w-3/5 m-auto p-2 bg-white rounded-xl">
            <div class="flex">
                <div class="user_img bg-green-200 w-10 h-10 rounded-full">
                </div>
                <div class="user_name">
                    {{ $comment->post->user->name }}
                </div>
                <div class="date ml-2">
                    {{ $comment->post->created_at }}
                </div>
            </div>
            <p class="body">{{ $comment->post->body }}</p>
            @if(count($comment->post->post_images)!==0)
                <div class="image flex">
                    @foreach($comment->post->post_images as $image)
                        <img src="{{ $image->img_url }}" alt="画像が読み込めません。"/>
                    @endforeach
                </div>
            @endif
            @if(count($comment->post->tags)!==0)
                <div class="tags flex">
                    @foreach($comment->post->tags as $tag)
                        <p class="text-xs border border-black-100">#{{ $tag->name }}</p>
                    @endforeach
                </div>
            @endif
        </div>
        <!-- コメント編集 -->
        <h1 class="w-3/5 m-auto h-8 p-2 border-b-4 border-gray-500 text-center">コメントの編集</h1>
        <div class="comment w-3/5 m-auto mb-5">
            <form action="/comments/{{ $comment->id }}" method="POST">
                @csrf
                @method('PUT')
                <textarea name="comment[body]" class="w-full bg-white rounded-xl">@if(count($errors)!==0){{ old('comment.body') }}@else{{ $comment->body }}@endif</textarea>
                <p class="body__error" style="color:red">{{ $errors->first('comment.body') }}</p>
                <div class="pt-5 text-center">
                    <input type="submit" value="編集する" class="p-2 bg-blue-400 text-white text-center">
                </div>
            </form>
        </div>
    </div>
</x-app-layout>