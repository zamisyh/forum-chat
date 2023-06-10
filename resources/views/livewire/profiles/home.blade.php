<div class="px-12 lg:px-32 py-14" x-data="{ activeTab: 0 }">
    @livewire('components.navbar')
    <div class="container grid grid-cols-3 gap-10 m-auto mt-5">
        @livewire('components.sidebar.topics')
        <div class="h-full col-span-3 lg:h-60 lg:col-span-2">
            <div class="profile-container">
                <div class="flex flex-wrap items-center gap-5 flex-start">
                    <div class="images-container">
                        <div class="avatar">
                            <div class="rounded-full w-28 h-28">
                                @if (is_null($photos))
                                    <img lazy src="{{ asset('images/users/noprofile.png') }}" />
                                @else
                                    <img lazy src="{{ asset('storage/images/users/' . $photos) }}">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="items-center">
                        <p class="text-xl">{{ $data_profile->name }}</p>
                        <p class="font-thin">{{ $data_profile->profiles->specialist }}</p>
                        <p class="flex items-center gap-2 mt-2 text-sm text-blue-500 cursor-pointer">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                </svg
                              ></span>
                           <span>
                                {{ $data_profile->profiles->country }}
                           </span>
                        </p>
                    </div>
                </div>

                @if (Auth::check() && Auth::user()->id === $data_profile->id)
                    <div class="flex flex-wrap gap-3 flex-start">
                        <label class="mt-4 btn btn-primary btn-sm">
                            <input wire:model='photos' type="file" style="display: none">
                            Edit Photo
                        </label>
                        <label wire:click='edit({{ $data_profile->id }})' for="updateProfileModal" class="mt-4 btn btn-sm btn-primary">Edit Profile</label>
                        <input type="checkbox" id="updateProfileModal" class="modal-toggle" />
                        <div class="modal">
                            <div class="modal-box">
                                <label for="updateProfileModal" class="absolute btn btn-sm btn-circle btn-ghost right-2 top-2">✕</label>
                                <h3 class="text-lg font-bold">Update Profile</h3>
                                <div class="form-control">
                                    <div class="w-full form-control">
                                        <label class="label">
                                            <span class="label-text">Name <span class="text-error">*</span></span>
                                        </label>
                                        <input wire:model='names' type="text" placeholder="Input your names" class="w-full input input-bordered @error('names')
                                            input-error
                                        @enderror" />
                                        @error('names')
                                        <label class="label">
                                            <span class="text-red-500 label-text-alt">{{ $message }}</span>
                                        </label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-control">
                                    <div class="w-full form-control">
                                        <label class="label">
                                            <span class="label-text">Specialist <span class="text-error">*</span></span>
                                        </label>
                                        <input wire:model='specialist' type="text" placeholder="Input your specialist" class="w-full input input-bordered @error('specialist')
                                            input-error
                                        @enderror" />
                                        @error('specialist')
                                        <label class="label">
                                            <span class="text-red-500 label-text-alt">{{ $message }}</span>
                                        </label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-control">
                                    <div class="w-full form-control">
                                        <label class="label">
                                            <span class="label-text">Age <span class="text-error">*</span></span>
                                        </label>
                                        <input wire:model='age' type="number" placeholder="Input your age" class="w-full input input-bordered @error('age')
                                            input-error
                                        @enderror" />
                                        @error('age')
                                        <label class="label">
                                            <span class="text-red-500 label-text-alt">{{ $message }}</span>
                                        </label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-control">
                                    <div class="w-full form-control">
                                        <label class="label">
                                            <span class="label-text">Country <span class="text-error">*</span></span>
                                        </label>
                                        <input wire:model='country' type="text" placeholder="Input your country" class="w-full input input-bordered @error('country')
                                            input-error
                                        @enderror" />
                                        @error('country')
                                        <label class="label">
                                            <span class="text-red-500 label-text-alt">{{ $message }}</span>
                                        </label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-action">
                                    <button wire:click='update' wire:loading.remove class="btn btn-success">Save</button>
                                    <button wire:target='update' wire:loading class="btn btn-success" disabled>Saving...</button>

                                </div>
                            </div>
                        </div>
                    </div>

                @endif

            </div>

            @livewire('components.posts')
        </div>
        @livewire('components.sidebar.tags')
    </div>
</div>
