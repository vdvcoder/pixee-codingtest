<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Device;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(): View
    {
        /**
         * Retrieves a collection of base locations with additional data.
         *
         * This query fetches all locations marked as base locations (`is_base_location` set to true),
         * along with the following related data:
         * - Counts of associated children and devices for each base location.
         * - For each child location, the count of associated devices.
         *
         * The results are ordered alphabetically by the `name` attribute.
         */
        $baseLocations = Location::where('is_base_location', true)
            ->withCount(['children', 'devices'])
            ->with(['children' => function ($query) {
                $query->withCount('devices');
            }])
            ->orderBy('name')
            ->get();

        /**
         * Retrieve all locations with their associated devices and parent location,
         * along with the count of devices and children for each location. The results
         * are ordered by the 'name' attribute and grouped by their 'parent_id'.
         */
        $locations = Location::with('devices', 'parent')
            ->withCount(['devices', 'children'])
            ->orderBy('name')
            ->get()
            ->groupBy('parent_id');

        /**
         * Maps through the collection of locations and sorts each group by the 'name' attribute.
         */
        $locations = $locations->map(function ($group) {
            return $group->sortBy('name');
        });

        /**
         * Sorts the locations collection by the name of the parent location.
         *
         * The sorting is performed using a callback function that retrieves the name
         * of the parent location for the first item in each group. If the parent
         * location does not exist, an empty string is used as the sorting value.
         */
        $locations = $locations->sortBy(function ($group, $parentId) {
            return $group->first()->parent?->name ?? '';
        });

        return view('locations.index', compact('locations', 'baseLocations'));
    }

    public function create(): View
    {
        $parentLocations = Location::where('is_base_location', true)
            ->orderBy('name')
            ->get();

        $devices = Device::whereNull('location_id')->get();

        return view('locations.create', compact('parentLocations', 'devices'));
    }

    public function store(StoreLocationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $location = Location::create($validated);

        /**
         * Updates the location ID for each device associated with the provided device IDs.
         *
         * If the 'device_id' field in the validated data is not empty, this method iterates
         * through the array of device IDs, retrieves each corresponding device, updates its
         * location ID to the ID of the given location, and saves the changes to the database.
         */
        if (! empty($validated['device_id'])) {
            foreach ($validated['device_id'] as $deviceId) {
                $device = Device::find($deviceId);
                $device->location_id = $location->id;
                $device->save();
            }
        }

        return redirect()->route('locations.index')->with('success', __('Location created.'));
    }

    public function show(Location $location): View
    {
        return view('locations.show', compact('location'));
    }

    public function edit(Location $location): View
    {

        $parentLocations = Location::where('is_base_location', true)
            ->orderBy('name')
            ->get();

        $devices = Device::whereNull('location_id')
            ->orWhere('location_id', $location->id)
            ->get();

        return view('locations.edit', compact('location', 'parentLocations', 'devices'));
    }

    public function update(UpdateLocationRequest $request, Location $location): RedirectResponse
    {
        $validated = $request->validated();

        $location->update($validated);

        $currentDevices = $location->devices()->get();

        foreach ($currentDevices as $device) {
            $device->location_id = null;
            $device->save();
        }

        if (! empty($validated['device_id'])) {
            foreach ($validated['device_id'] as $deviceId) {
                $device = Device::find($deviceId);
                $device->location_id = $location->id;
                $device->save();
            }
        }

        return redirect()->route('locations.index')->with('success', __('Location updated successfully.'));
    }

    public function destroy(Location $location): RedirectResponse
    {
        // CHECK: Cannot delete a location that has linked devices.
        if ($location->devices()->exists()) {
            return back()->withErrors(['error' => __('You cannot delete a location that has a linked device.')]);
        }

        // CHECK: Cannot delete a location that has child locations.
        if ($location->children()->exists()) {
            return back()->withErrors(['error' => __('You cannot delete a location that has children.')]);
        }

        $location->delete();

        return redirect()->route('locations.index')->with('success', __('Location successfully deleted.'));
    }
}
