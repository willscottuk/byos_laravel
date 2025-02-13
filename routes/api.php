<?php

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/display', function (Request $request) {

    $mac_address = $request->header('id');
    $access_token = $request->header('access-token');

    $device = Device::where('mac_address', $mac_address)
        ->where('api_key', $access_token)
        ->first();
    if (! $device) {
        return response()->json([
            'message' => 'MAC Address not registered or invalid access token',
        ], 404);
    }

    $device->update([
        'last_rssi_level' => $request->header('rssi'),
        'last_battery_voltage' => $request->header('battery_voltage'),
        'last_firmware_version' => $request->header('fw-version'),
    ]);

    $image_uuid = $device->current_screen_image;

    $image_path = 'images/generated/'.$image_uuid.'.bmp';
    $filename = basename($image_path);

    return response()->json([
        'status' => '0',
        'image_url' => url('storage/'.$image_path),
        'filename' => $filename,
        'refresh_rate' => 900,
        'reset_firmware' => false,
        'update_firmware' => false,
        'firmware_url' => null,
        'special_function' => 'sleep',
    ]);
});

Route::get('/setup', function (Request $request) {
    $mac_address = $request->header('id');

    if (! $mac_address) {
        return response()->json([
            'message' => 'MAC Address not registered',
        ], 400);
    }

    $device = Device::where('mac_address', $mac_address)->first();

    if (! $device) {
        return response()->json([
            'message' => 'MAC Address not registered',
        ], 404);
    }

    return response()->json([
        'api_key' => $device->api_key,
        'friendly_id' => $device->friendly_id,
        'image_url' => url('storage/images/setup-logo.png'),
        'message' => 'Welcome to TRMNL BYOS',
    ]);
});

Route::post('/log', function (Request $request) {
    $logs = $request->json('log.logs_array', []);

    foreach ($logs as $log) {
        \Log::info('Device Log', $log);
    }

    return response()->json([
        'status' => '0',
    ]);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
