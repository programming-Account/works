<x-app-layout>
    <x-slot name="header">
        <div class="header w-full h-40 bg-blue-200">
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
                <form>
                    @csrf
                    <input type="text" placeholder="タグ検索" value="" class="rounded-xl w-1/3 h-10">
                </form>
            </div>
        </div>
    </x-slot>
    <!-- 質問 -->
        <h2 class="w-full h-8 p-2 border-b-4 border-gray-500">質問</h2>
        <div class="post w-3/5 m-auto h-60 p-2 bg-white rounded-xl">
            <div class="flex">
                <div class="w-1/6">
                    <div class="user_img bg-green-200 w-10 h-10 rounded-full">
                        
                    </div>
                </div>
                <div class="flex justify-between w-5/6">
                    <div class="user_name">
                        {{ $post->user->name }}
                    </div>
                    <div class="date">
                        {{ $post->created_at }}
                    </div>
                </div>
            </div>
            <p class="body">{{ $post->body }}</p>
        </div>
    <!-- コメント -->
        <h2 class="w-full h-8 p-2 border-b-4 border-gray-500">コメント</h2>
        <div class="comments">
            <div class="comments w-3/5 mx-auto mb-5">
                @foreach($post->comments as $comment)
                    <div class="comment w-full h-60 p-2 bg-white rounded-xl">
                        <div class="flex">
                            <div class="user_img bg-green-200 w-10 h-10 rounded-full">
                                
                            </div>
                            <div class="user_name">
                                {{ $comment->user->name }}
                            </div>
                            <div class="date">
                                {{ $comment->created_at }}
                            </div>
                        </div>
                        <P>{{ $comment->body }}</P>
                    </div>
                @endforeach   
            </div>
        </div>
    <!-- コメント送信 -->
        <form action="/comments" method="POST">
            @csrf
            <div class="chat_box w-3/5 mx-auto mt-5">
                <textarea name="comment[body]" placeholder="コメントを送信する" class="w-full rounded-xl"></textarea>
                <input type="hidden" name="comment[post_id]" value="{{ $post->id }}">
                <input type="submit" value="送信する">
            </div>
        </form>
</x-app-layout>