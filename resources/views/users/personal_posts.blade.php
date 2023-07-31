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
    <!-- 個人の質問一覧 -->
    <h2 class="h-8 p-2 border-b-4 border-gray-500">{{ $user->name }}さんの質問一覧</h2>
    <div class="posts w-3/5 mx-auto py-3">
        @foreach($posts as $post)
            <div class="flex">
                <div class="post w-full mt-3 p-2 bg-white border rounded-xl border-gray-500">
                    <div class="profile flex">
                        @if(!$post->user->img_url)
                            <img class="w-14 h-14 rounded-full" src="https://res.cloudinary.com/dz7grtuvv/image/upload/v1688635881/kkrn_icon_user_3_n6tnp5.png">
                        @endif
                        <div class="user_name">
                            {{ $post->user->name}}
                        </div>
                        <div class="date ml-2">
                            {{ $post->created_at}}
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
                        <a href="{{route('show', $post)}}">
                            <div class="body">
                                <p>{{ $post->body }}</p>
                            </div>
                        </a>
                        @if(count($post->postImages)!==0)
                            <div class="image flex flex-wrap">
                                @foreach($post->postImages as $image)
                                    <div class="w-1/3 p-2">
                                        <img src="{{ $image->img_url }}" alt="画像が読み込めません。"/>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="like flex items-end">
                    @if($post->isFavorite())
                        <div>
                            <a href="{{route('unfavorite', $post)}}" class="text-3xl">
                                <img class="w-8" src="https://res.cloudinary.com/dz7grtuvv/image/upload/v1688621419/%E3%83%8F%E3%83%BC%E3%83%88%E3%81%AE%E3%83%9E%E3%83%BC%E3%82%AF_zdgpty.svg">
                            </a>
                        </div>
                    @else
                        <div>
                            <a href="{{route('favorite', $post)}}" class="text-3xl">
                                <img class="w-8" src="https://res.cloudinary.com/dz7grtuvv/image/upload/v1688621389/%E3%83%8F%E3%83%BC%E3%83%88%E3%81%AE%E3%83%9E%E3%83%BC%E3%82%AF2_yg1abi.svg">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            @if($user->id == Auth::id())
                <div class="edit_delete flex">
                    <button class="bg-gray-400 hover:bg-gray-300 text-white rounded px-4 py-2"><a href="/posts/{{ $post->id }}/edit">編集</a></button>
                    <form action="/posts/{{ $post->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-500 text-white rounded px-4 py-2">削除</button>
                    </form>
                </div>
            @endif
        @endforeach
    </div>
</x-app-layout>