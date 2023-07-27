<x-app-layout>
    <x-slot name="header">
        <div class="header w-full h-40 mb-5 bg-blue-200">
            <div class="search text-center py-10">
                <p class="text-4xl font-bold">Laravel</p>
                <form action="" method="">
                    @csrf
                    <input type="text" placeholder="タグ検索" value="" class="rounded-xl w-1/3 h-10">
                    <input type="submit" value="検索" class="p-2  bg-blue-400 text-white">
                </form>
            </div>
        </div>
    </x-slot>
    <!-- 質問 -->
    <h2 class="w-full h-8 p-2 border-b-4 border-gray-500">質問</h2>
    <div class="post w-3/5 mx-auto my-3 p-2 bg-white rounded-xl">
        <div class="profile flex">
            <a href="/users/{{ $post->user->id }}">
                @if(!$post->user->img_url)
                    <img class="w-14 h-14 rounded-full" src="https://res.cloudinary.com/dz7grtuvv/image/upload/v1688635881/kkrn_icon_user_3_n6tnp5.png">
                @endif
            </a>
            <div class="user_name">
                <a href="/users/{{ $post->user->id }}">{{ $post->user->name }}</a>
            </div>
            <div class="date ml-2">
                {{ $post->created_at }}
            </div>
        </div>
        @if(count($post->tags)!==0)
            <div class="tags flex m-2">
                @foreach($post->tags as $tag)
                    <p class="px-2 text-base border border-black-100">#{{ $tag->name }}</p>
                @endforeach
            </div>
        @endif
        <div class="content">
            <p class="body">{{ $post->body }}</p>
            @if(count($post->postImages)!==0)
                <div class="image flex flex-wrap">
                    @foreach($post->postImages as $image)
                        <div class="w-1/3 p-2">
                            <img class="zoom" src="{{ $image->img_url }}" alt="画像が読み込めません。"/>
                        </div>
                    @endforeach
                    <div id="zoomback" class="hidden fixed top-0 left-0 w-screen h-screen bg-black bg-opacity-80 justify-center items-center z-10">
                        <img id="zoomimg" class="w-1/2">
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- コメント -->
    <h2 class="w-full h-8 p-2 border-b-4 border-gray-500">コメント</h2>
        @foreach($post->comments as $comment)
            <div class="comment w-3/5 mx-auto mt-2 p-2 bg-white rounded-xl">
                <div class="profile flex">
                    @if(!$comment->user->img_url)
                        <img class="w-14 h-14 rounded-full" src="https://res.cloudinary.com/dz7grtuvv/image/upload/v1688635881/kkrn_icon_user_3_n6tnp5.png">
                    @endif
                    <div class="user_name">
                        <a href="/users/{{ $comment->user->id}}">{{ $comment->user->name }}</a>
                    </div>
                    <div class="date ml-2">
                        {{ $comment->created_at }}
                    </div>
                </div>
                <div class="content">
                    <P>{{ $comment->body }}</P>
                    @if($comment->commentImages)
                        <div class="image flex flex-wrap">
                            @foreach($comment->commentImages as $image)
                                <div class="w-1/3 p-2">
                                    <img class="zoom" src="{{ $image->img_url }}" alt="読み込めませんでした">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            @if($comment->user->id == Auth::id())
                <div class="edit_delete w-3/5 mx-auto flex mb-5">
                    <button class="bg-gray-400 hover:bg-gray-300 text-white rounded px-4 py-2"><a href="/comments/{{ $comment->id }}/edit">編集</a></button>
                    <form action="/comments/{{ $comment->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-500 text-white rounded px-4 py-2">削除</button>
                    </form>
                </div>
            @endif
        @endforeach   
    <!-- コメント送信 -->
    <div class="pb-12">
        <form action="/comments" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="chat_box w-3/5 mx-auto mt-5 bg-white">
                <textarea name="comment[body]" placeholder="コメントを送信する" class="w-full border-b-4"></textarea>
                <p class="body__error" style="color:red">{{ $errors->first('comment.body') }}</p>
                <input type="hidden" name="comment[post_id]" value="{{ $post->id }}">
                <div class="flex justify-between">
                    <input type="file" multiple name="image_file[]" value="{{ old('image_file') }}" class="w-full">
                    <input type="submit" value="送信" >
                </div>
            </div>
        </form>
    </div>
    <script>
        // 要素を取得　
        const zoom = document.querySelectorAll(".zoom");
        const zoomback = document.getElementById("zoomback");
        const zoomimg = document.getElementById("zoomimg");
        
        // 一括でイベントリスナ　
        zoom.forEach(function(value){
            value.addEventListener("click",kakudai)
        });
        
        function kakudai(e) {
            // 拡大領域を表示　
            zoomback.style.display = "flex";
            // 押された画像のリンクを渡す
            zoomimg.setAttribute("src",e.target.getAttribute("src"));
        }
        
        
        // 元に戻すイベントリスナを指定
        zoomback.addEventListener("click",modosu);
        
        // 拡大領域を無きものに　
        function modosu() {
            zoomback.style.display = "none";
        }
    </script>
</x-app-layout>