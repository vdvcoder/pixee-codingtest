<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Devices') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="container p-6 mx-auto">
                @if (session('success'))
                    <div class="p-4 my-4 rounded-md bg-green-50">
                        <div class="flex">
                            <div class="shrink-0">
                                <svg class="text-green-400 size-5" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>

                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-4 font-bold text-center bg-red-200 rounded shadow-sm">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold text-gray-900">{{ __('Devices') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">{{ __('Overview of all the devices.') }}</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a href="{{ route('devices.create') }}" class="">
                                <x-primary-button>
                                    {{ __('New Device') }}
                                </x-primary-button>
                            </a>

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
                                                    {{ __('Last Ping') }}</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Device') }}</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Type') }}</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('MAC') }}</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('IP') }}</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Location') }}</th>
                                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                    <span class="sr-only">Edit</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse ($devices as $device)
                                                <tr>
                                                    <!-- Status -->
                                                    @if ($device->last_ping === null)
                                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 rounded-md bg-red-50 ring-1 ring-inset ring-red-600/20">{{ __('No Ping') }}</span>
                                                        </td>
                                                    @elseif ($device->status == 'green')
                                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 rounded-md bg-green-50 ring-1 ring-inset ring-green-600/20">{{ \Carbon\Carbon::parse($device->last_ping)->diffForHumans() }}</span>

                                                        </td>
                                                    @elseif ($device->status == 'yellow')
                                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 rounded-md bg-yellow-50 ring-1 ring-inset ring-yellow-600/20">{{ \Carbon\Carbon::parse($device->last_ping)->diffForHumans() }}</span>
                                                        </td>
                                                    @else
                                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 rounded-md bg-red-50 ring-1 ring-inset ring-red-600/20">{{ \Carbon\Carbon::parse($device->last_ping)->diffForHumans() }}</span>

                                                        </td>
                                                    @endif

                                                    <!-- Device Name -->
                                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                        {{ Str::limit($device->name, 15) }}
                                                    </td>

                                                    <!-- Device Type -->
                                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                        {{ $device->device_type }}</td>

                                                    <!-- Device MAC -->
                                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                        {{ $device->mac_address }}</td>

                                                    <!-- Device IP -->
                                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                        {{ $device->ip_address }}</td>

                                                    <!-- Device Location -->
                                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                        @if ($device->location)
                                                            <a href="{{ route('locations.show', $device->location) }}">
                                                                {{ $device->location?->parent?->name ? $device->location->parent->name . ': ' : '' }}
                                                                <small>{{ $device->location->name }}</small>
                                                            </a>
                                                        @else
                                                            {{ __('No Location') }}
                                                        @endif
                                                    </td>
                                                    <td
                                                        class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                                        <a href="{{ route('devices.show', $device) }}"
                                                            class="text-blue-500 hover:underline">{{ __('Show') }}</a>
                                                        |
                                                        <a href="{{ route('devices.edit', $device) }}"
                                                            class="text-yellow-500 hover:underline">{{ __('Edit') }}</a>
                                                        |
                                                        <form action="{{ route('devices.destroy', $device) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-500 hover:underline"
                                                                onclick="return confirm('Weet je zeker dat je dit toestel wilt verwijderen?');">
                                                                {{ __('Delete') }}
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    {{ __('No devices found') }}/td>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
