<x-app-layout>
    <div class="mb-5 text-center">
        <h1 class="mb-10 text-5xl">Laravel</h1>
        <p class="text-3xl">わからないをなくそう！</p>
        <p class="text-3xl">Laravelについてわからないことを質問しよう</p>
    </div>
    <div class="text-center">
        <form action="/search" method="GET">
            @csrf
            <p class="text-2xl">Laravelをはじめてどのくらい？</p>
            <select name="period_id">
                <option>選択してください</option>
                @foreach($periods as $period)
                    <option value="{{ $period->id }}">{{ $period->name }}</option>
                @endforeach
            </select>
            <div class="my-10 flex justify-around text-center">
            @foreach($categories as $category)
                <div>
                    <input type="radio" id="{{ $category->id }}" name="category_id" value="{{ $category->id }}" class="hidden peer"><label for="{{ $category->id }}" class="p-2 border border-black rounded-xl text-2xl hover:bg-blue-600 hover:text-white peer-checked:bg-red-600 peer-checked:text-white">{{ $category->name }}</label>
                </div>
            @endforeach
            </div>
            <input type="submit" value="検索" class="px-2 py-1 bg-blue-400 border border-black rounded hover:bg-blue-600 hover:text-white">
        </form>
    </div>
</x-app-layout>