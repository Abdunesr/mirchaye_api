<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.login');
})->name('register');

Route::get('/registers', function () {
    return view('auth.login');
})->name('password.request');