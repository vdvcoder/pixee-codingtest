<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Location') }}
        </h2>
    </x-slot>

    <div class="flex items-center justify-center py-12">
        <div class="w-full max-w-lg px-6">
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <h3 class="mb-4 text-lg font-semibold">{{ __('Edit Location') }}</h3>
                <form method="POST" action="{{ route('locations.update', $location) }}" x-data="{ isBaseLocation: {{ $location->is_base_location ? 'true' : 'false' }} }">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name Location')" />
                        <x-text-input id="name" class="block w-full mt-1" type="text" name="name"
                            :value="old('name', $location->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    @if ($location->is_base_location)
                        <!-- is base location -->
                        <div class="mt-4">
                            <x-input-label for="is_base_location" :value="__('Is Base Location')" />
                            <input type="checkbox" id="is_base_location" name="is_base_location" value="1"
                                x-model="isBaseLocation" {{ $location->is_base_location ? 'checked' : '' }}>
                            <x-input-error :messages="$errors->get('is_base_location')" class="mt-2" />
                        </div>
                    @endif


                    <!-- Location -->
                    <div class="mt-4" x-show="!isBaseLocation">
                        <x-input-label for="parent_id" :value="__('Base Location')" />
                        <select id="parent_id" name="parent_id"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">{{ __('Select Location') }}</option>
                            @foreach ($parentLocations as $parentLocation)
                                <option value="{{ $parentLocation->id }}"
                                    {{ old('parent_id', $location->parent_id) == $parentLocation->id ? 'selected' : '' }}>
                                    {{ $parentLocation->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
                    </div>

                    <!-- Device -->
                    <div class="mt-4" x-show="!isBaseLocation">
                        <x-input-label for="device_id" :value="__('Devices')" />
                        <select id="device_id" name="device_id[]" multiple
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                            @foreach ($devices as $device)
                                <option value="{{ $device->id }}"
                                    {{ in_array($device->id, old('device_id', $location->devices->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                                    {{ $device->name }} - {{ 'MAC: ' . $device->mac_address }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('device_id')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <a href="{{ route('locations.index') }}">
                            <x-secondary-button class="">
                                {{ __('Back') }}
                            </x-secondary-button>
                        </a>
                        <x-primary-button class="">
                            {{ __('Update') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
