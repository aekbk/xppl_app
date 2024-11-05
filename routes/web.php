<?php

use Illuminate\Support\Facades\Route;

Route::get('{any}', function () {
    return view('app'); // laravel app.blade.php
})->where('any','.*');