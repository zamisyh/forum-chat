<div class="px-12 lg:px-32 py-14" x-data="{ activeTab: 0 }">
    @livewire('components.navbar')
    <div class="container grid grid-cols-3 gap-10 m-auto mt-5">
        @livewire('components.sidebar.topics')
        <div class="h-full col-span-3 lg:h-60 lg:col-span-2">
            <div class="pb-0 lg:pb-14">
                <a href="{{ route('client.home.question', [$data_question->id, $data_question->slug]) }}" class="mb-4 text-2xl text-blue-500">{{ $data_question->title }}</a>
                <div class="flex flex-wrap gap-10 mt-2 mb-3">
                    <h4>Asked : <b>{{ $data_question->created_at->diffForHumans() }}</b></h4>
                    <h4>Views : <b>{{ $data_question->visit_count_total }}</b></h4>
                </div>

                <div class="mt-5 mb-4 post-content">
                    {!! $data_question->description !!}

                    <div class="mt-5 mb-5 tag-topic">
                        <p class="font-bold">Topic : <a href="{{ route('client.home.topic', $data_question->topic->slug) }}" class="badge badge-info">{{ $data_question->topic->title }}</a></p>
                        <p class="mt-3 font-bold">Tags : @foreach ($data_question->tags as $tag)
                            <a href="{{ route('client.home.tag', $tag->slug) }}" class="badge badge-success">{{ $tag->title }}</a>
                        @endforeach </p>
                        <div class="flex flex-wrap gap-3 mt-3">
                            <span class="font-bold">Votes : </span>
                            @if (!$likeAction)
                                <svg wire:click='voteAction({{$data_question->id}})' role="button" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            @else
                                <svg role='button' xmlns="http://www.w3.org/2000/svg" wire:click='voteAction({{ $data_question->id }})' class="w-6 h-6 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                </svg>
                            @endif

                            {{ $totalVote }}
                        </div>
                    </div>



                    <div class="mt-5 mb-3">
                        <livewire:comments :model="$data_question"/>
                    </div>
                </div>
            </div>
        </div>




        @livewire('components.sidebar.tags')
    </div>
</div>
