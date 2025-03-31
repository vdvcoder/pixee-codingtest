<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Locations') }}
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

                <!-- Base Locations Table -->
                <div>
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold text-gray-900">{{ __('Base Locations') }}</h1>
                            <p class="mt-2 text-sm text-gray-700">
                                {{ __('Overview of all base locations, including the count of their child-locations and associated devices.') }}
                            </p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">

                            <a href="{{ route('locations.create') }}" class="">
                                <x-primary-button>
                                    {{ __('Add Location') }}
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
                                                    {{ __('Base Location Name') }}</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Total Children') }}</th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    {{ __('Total Devices') }}</th>
                                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                    <span class="sr-only">{{ __('Actions') }}</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse ($baseLocations as $baseLocation)
                                                <tr>
                                                    <td
                                                        class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                        {{ $baseLocation->name }}</td>
                                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                        {{ $baseLocation->children_count }}</td>
                                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                        {{ $baseLocation->children->sum('devices_count') + $baseLocation->devices_count }}
                                                    </td>

                                                    <td
                                                        class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                                        <a href="{{ route('locations.show', $baseLocation) }}"
                                                            class="text-blue-500 hover:underline">{{ __('Show') }}</a>
                                                        |
                                                        <a href="{{ route('locations.edit', $baseLocation) }}"
                                                            class="text-yellow-500 hover:underline">{{ __('Edit') }}</a>
                                                        |
                                                        <form action="{{ route('locations.destroy', $baseLocation) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-500 hover:underline"
                                                                onclick="return confirm('{{ __('Weet je zeker dat je deze locatie wilt verwijderen?') }}');">
                                                                {{ __('Delete') }}
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    {{ __('No Base Locations') }}</td>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Locations and sub-locations  -->
                <div class="mt-6 sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold text-gray-900">{{ __('Locations') }}</h1>
                        <p class="mt-2 text-sm text-gray-700">
                            {{ __('Overview of all base locations, including their child-locations and devices.') }}
                        </p>
                    </div>
                </div>
                <div class="flow-root mt-8">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black/5 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($locations as $parentId => $group)
                                            @if ($parentId && $group->isNotEmpty())
                                                <tr class="text-xl font-bold text-center bg-gray-100">
                                                    <td colspan="6" class="p-4 ml-4 border border-gray-300">
                                                        {{ $group->first()->parent?->name }}
                                                    </td>
                                                </tr>
                                                <tr class="bg-gray-50">
                                                    <th scope="col"
                                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                        {{ __('Location') }}</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left  text-sm font-semibold text-gray-900">
                                                        {{ __('Device') }}</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                        {{ __('MAC') }}</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                        {{ __('IP') }}</th>
                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                        <span class="sr-only">{{ __('Actions') }}</span>
                                                    </th>
                                                </tr>
                                                @foreach ($group as $location)
                                                    <tr class="text-left border-b-4 border-gray-300">
                                                        <td
                                                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">
                                                            <p>{{ $location->name }}</p>
                                                        </td>
                                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                            @forelse ($location->devices as $device)
                                                                <div class="flex items-center">
                                                                    @php
                                                                        $bgColor = match ($device->status) {
                                                                            'green' => 'bg-green-500',
                                                                            'red' => 'bg-red-500',
                                                                            'yellow' => 'bg-yellow-500',
                                                                            default => 'bg-red-500',
                                                                        };
                                                                    @endphp
                                                                    @php
                                                                        $lastPing = \Carbon\Carbon::parse(
                                                                            $device->last_ping,
                                                                        );
                                                                        $pingDiff =
                                                                            $device->last_ping === null ||
                                                                            $lastPing->diffInSeconds() < 5
                                                                                ? __('Geen ping')
                                                                                : $lastPing->diffForHumans();
                                                                    @endphp
                                                                    <div id="ping_status_{{ $device->id }}"
                                                                        class="flex items-center justify-center w-4 h-4 my-3 mr-3 {{ $bgColor }} rounded-full shrink-0"
                                                                        title="{{ $pingDiff }}">
                                                                    </div>
                                                                    <a href="{{ route('devices.show', $device) }}"
                                                                        class="">
                                                                        {{ $device->name }}
                                                                    </a>
                                                                </div>

                                                            @empty
                                                                <div class="flex items-center my-3">
                                                                    {{ __('No Devices') }}
                                                                </div>
                                                            @endforelse
                                                        </td>

                                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                            @foreach ($location->devices as $device)
                                                                <div class="flex items-center">
                                                                    <p class="my-3">{{ $device->mac_address }}</p>
                                                                </div>
                                                            @endforeach
                                                        </td>

                                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                            @foreach ($location->devices as $device)
                                                                <div class="flex items-center">
                                                                    <p class="my-3">{{ $device->ip_address }}</p>
                                                                </div>
                                                            @endforeach
                                                        </td>

                                                        <td
                                                            class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                                            <a href="{{ route('locations.show', $location) }}"
                                                                class="text-blue-500 hover:underline">{{ __('Show') }}</a>
                                                            |
                                                            <a href="{{ route('locations.edit', $location) }}"
                                                                class="text-yellow-500 hover:underline">{{ __('Edit') }}</a>
                                                            |
                                                            <form action="{{ route('locations.destroy', $location) }}"
                                                                method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="text-red-500 hover:underline"
                                                                    onclick="return confirm('Weet je zeker dat je deze locatie wilt verwijderen?');">
                                                                    {{ __('Delete') }}
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="6"
                                                    class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    {{ __('No Locations Found') }}
                                                </td>
                                            </tr>
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
    <script>
        // With the above scripts loaded, you can call `tippy()` with a CSS
        // selector and a `content` prop:
        tippy("[id^=ping_status_]", {
            content(reference) {
                return reference.getAttribute("title");
            },
            allowHTML: true,
            theme: 'light-border',
        });
    </script>
</x-app-layout>
