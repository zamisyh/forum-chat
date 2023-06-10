<div class="flex flex-wrap justify-between">
    <div>
        <a href="{{ route('client.home') }}" class="text-2xl font-bold">Forum Discussion</a>
    </div>
    <div class="flex gap-5">
        @if (Auth::check())
        <button wire:click='logout' class="btn btn-primary btn-sm">Logout</button>
        <a href="{{ route('client.home.profile', [Auth::user()->id, Str::slug(Auth::user()->slug)]) }}" class="hover:opacity-60">
            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="items-center bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
            </svg>
        </a>

        @else
            <label for="authenticationModal" class="btn btn-sm btn-primary">Login</label>
            <input type="checkbox" id="authenticationModal" class="modal-toggle" />
            <div class="modal">
                <div class="modal-box">
                    <label wire:click='$set("isRegister", false)' for="authenticationModal" class="absolute btn btn-sm btn-circle btn-ghost right-2 top-2">✕</label>
                    <h3 class="text-lg font-bold">{{ $isRegister ? 'Register' : 'Login' }}</h3>
                    <p class="py-2">

                        @if ($isRegister)
                            <div class="form-control">
                                <div class="w-full form-control">
                                    <label class="label">
                                    <span class="label-text">Name</span>
                                    </label>
                                    <input wire:model='name' type="text" placeholder="Input your name" class="w-full input input-bordered @error('name')
                                        input-error
                                    @enderror" />
                                    @error('name')
                                        <label class="label">
                                            <span class="text-red-500 label-text-alt">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-control">
                                <div class="w-full form-control">
                                    <label class="label">
                                    <span class="label-text">Specialist</span>
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
                                    <span class="label-text">Country</span>
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
                            <div class="form-control">
                                <div class="w-full form-control">
                                    <label class="label">
                                    <span class="label-text">Age</span>
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
                        @endif

                        <div class="form-control">
                            <div class="w-full form-control">
                                <label class="label">
                                <span class="label-text">Email</span>
                                </label>
                                <input wire:model='email' type="text" placeholder="Input your email" class="w-full input input-bordered @error('email')
                                    input-error
                                @enderror" />
                                @error('email')
                                    <label class="label">
                                        <span class="text-red-500 label-text-alt">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                        <div class="form-control">
                            <div class="w-full form-control">
                                <label class="label">
                                <span class="label-text">Password</span>
                                </label>
                                <input wire:model='password' type="password" placeholder="Input your password" class="w-full input input-bordered @error('password')
                                    input-error
                                @enderror" />
                                @error('password')
                                    <label class="label">
                                        <span class="text-red-500 label-text-alt">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>

                        @if ($isRegister)
                            <div class="form-control">
                                <div class="w-full form-control">
                                    <label class="label">
                                        <span class="label-text">Confirm Password</span>
                                    </label>
                                    <input wire:model='confirm_password' type="password" placeholder="Input your confirm password" class="w-full input input-bordered @error('confirm_password')
                                        input-error
                                    @enderror" />
                                    @error('confirm_password')
                                        <label class="label">
                                            <span class="text-red-500 label-text-alt">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>
                            </div>
                        @endif


                        <div class="mt-3 form-control">
                            @if ($isRegister)
                                <span wire:click='resetIsRegisterToFalse' class="text-blue-500 cursor-pointer">Already an account ?</span>
                            @else
                                <span wire:click='resetIsRegisterToTrue' class="text-blue-500 cursor-pointer">Don't have any Account ?</span>
                            @endif
                        </div>
                    </p>
                    <div class="modal-action">
                        @if ($isRegister)
                            <button wire:click='register' wire:loading.remove for="authenticationModal" class="btn btn-success">Register</button>
                            <button wire:loading wire:target='register' for="authenticationModal" class="btn btn-success" disabled>Registering....</button>

                        @else
                            <button wire:click='login' wire:loading.remove for="authenticationModal" class="btn btn-success">Login</button>
                            <button wire:loading wire:target='login' for="authenticationModal" class="btn btn-success" disabled>Loading....</button>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
