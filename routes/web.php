<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Home;
use App\Http\Livewire\Topic\Home as TopicHome;
use App\Http\Livewire\Tags\Home as TagHome;
use App\Http\Livewire\Questions\Home as QuestionHome;
use App\Http\Livewire\Profiles\Home as ProfileHome;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('client.')->group(function() {
    Route::get('/', Home::class)->name('home');
    Route::get('/topics/{slug}', TopicHome::class)->name('home.topic');
    Route::get('/tags/{slug}', TagHome::class)->name('home.tag');
    Route::get('/questions/{id}/{slug}', QuestionHome::class)->name('home.question');
    Route::get('/users/{id}/{name}', ProfileHome::class)->name('home.profile');
});
