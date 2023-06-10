<div class="col-span-3 p-5 bg-white shadow-xl rounded-xl lg:col-span-1 tile">
    <h1 class="text-xl font-bold">Tags</h1>
    <div class="flex flex-wrap gap-2 mt-3 topics">
        @foreach ($data_tag as $item)
            <a href="{{ route('client.home.tag', $item->slug) }}" class="badge badge-success">{{ $item->title }}</a>
        @endforeach
    </div>
</div>
