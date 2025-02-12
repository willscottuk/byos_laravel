<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold dark:text-gray-100">Devices</h2>
                <x-primary-button
                    wire:click="toggleDeviceForm">{{ $showDeviceForm ? 'Cancel' : 'New Device' }}</x-primary-button>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('message') }}
                </div>
            @endif

            @if ($showDeviceForm)
                <div class="bg-gray-50 dark:bg-gray-800 p-6 mb-6 rounded-lg">
                    <form wire:submit="createDevice">
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Name')"/>
                            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name"
                                          autofocus/>
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <x-input-label for="mac_address" :value="__('Mac Adress')"/>
                            <x-text-input wire:model="mac_address" id="mac_address" class="block mt-1 w-full"
                                          type="text" name="mac_address" autofocus/>
                            @error('mac_address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <x-input-label for="api_key" :value="__('API Key')"/>
                            <x-text-input wire:model="api_key" id="api_key" class="block mt-1 w-full" type="text"
                                          name="api_key" autofocus/>
                            @error('api_key') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <x-input-label for="friendly_id" :value="__('Friendly Id')"/>
                            <x-text-input wire:model="friendly_id" id="friendly_id" class="block mt-1 w-full"
                                          type="text" name="friendly_id" autofocus/>
                            @error('friendly_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <x-input-label for="default_refresh_interval" :value="__('Refresh Rate (seconds)')"/>
                            <x-text-input wire:model="default_refresh_interval" id="default_refresh_interval"
                                          class="block mt-1 w-full" type="text" name="default_refresh_interval"
                                          autofocus/>
                            @error('default_refresh_interval') <span
                                class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <x-primary-button type="submit">Create Device</x-primary-button>
                    </form>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                    <tr class="bg-gray-100 dark:bg-gray-800 ">
                        <th class="px-6 py-3 text-left dark:text-gray-100">Name</th>
                        <th class="px-6 py-3 text-left dark:text-gray-100">Friendly ID</th>
                        <th class="px-6 py-3 text-left dark:text-gray-100">Mac Address</th>
                        <th class="px-6 py-3 text-left dark:text-gray-100">Refresh</th>
                        <th class="px-6 py-3 text-left dark:text-gray-100">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($devices as $device)
                        <tr class="border-b">
                            <td class="px-6 py-4 dark:text-gray-100">{{ $device->name }}</td>
                            <td class="px-6 py-4 dark:text-gray-100">{{ $device->friendly_id }}</td>
                            <td class="px-6 py-4 dark:text-gray-100">{{ $device->mac_address }}</td>
                            <td class="px-6 py-4 dark:text-gray-100">{{ $device->default_refresh_interval }}</td>
                            <td class="px-6 py-4 dark:text-gray-100">
                                <x-secondary-button href="{{ route('devices.configure', $device) }}" wire:navigate>
                                    View
                                </x-secondary-button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $devices->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
