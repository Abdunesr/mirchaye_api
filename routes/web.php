<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/registers', function () {
    return view('auth.login');
})->name('password.request');

Route::get('/password/reset', function () {
    return view('auth.passwords.email');
})->name('password.request');
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
// View profile link
Route::get('/dashboard/profile', function () {
    return view('profile'); // Assuming you save the blade file as profile.blade.php
}); // Add any middleware you need