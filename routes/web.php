<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/devices', function () {
        return view('devices');
    })->name('devices');

    Route::get('/devices/{device}/configure', function (App\Models\Device $device) {
        $current_image_uuid = auth()->user()->devices()->find($device->id)->current_screen_image;
        $current_image_path = 'images/generated/'.$current_image_uuid.'.png';

        return view('devices.configure', compact('device'), [
            'image' => ($current_image_uuid) ? url($current_image_path) : null,
        ]);
    })->name('devices.configure');
});

require __DIR__.'/auth.php';
