<div x-data="{ activeTab: 0 }">

    @if ($currentRoute === 'client.home')
        @section('css')
        <link rel="stylesheet" href="{{ asset('lib/select2.min.css') }}">
        @endsection

        @section('js')
        <script src="{{ asset('lib/ckeditor.js') }}"></script>
        {{-- <script src="{{ asset('lib/autoComplete.min.js') }}"></script> --}}
        <script src="{{ asset('lib/jquery-3.7.0.min.js') }}"></script>
        <script src="{{ asset('lib/select2.min.js') }}"></script>


        <script>
            $(document).ready(function() {
                $('#topicSelect2').select2({
                    placeholder: "Select a topic",
                    allowClear: true
                });

                $('#tagSelect2').select2()

                $('#topicSelect2').on('change', function() {
                    @this.topic_id = $(this).val();
                })

                $('#tagSelect2').on('change', function() {
                    @this.tag_id = $(this).val();
                })

            });



            ClassicEditor
                .create(document.querySelector('#description'))
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('description', editor.getData());
                    })
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
        @endsection

        <div class="flex flex-wrap justify-between">
            <h1 class="text-xl font-bold">All Questions</h1>
            <label for="newPostModal" class="btn btn-sm">Ask Question</label>
            <input type="checkbox" id="newPostModal" class="modal-toggle" />
            <div class="modal">
                <div class="modal-box">
                    <label for="newPostModal" class="absolute btn btn-sm btn-circle btn-ghost right-2 top-2">✕</label>
                    @if (Auth::check())
                    <h3 class="text-lg font-bold">Create Question</h3>
                    @include('livewire.components.post-modal-create')
                    <div class="modal-action">
                        <button wire:click='saveQuestion' wire:loading.remove class="btn btn-success">Save</button>
                        <button wire:target='saveQuestion' wire:loading class="btn btn-success" disabled>Saving...</button>

                    </div>
                    @else
                    <h3>Failed create question, <b class="text-red-500">Authentication Required!</b></h3>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="flex flex-wrap gap-2">
        @if ($currentRoute === 'client.home.topic')
            <h1 class="text-lg">Topic : <b>{{ $title }}</b></h1>
        @elseif($currentRoute === 'client.home.tag')
            <h1 class="text-lg">Tag : <b>{{ $title }}</b></h1>
        @endif
    </div>

    <div class="flex flex-wrap justify-between mt-8">
        @if ($currentRoute === 'client.home')
            <h1>{{ number_format($countPost) }} Questions</h1>
        @else
            <h1>{{ number_format($data['count_question']) }} Questions</h1>

        @endif
        <div class="flex items-center gap-5 mt-3 lg:mt-0">
            <div class="tabs tabs-boxed">
                <button wire:click='sortTabCheck("desc")' @click="activeTab = 0" class="tab"
                    :class="{'tab-active': activeTab === 0}">Newest</button>
                <button wire:click='sortTabCheck("asc")' @click="activeTab = 1" class="tab"
                    :class="{'tab-active': activeTab === 1}">Olders</button>
                <button wire:click='sortTabCheck("views")' @click="activeTab = 2" class="tab"
                    :class="{'tab-active': activeTab === 2}">Views</button>
                <button wire:click='sortTabCheck("votes")' @click="activeTab = 3" class="tab"
                    :class="{'tab-active': activeTab === 3}">Votes</button>
            </div>
            <h1>
                <select wire:model='rows'>
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                </select>
            </h1>
        </div>
    </div>
    <hr class="h-px my-8 bg-gray-500 border-0 dark:bg-gray-700">
    <div class="pb-0 lg:pb-14">
        @forelse ($data['data_question'] as $key => $item)
        <div class="post-content">
            <div class="mb-3">
                <span class="text-sm">
                    <div class="flex items-center gap-3">
                        <div class="avatar">
                            <div class="w-8 h-8 rounded-full">
                                @if (is_null($item->user->profiles->photos))
                                    <img lazy src="{{ asset('images/users/noprofile.png') }}" />
                                @else
                                    <img lazy src="{{ asset('storage/images/users/' . $item->user->profiles->photos) }}">
                                @endif
                            </div>
                        </div>
                        <a class="text-blue-600" href="{{ route('client.home.profile', [$item->user->id, $item->user->slug]) }}">{{ $item->user->name }}</a>

                    </div>
                </span>
            </div>
            <div class="flex justify-between">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <div>
                        <a href="{{ route('client.home.question', [$item->id, $item->slug]) }}"
                            class="text-xl text-blue-500 hover:text-blue-400">{{ $item->title }}</a>
                    </div>
                    <div>
                        <a href="{{ route('client.home.topic', $item->topic->slug) }}" class="badge badge-info">{{
                            $item->topic->title }}</a>
                    </div>
                </div>
                @auth
                @if (Auth::user()->id === $item->user_id)
                <div>
                    <svg wire:click='delete({{ $item->id }})' role="button" class="text-error"
                        style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                    </svg>
                </div>
                @endif
                @endauth
            </div>
            <span class="mt-2 text-sm text-gray-400">
                {!! substr($item->description, 0, 200) !!} ...
            </span>
            <div class="flex flex-wrap justify-start gap-5 mt-4 badges-container">
                @foreach ($item->tags as $tag)
                    <a href="{{ route('client.home.tag', $tag->slug) }}" class="badge badge-success">{{ $tag->title }}</a>
                @endforeach
            </div>
        </div>
        <hr class="h-px my-8 bg-gray-500 border-0 dark:bg-gray-700">
        @empty
            <div class="flex justify-center">No Data Found</div>
        @endforelse

        {{ $data['data_question']->links() }}
    </div>
</div>
