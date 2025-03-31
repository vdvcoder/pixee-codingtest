<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Models\Device;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DeviceController extends Controller
{
    public function index(): View
    {
        /**
         * Retrieves a collection of devices with their associated locations and parent locations,
         * sorts the devices based on the name of their parent location, or defaults to 'no parent'
         * if the parent location is not available.
         */
        $devices = Device::with('location.parent')
            ->get()
            ->sortBy(function ($device) {
                return $device->location?->parent?->name ?? 'no parent';
            });

        return view('devices.index', compact('devices'));
    }

    public function create(): View
    {
        /**
         * Retrieves a collection of locations that are not base locations,
         * including their parent relationships, and sorts them by the name
         * of their parent location (if available).
         */
        $locations = Location::with('parent')
            ->where('is_base_location', false)
            ->get()
            ->sortBy(function ($location) {
                return $location->parent?->name ?? '';
            });

        return view('devices.create', compact('locations'));
    }

    public function store(StoreDeviceRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Device::create($validated);

        return redirect()->route('devices.index')->with('success', __('Device created.'));
    }

    public function show(Device $device): View
    {
        return view('devices.show', compact('device'));
    }

    public function edit(Device $device): View
    {
        /**
         * Retrieves a collection of locations that are not base locations,
         * including their parent relationships, and sorts them by the name
         * of their parent location (if available).
         */
        $locations = Location::with('parent')
            ->where('is_base_location', false)
            ->get()
            ->sortBy(function ($location) {
                return $location->parent?->name ?? '';
            });

        return view('devices.edit', compact('device', 'locations'));
    }

    public function update(UpdateDeviceRequest $request, Device $device): RedirectResponse
    {
        $validated = $request->validated();

        $device->update($validated);

        return redirect()->route('devices.index')->with('success', __('Device updated successfully.'));

    }

    public function destroy(Device $device): RedirectResponse
    {
        $device->delete();

        return redirect()->route('devices.index')->with('success', __('Device successfully deleted.'));
    }
}
