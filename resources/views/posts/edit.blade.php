<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <main class="wrapper w-4/5 mx-auto">
            <h1 class="text-7xl text-center pt-5">Laravel</h1>
            <div class="bg-blue-50 border border-black-100">
                <h2 class="pt-5 text-center text-xl">投稿の編集</h2>
                <form action="/posts/{{ $post->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="create_post w-3/5 mx-auto py-5">
                        <div class="row_1 flex">
                            <div class="period">
                                <p>laravel学習期間</p>
                                <select name="post[period_id]">
                                    @foreach($periods as $period)
                                        <option value="{{ $period->id }}">{{ $period->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="category">
                                <p>カテゴリー</p>
                                <select name="post[category_id]">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="tag">
                            <p>タグ機能</p>
                            <input type="text" name="tag_name" value="" class="w-full"> <!--登録したタグネームをoldなどで表示-->
                        </div>
                        <div class="img_url">
                            <p>画像URL</p>
                            <input type="file" multiple name="image_file" class="w-full"></input>
                        </div>
                        <div class="body">
                            <p>内容</p>
                            <textarea name="post[body]" class="w-full h-60">@if(count($errors)!==0){{ old('post.body') }}@else{{ $post->body }}@endif</textarea>
                            <p class="body__error" style="color:red">{{ $errors->first('post.body') }}</p>
                        </div>
                    </div>
                    <div class="pb-5 text-center">
                        <input type="submit" value="編集する" class="p-2 bg-blue-400 text-white text-center">
                    </div>
                </form>
            </div>
        </main>
        
    </body>
</html>