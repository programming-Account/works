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
    <!-- お気に入り質問一覧 -->
    <h2 class="h-8 p-2 border-b-4 border-gray-500">{{ $user->name }}さんのお気に入り</h2>
    <div class="posts w-3/5 mx-auto py-3">
        @foreach($favorites as $favorite)
            <div class="flex">
                <div class="post w-full mt-5 p-2 bg-white border rounded-xl border-black-100">
                    <div class="profile flex">
                        <a href="/users/{{ $favorite->user->id }}">
                            @if(!$favorite->user->img_url)
                                <img class="w-14 h-14 rounded-full" src="https://res.cloudinary.com/dz7grtuvv/image/upload/v1688635881/kkrn_icon_user_3_n6tnp5.png">
                            @endif
                        </a>
                        <div class="user_name">
                            <a href="/users/{{ $favorite->user->id }}">{{ $favorite->user->name}}</a>
                        </div>
                        <div class="date ml-2">
                            {{ $favorite->post->created_at}}
                        </div>
                    </div>
                    @if(count($favorite->post->tags)!==0)
                        <div class="tags flex m-2">
                            @foreach($favorite->post->tags as $tag)
                                <p class="px-2 text-base border border-black-100">#{{ $tag->name }}</p>
                            @endforeach
                        </div>
                    @endif
                    <div class="content">
                        <a href="{{route('show', $favorite->post)}}">
                            <div class="body">
                                <p>{{ $favorite->post->body }}</p>
                            </div>
                        </a>
                        @if(count($favorite->post->postImages)!==0)
                            <div class="image flex flex-wrap">
                                @foreach($favorite->post->postImages as $image)
                                    <div class="w-1/3 p-2">
                                        <img src="{{ $image->img_url }}" alt="画像が読み込めません。"/>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="like flex items-end">
                    @if($favorite->post->isFavorite())
                        <div>
                            <a href="{{route('unfavorite', $favorite->post)}}" class="text-3xl">
                                <img class="w-8" src="https://res.cloudinary.com/dz7grtuvv/image/upload/v1688621419/%E3%83%8F%E3%83%BC%E3%83%88%E3%81%AE%E3%83%9E%E3%83%BC%E3%82%AF_zdgpty.svg">
                            </a>
                        </div>
                    @else
                        <div>
                            <a href="{{route('favorite', $favorite->post)}}" class="text-3xl">
                                <img class="w-8" src="https://res.cloudinary.com/dz7grtuvv/image/upload/v1688621389/%E3%83%8F%E3%83%BC%E3%83%88%E3%81%AE%E3%83%9E%E3%83%BC%E3%82%AF2_yg1abi.svg">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>