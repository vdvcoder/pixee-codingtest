<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Location Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        @if ($location->is_base_location)
                            <h1 class="text-lg font-semibold text-gray-900">
                                {{ $location->name }}
                                <a href="{{ route('locations.edit', $location) }}"
                                    class="ml-4 text-base text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                            </h1>
                            <small> {{ $location->name }} {{ __('is a base location with child-locations') }}</small>
                        @else
                            <h1 class="text-lg font-semibold text-gray-900">
                                {{ $location->parent?->name ? $location->parent?->name . ':' : '' }}
                                {{ $location->name }}
                                <a href="{{ route('locations.edit', $location) }}"
                                    class="ml-4 text-base text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                            </h1>
                            <small> {{ $location->parent?->name ? $location->parent?->name . ':' : '' }}
                                {{ $location->name }} {{ __('is a location with devices') }}</small>
                        @endif
                    </div>
                </div>

                @if ($location->is_base_location)
                    <div class="flow-root mt-8">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black/5 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                    {{ __('Locations') }}
                                                </th>

                                                <th scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($location->children as $subLocation)
                                                <tr>
                                                    <td
                                                        class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                        <a href="{{ route('locations.show', $subLocation) }}"
                                                            class="">
                                                            {{ $subLocation->name }}
                                                        </a>
                                                    </td>

                                                    <td
                                                        class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                                        <a href="{{ route('locations.edit', $subLocation) }}"
                                                            class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flow-root mt-8">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black/5 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                    {{ __('Name') }}</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('MAC') }}
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('IP') }}
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Ping Status') }}
                                                </th>

                                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                    <span class="sr-only">{{ __('Edit') }}</span>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse ($location->devices as $device)
                                                <tr>
                                                    <td
                                                        class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                        <a href="{{ route('devices.show', $device) }}" class="">
                                                            {{ $device->name }}
                                                        </a>
                                                    </td>
                                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                        {{ $device->mac_address }}</td>
                                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                        {{ $device->ip_address }}</td>
                                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                        @if ($device->last_ping === null)
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 rounded-md bg-red-50 ring-1 ring-inset ring-red-600/20">{{ __('No Ping') }}</span>
                                                        @elseif ($device->status == 'green')
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 rounded-md bg-green-50 ring-1 ring-inset ring-green-600/20">{{ \Carbon\Carbon::parse($device->last_ping)->diffForHumans() }}</span>
                                                        @elseif ($device->status == 'yellow')
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 rounded-md bg-yellow-50 ring-1 ring-inset ring-yellow-600/20">{{ \Carbon\Carbon::parse($device->last_ping)->diffForHumans() }}</span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 rounded-md bg-red-50 ring-1 ring-inset ring-red-600/20">{{ \Carbon\Carbon::parse($device->last_ping)->diffForHumans() }}</span>
                                                        @endif

                                                    </td>
                                                    <td
                                                        class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                                        <a href="{{ route('devices.edit', $device) }}"
                                                            class="text-indigo-600 hover:text-indigo-900">
                                                            {{ __('Edit Device') }}</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    {{ __('No Devices found') }}
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap"></td>
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap"></td>
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap"></td>
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap"></td>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="flex items-center justify-between mt-4">
                    <a href="{{ route('locations.index') }}">
                        <x-secondary-button class="">
                            {{ __('Back') }}
                        </x-secondary-button>
                    </a>

                    <a href="{{ route('locations.edit', $location) }}">
                        <x-secondary-button class="">
                            {{ __('Edit Location') }}
                        </x-secondary-button>
                    </a>

                </div>
            </div>



        </div>

    </div>
    </div>
</x-app-layout>
