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
                <form>
                    @csrf
                    <input type="text" placeholder="タグ検索" value="" class="rounded-xl w-1/3 h-10">
                </form>
            </div>
        </div>
    </x-slot>
    <div class="posts w-3/5 m-auto h-screen">
        @foreach($posts as $post)
            <a href="/search/{{ $post->id }}">
                <div class=" post w-full h-60 bg-white border border-black-100 p-2">
                    <div class="flex">
                        <div class="w-1/6">
                            <div class="user_img bg-green-200 w-10 h-10 rounded-full">
                                <a href="/posts"></a>
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
            </a>
        @endforeach
    </div>
<!-- 質問作成ボタン -->
    <div class="create_btn">
        <a href="/posts/create" class="text-6xl font-bold">+</a>
        <p>質問作成はこちら</p>
    </div>
</x-app-layout>