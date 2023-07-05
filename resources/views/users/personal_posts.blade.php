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
    <!-- 個人の質問一覧 -->
    <h2 class="h-8 p-2 border-b-4 border-gray-500">{{ $user->name }}さんの質問一覧</h2>
    <div class="posts w-3/5 m-auto">
        @foreach($posts as $post)
            <div class="flex">
                <div class="post w-full mt-5 bg-white border rounded-xl border-black-100">
                    <div class="profile flex">
                        <a href="/users/{{ $post->user->id }}">
                            <div class="user_img w-10 h-10 bg-green-200 rounded-full"></div>
                        </a>
                        <div class="user_name">
                            <a href="/users/{{ $post->user->id }}">{{ $post->user->name}}</a>
                        </div>
                        <div class="date ml-2">
                            {{ $post->created_at}}
                        </div>
                    </div>
                    <div class="content">
                        <div class="body">
                            <p>{{ $post->body }}</p>
                        </div>
                        @if(count($post->post_images)!==0)
                            <div class="image">
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
                <div class="like flex items-end">
                    @if($post->isFavorite())
                        <div>
                            <a href="{{route('unfavorite', $post)}}" class="text-3xl text-red-500">♡</a>
                        </div>
                    @else
                        <div>
                            <a href="{{route('favorite', $post)}}" class="text-3xl text-gray-400">♡</a>
                        </div>
                    @endif
                </div>
            </div>
            @if($user->id == Auth::id())
                <div class="edit_delete flex">
                    <button class="bg-gray-400"><a href="/posts/{{ $post->id }}/edit">編集</a></button>
                    <form action="/posts/{{ $post->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500">削除</button>
                    </form>
                </div>
            @endif
        @endforeach
    </div>
</x-app-layout>