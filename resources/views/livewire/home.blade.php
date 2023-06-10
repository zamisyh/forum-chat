<div class="px-12 lg:px-32 py-14">
    @livewire('components.navbar')
    <div class="container grid grid-cols-3 gap-10 m-auto mt-5">
        @livewire('components.sidebar.topics')
        <div class="h-full col-span-3 lg:h-60 lg:col-span-2">
            @livewire('components.posts')
        </div>
        @livewire('components.sidebar.tags')
    </div>
</div>
