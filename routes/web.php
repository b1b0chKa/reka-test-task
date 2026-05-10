<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('/login', 'auth.login');
Route::view('/register', 'auth.register');

Route::view('/tags', 'tags.index');
Route::view('/tasks', 'tasks.index');
