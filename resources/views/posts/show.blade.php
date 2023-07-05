<x-app-layout>
    <x-slot name="header">
        <div class="header w-full h-40 mb-5 bg-blue-200">
            <div class="search text-center py-10">
                <p class="text-4xl font-bold">Laravel</p>
                <form action="" method="">
                    @csrf
                    <input type="text" placeholder="タグ検索" value="" class="rounded-xl w-1/3 h-10">
                </form>
            </div>
        </div>
    </x-slot>
    <!-- 質問 -->
        <h2 class="w-full h-8 p-2 border-b-4 border-gray-500">質問</h2>
        <div class="post w-3/5 m-auto p-2 bg-white rounded-xl">
            <div class="profile flex">
                <div class="user_img bg-green-200 w-10 h-10 rounded-full">
                </div>
                <div class="user_name">
                    {{ $post->user->name }}
                </div>
                <div class="date ml-2">
                    {{ $post->created_at }}
                </div>
            </div>
            <div class="content">
                <p class="body">{{ $post->body }}</p>
                @if(count($post->post_images)!==0)
                    <div class="image flex">
                        @foreach($post->post_images as $image)
                            <img src="{{ $image->img_url }}" alt="画像が読み込めません。"/>
                        @endforeach
                    </div>
                @endif
                @if(count($post->tags)!==0)
                    <div class="tags flex">
                        @foreach($post->tags as $tag)
                            <p class="text-xs border border-black-100">#{{ $tag->name }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    <!-- コメント -->
        <h2 class="w-full h-8 p-2 border-b-4 border-gray-500">コメント</h2>
            @foreach($post->comments as $comment)
                <div class="comment w-3/5 mx-auto mt-2 p-2 bg-white rounded-xl">
                    <div class="profile flex">
                        <a href="/users/{{ $comment->user->id}}">
                            <div class="user_img bg-green-200 w-10 h-10 rounded-full"></div>
                        </a>
                        <div class="user_name">
                            {{ $comment->user->name }}
                        </div>
                        <div class="date ml-2">
                            {{ $comment->created_at }}
                        </div>
                    </div>
                    <div class="content">
                        <P>{{ $comment->body }}</P>
                    </div>
                </div>
                @if($comment->user->id == Auth::id())
                    <div class="edit_delete flex mb-5">
                        <button class="bg-gray-400"><a href="/comments/{{ $comment->id }}/edit">編集</a></button>
                        <form action="/comments/{{ $comment->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500">削除</button>
                        </form>
                    </div>
                @endif
            @endforeach   
    <!-- コメント送信 -->
        <form action="/comments" method="POST">
            @csrf
            <div class="chat_box w-3/5 mx-auto mt-5">
                <textarea name="comment[body]" placeholder="コメントを送信する" class="w-full rounded-xl"></textarea>
                <p class="body__error" style="color:red">{{ $errors->first('comment.body') }}</p>
                <input type="hidden" name="comment[post_id]" value="{{ $post->id }}">
                <input type="submit" value="送信する">
            </div>
        </form>
</x-app-layout>