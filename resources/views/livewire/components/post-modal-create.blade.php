<div class="form-control">
    <div class="w-full form-control">
        <label class="label">
            <span class="label-text">Title <span class="text-error">*</span></span>
        </label>
        <input wire:model='title' type="text" placeholder="Input your title" class="w-full input input-bordered @error('title')
            input-error
        @enderror" />
        @error('title')
        <label class="label">
            <span class="text-red-500 label-text-alt">{{ $message }}</span>
        </label>
        @enderror
    </div>
</div>
<div class="w-full form-control" wire:ignore>
    <label class="label">
        <span class="label-text">Topic <span class="text-error">*</span></span>
    </label>
    <select id="topicSelect2" wire:model='topic_id' class="w-full select select-bordered @error('topic_id')
        select-error
    @enderror">
        <option value="" selected></option>
        @foreach ($data_topic as $item)
            <option value="{{ $item->id }}">{{ $item->title }}</option>
        @endforeach
    </select>
    @error('topic_id')
    <label class="label">
        <span class="text-red-500 label-text-alt">{{ $message }}</span>
    </label>
    @enderror

</div>

<div class="w-full form-control" wire:ignore>
    <label class="label">
        <span class="label-text">Tag <span class="text-error">*</span></span>
    </label>
    <select multiple="multiple" id="tagSelect2" wire:model='tag_id' class="w-full select select-bordered @error('tag_id')
        select-error
    @enderror">
        @foreach ($data_tag as $item)
        <option value="{{ $item->id }}">{{ $item->title }}</option>
        @endforeach
    </select>
    @error('tag_id')
    <label class="label">
        <span class="text-red-500 label-text-alt">{{ $message }}</span>
    </label>
    @enderror

</div>

<div class="w-full mt-2">
    <label for="newPostTag" class="text-blue-500 cursor-pointer hover:text-blue-400">Create new Tag</label>
    <input type="checkbox" id="newPostTag" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <label for="newPostTag" class="absolute btn btn-sm btn-circle btn-ghost right-2 top-2">✕</label>

            <div class="form-control">
                <div class="w-full form-control">
                    <label class="label">
                        <span class="label-text">Name <span class="text-error">*</span></span>
                    </label>
                    <input wire:model='tag_name' type="text" placeholder="Input your new tag name" class="w-full input input-bordered @error('tag_name')
                            input-error
                        @enderror" />
                    @error('tag_name')
                    <label class="label">
                        <span class="text-red-500 label-text-alt">{{ $message }}</span>
                    </label>
                    @enderror
                </div>
            </div>
            <div class="modal-action">
                <button wire:click='saveTag' wire:loading.remove class="btn btn-success">Save Tag</button>
                <button wire:target='saveTag' wire:loading class="btn btn-success" disabled>Saving Tag...</button>
            </div>


        </div>
    </div>
</div>
<div class="mt-2 form-control" wire:ignore>
    <label class="label">
        <span class="label-text">Description <span class="text-error">*</span></span>
    </label>
    <textarea rows="4" id="description" wire:model='description' placeholder="Input your description" class="textarea textarea-bordered @error('description')
            textarea-error
        @enderror">
    </textarea>

    @error('description')
        <span class="text-error">{{ $message }}</span>
    @enderror
</div>
