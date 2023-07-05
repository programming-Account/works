<x-app-layout>
    <x-slot name="header">
        <div class="header w-full h-40 bg-blue-200">
            <div class="search text-center py-10">
                <p class="text-4xl font-bold">Laravel</p>
                <form action="/search" method="GET">
                    @csrf
                    <input type="text" name="keyword" value="@if(isset($keyword)) {{ $keyword }} @endif" placeholder="タグ検索" class="rounded-xl w-1/3 h-10">
                    @if(isset($category_id))
                        <input type='hidden' name="category_id" value="{{$category_id}}">
                    @endif
                    @if(isset($period_id))
                        <input type='hidden' name="period_id" value="{{$period_id}}">
                    @endif
                    <input type="submit" value="検索" class="p-2  bg-blue-400 text-white">
                </form>
            </div>
        </div>
    </x-slot>
    <div class="posts w-3/5 mx-auto my-5">
        <!-- データ絞り込み -->
        <form method="GET" id="submit_form">
            @csrf
            <select name="period_id" id="submit_period">
                <option>選択してください</option>
                @foreach($periods as $period)
                    <option value="{{ $period->id }}" @if($period_id == $period->id) selected @endif>{{ $period->name }}</option>
                @endforeach
            </select>
            <select name="category_id" id="submit_category">
                <option>選択してください</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if($category_id == $category->id) selected @endif>{{ $category->name }}</option>
                @endforeach
            </select>
        </form>
        <!-- 投稿一覧表示 -->
        @foreach($posts as $post)
            <div class="flex">
                <div class="post w-full mt-2 bg-white border rounded-xl border-black-100 p-3">
                    <div class="profile flex">
                        <a href="/users/{{ $post->user->id }}">
                            <div class="user_img bg-green-200 w-10 h-10 rounded-full"></div>
                        </a>
                        <div class="user_name">
                            <a href="/users/{{ $post->user->id }}">{{ $post->user->name }}</a>
                        </div>
                        <div class="date ml-2">
                            {{ $post->created_at }}
                        </div>
                    </div>
                    <div class="content">
                        <a href="/search/{{ $post->id }}">
                            <div class="body">
                                {{ $post->body }}
                            </div>
                        </a>
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
        @endforeach
    </div>
    <!-- ページネーション -->
    <div class='w-3/5 mx-auto text-center'>
        {{ $posts->links() }}
    </div>
    <!-- 質問作成ボタン -->
    <div class="text-center fixed right-1 bottom-1">
        <a href="/posts/create" class="text-6xl font-bold">+</a>
        <p>質問作成はこちら</p>
    </div>
    <script>
        //セレクトボックス変更時にformタグを自動送信
        const period = document.getElementById('submit_period');
        const category = document.getElementById('submit_category');
        const form = document.getElementById('submit_form');
        period.addEventListener("change", function periodChange(){
            form.submit();
        });
        category.addEventListener('change', function categoryChange(){
            form.submit();
        });
    </script>
</x-app-layout>