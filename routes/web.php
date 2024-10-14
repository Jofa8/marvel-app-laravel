<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarvelCharacterController;

Route::get('/', [MarvelCharacterController::class, 'index'])->name('marvel.index');