<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create Device') }}
        </h2>
    </x-slot>

    <div class="flex items-center justify-center py-12">
        <div class="w-full max-w-lg px-6">
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <h3 class="mb-4 text-lg font-semibold">{{ __('Create Device') }}</h3>
                <form method="POST" action="{{ route('devices.store') }}">
                    @csrf

                    <!-- Device Name -->
                    <div>
                        <x-input-label for="name" :value="__('Device Name')" />
                        <x-text-input id="name" class="block w-full mt-1" type="text" name="name"
                            :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Device Type -->
                    <div class="mt-4">
                        <x-input-label for="device_type" :value="__('Device Type')" />
                        <x-text-input id="device_type" class="block w-full mt-1" type="text" name="device_type"
                            :value="old('device_type')" required />
                        <x-input-error :messages="$errors->get('device_type')" class="mt-2" />
                    </div>

                    <!-- MAC Address -->
                    <div class="mt-4">
                        <x-input-label for="mac_address" :value="__('MAC Address')" />
                        <x-text-input id="mac_address" placeholder="AA:BB:CC:DD:EE:FF" class="block w-full mt-1"
                            type="text" name="mac_address" :value="old('mac_address')" required
                            pattern="^([0-9A-Fa-f]{2}:){5}[0-9A-Fa-f]{2}$"
                            title="Voer een geldig MAC-adres in (XX:XX:XX:XX:XX:XX)" />
                        <x-input-error :messages="$errors->get('mac_address')" class="mt-2" />
                    </div>

                    <!-- IP Address -->
                    <div class="mt-4">
                        <x-input-label for="ip_address" :value="__('IP Address')" />
                        <x-text-input id="ip_address" class="block w-full mt-1" type="text" name="ip_address"
                            :value="old('ip_address')" pattern="^(\d{1,3}\.){3}\d{1,3}$"
                            title="Voer een geldig IPv4-adres in (bijv. 192.168.0.1)" />
                        <x-input-error :messages="$errors->get('ip_address')" class="mt-2" />
                    </div>

                    <!-- Width & Height (side by side) -->
                    <div class="flex gap-4 mt-4">
                        <div class="w-1/2">
                            <x-input-label for="width" :value="__('Width (pixels)')" />
                            <x-text-input id="width" class="block w-full mt-1" type="number" name="width"
                                :value="old('width')" placeholder="3840" />
                            <x-input-error :messages="$errors->get('width')" class="mt-2" />
                        </div>

                        <div class="w-1/2">
                            <x-input-label for="height" :value="__('Height (pixels)')" />
                            <x-text-input id="height" class="block w-full mt-1" type="number" name="height"
                                :value="old('height')" placeholder="2160" />
                            <x-input-error :messages="$errors->get('height')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Rotation -->
                    <div class="mt-4">
                        <x-input-label for="rotation" :value="__('Rotation')" />
                        <select id="rotation" name="rotation"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">{{ __('Select Rotation') }}</option>
                            <option value="Landscape" {{ old('rotation') == 'Landscape' ? 'selected' : '' }}>
                                {{ __('Landscape') }}
                            </option>
                            <option value="Portrait" {{ old('rotation') == 'Portrait' ? 'selected' : '' }}>
                                {{ __('Portrait') }}
                            </option>
                        </select>
                        <x-input-error :messages="$errors->get('rotation')" class="mt-2" />
                    </div>

                    <!-- Location -->
                    <div class="mt-4">
                        <x-input-label for="location_id" :value="__('Location')" />
                        <select id="location_id" name="location_id"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">{{ __('Select Location') }}</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}"
                                    {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->parent?->name }}: {{ $location->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('location_id')" class="mt-2" />
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('devices.index') }}">
                            <x-secondary-button>
                                {{ __('Cancel') }}
                            </x-secondary-button>
                        </a>
                        <x-primary-button>
                            {{ __('Create') }}
                        </x-primary-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
