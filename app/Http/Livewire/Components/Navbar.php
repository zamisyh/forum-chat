<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Navbar extends Component
{
    use LivewireAlert;

    public $isRegister;
    public $email, $password, $name, $specialist, $age, $country, $confirm_password;

    public function render()
    {
        return view('livewire.components.navbar')->extends('layouts.app')->section('content');
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
           if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
                $this->alert('success', 'Succesfully login!', [
                    'position' => 'top-end',
                    'timer' => 3000,
                    'toast' => true,
                    'timerProgressBar' => true,
                ]);

                $this->reset();
           }else{
                $this->alert('error', 'Invalid Credential!', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => false,
                    'timerProgressBar' => true,
                ]);
           }

           $this->emit('loginSuccess');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function register()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'specialist' => 'required',
            'country' => 'required',
            'age' => 'required|numeric'
        ]);

        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'slug' => Str::slug($this->name),
                'password' => bcrypt($this->password)
            ]);

            $user->profiles()->create([
                'specialist' => $this->specialist,
                'country' => $this->country,
                'age' => $this->age
            ]);

            $this->alert('success', 'Succesfully create user!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);

            $this->reset();

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function logout()
    {
        Auth::logout();
        $this->alert('success', 'Succesfully logout', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);
        $this->emit('logoutSuccess');

    }

    public function resetIsRegisterToTrue()
    {
        $this->reset();
        $this->isRegister = true;
    }

    public function resetIsRegisterToFalse()
    {
        $this->reset();
        $this->isRegister = false;
    }

}
