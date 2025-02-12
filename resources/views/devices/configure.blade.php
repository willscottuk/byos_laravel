<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Device Details: ') }} {{ $device->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-4">
                    <p class="dark:text-gray-100"><strong>Name</strong> {{ $device->name }}</p>
                    <p class="dark:text-gray-100"><strong>Friendly ID</strong> {{ $device->friendly_id }}</p>
                    <p class="dark:text-gray-100"><strong>Mac Address</strong> {{ $device->mac_address }}</p>
                    {{--                    <p><strong>API Key</strong> {{ $device->api_key }}</p>--}}
                    <p class="dark:text-gray-100"><strong>Refresh
                            Interval</strong> {{ $device->default_refresh_interval }}</p>
                    <p class="dark:text-gray-100"><strong>Battery Voltage</strong> {{ $device->last_battery_voltage }}
                    </p>
                    <p class="dark:text-gray-100"><strong>Wifi RSSI Level</strong> {{ $device->last_rssi_level }}</p>
                    <p class="dark:text-gray-100"><strong>Firmware Version</strong> {{ $device->last_firmware_version }}
                    </p>
                </div>
                @if($image)
                    <img src="{{$image}}"/>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
