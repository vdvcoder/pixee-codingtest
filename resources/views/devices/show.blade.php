<!-- filepath: /Users/olivier/Code/Projects/pixee-codingtest/resources/views/devices/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Device Details') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold text-gray-900">{{ $device->name }} </h1>
                        <p class="mt-2 text-sm font-bold text-gray-700">
                            {{ __('Last Ping') }}:
                            @if ($device->status == 'green')
                                <span
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 rounded-md bg-green-50 ring-1 ring-inset ring-green-600/20">
                                    {{ \Carbon\Carbon::parse($device->last_ping)->diffForHumans() }}
                                </span>
                            @elseif ($device->status == 'yellow')
                                <span
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 rounded-md bg-yellow-50 ring-1 ring-inset ring-yellow-600/20">
                                    {{ \Carbon\Carbon::parse($device->last_ping)->diffForHumans() }}
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 rounded-md bg-red-50 ring-1 ring-inset ring-red-600/20">
                                    @if ($device->last_ping === null)
                                        {{ __('No Ping') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($device->last_ping)->diffForHumans() }}
                                    @endif
                                </span>
                            @endif
                        </p>
                    </div>

                </div>
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
                                                {{ __('Type') }}
                                            </th>
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
                                                {{ __('Width') }}
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                {{ __('Height') }}
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                {{ __('Rotation') }}
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                {{ __('Location') }}
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td
                                                class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                {{ $device->name }}</td>
                                            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ $device->device_type }}</td>
                                            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ $device->mac_address }}</td>
                                            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ $device->ip_address }}</td>
                                            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ $device->width }}px</td>
                                            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ $device->height }}px</td>
                                            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                {{ __($device->rotation) }}</td>
                                            <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                @if ($device->location)
                                                    <a href="{{ route('locations.show', $device->location) }}">
                                                        {{ $device->location?->parent?->name ? $device->location->parent->name . ': ' : '' }}
                                                        {{ $device->location?->name ?? __('No Location') }}
                                                    </a>
                                                @else
                                                    {{ __('No Location') }}
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-4">
                    <a href="{{ route('devices.index') }}">
                        <x-secondary-button class="">
                            {{ __('Back') }}
                        </x-secondary-button>
                    </a>
                    <a href="{{ route('devices.edit', $device) }}">
                        <x-secondary-button class="">
                            {{ __('Edit Device') }}
                        </x-secondary-button>
                    </a>
                </div>
            </div>

        </div>
    </div>


</x-app-layout>
