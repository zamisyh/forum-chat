<?php

namespace App\Http\Livewire\Profiles;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\Profile;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
    use WithFileUploads, LivewireAlert;

    protected $listenets = [
        'getData'
    ];

    public $data_profile, $profileId, $profileName;
    public $photos, $names, $specialist, $age, $country;
    public $user_id;

    public function mount($id, $name)
    {
        $this->profileId = $id;
        $this->profileName = $name;
        $this->getData();
    }

    public function render()
    {
        return view('livewire.profiles.home')->extends('layouts.app')->section('content');
    }

    public function updatedPhotos()
    {
        $newPhotos = null;

        try {
            $this->validate([
                'photos' => 'file|image'
            ]);

            $newPhotos = 'photos' . '-' . time(). '.' . $this->photos->getClientOriginalExtension();


            $profile = Profile::where('user_id', Auth::user()->id)->first();
            if (is_null($profile->photos)) {
                $this->photos->storeAs('public/images/users', $newPhotos);
            }else{
                File::delete(public_path('storage/images/users/' . $profile->photos));
                $this->photos->storeAs('public/images/users', $newPhotos);
            }

            $profile->update([
                'photos' => $newPhotos
            ]);

            $this->alert('success', 'Succesfully update photo', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);

            $this->emit('getData');
            $this->photos = $newPhotos;




        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->alert('error', $e->errors()['photos'][0], [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'timerProgressBar' => true,
            ]);
        }


    }

    public function getData()
    {
        $this->data_profile = User::with('profiles')->where([
            ['id', '=', $this->profileId],
            ['slug', '=', $this->profileName]
        ])->first();


        $this->photos = $this->data_profile->profiles->photos;

    }

    public function edit($id)
    {
        $user = User::where('id', $id)->with('profiles')->first();
        $this->names = $user->name;
        $this->specialist = $user->profiles->specialist;
        $this->age = $user->profiles->age;
        $this->country = $user->profiles->country;
        $this->user_id = $id;
    }

    public function update()
    {
        try {
            $this->validate([
                'names' => 'required',
                'specialist' => 'required',
                'age' => 'required|numeric',
                'country' => 'required'
            ]);

            $user = User::where('id', $this->user_id)->first();
            $user->name = $this->names;
            $user->slug = Str::slug($this->names);
            $user->profiles()->update([
                'specialist' => $this->specialist,
                'age' => $this->age,
                'country' => $this->country
            ]);

            $user->update();

            $this->alert('success', 'Succesfully update profile', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);

            sleep(3);


            return redirect(route('client.home.profile', [$this->user_id, $user->slug]));




        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
