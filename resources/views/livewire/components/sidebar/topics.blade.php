<div class="order-1 col-span-3 p-5 bg-white shadow-xl h-fit lg:order-none rounded-xl lg:col-span-1 tile">
    <h1 class="text-xl font-bold">Topics</h1>
    <div class="mt-3 topics">
        <ul class="">
            @foreach ($data_topic as $item)
                <li class="mt-2">
                    <a href="{{ route('client.home.topic', $item->slug) }}" class="text-blue-500">{{ $item->title }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
