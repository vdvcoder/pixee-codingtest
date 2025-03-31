<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create Location') }}
        </h2>
    </x-slot>

    <div class="flex items-center justify-center py-12">
        <div class="w-full max-w-lg px-6">
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <h3 class="mb-4 text-lg font-semibold">{{ __('Create Location') }}</h3>
                <form method="POST" action="{{ route('locations.store') }}" x-data="{ isBaseLocation: {{ old('is_base_location') ? 'true' : 'false' }} }">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name Location')" />
                        <x-text-input id="name" class="block w-full mt-1" type="text" name="name"
                            :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- is base location -->
                    <div class="mt-4">
                        <x-input-label for="is_base_location" :value="__('Is Base Location')" />
                        <input type="checkbox" id="is_base_location" name="is_base_location" value="1"
                            x-model="isBaseLocation">
                        <x-input-error :messages="$errors->get('is_base_location')" class="mt-2" />
                    </div>

                    <!-- Location -->
                    <div class="mt-4" x-show="!isBaseLocation">
                        <x-input-label for="parent_id" :value="__('Base Location')" />
                        <select id="parent_id" name="parent_id"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">{{ __('Select Location') }}</option>
                            @foreach ($parentLocations as $location)
                                <option value="{{ $location->id }}"
                                    {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
                    </div>

                    <!-- Device -->
                    <div class="mt-4" x-show="!isBaseLocation">
                        <x-input-label for="device_id" :value="__('Device')" />
                        <select id="device_id" name="device_id[]" multiple
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach ($devices as $device)
                                <option value="{{ $device->id }}"
                                    {{ in_array($device->id, old('device_id') ?? []) ? 'selected' : '' }}>
                                    {{ $device->name }} - {{ 'MAC: ' . $device->mac_address }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('device_id')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <a href="{{ route('locations.index') }}">
                            <x-secondary-button>
                                {{ __('Cancel') }}
                            </x-secondary-button>
                        </a>
                        <x-primary-button class="">
                            {{ __('Create') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
