<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    /** @use HasFactory<\Database\Factories\LocationFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
        'is_base_location',
    ];

    /**
     * Get the parent location associated with this location.
     *
     * This method defines an inverse one-to-many relationship where
     * the current location belongs to a parent location.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    /**
     * Get the child locations associated with the current location.
     *
     * This defines a one-to-many relationship where the current location
     * can have multiple child locations.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    /**
     * Get the devices associated with the location.
     *
     * This method defines a one-to-many relationship between the Location model
     * and the Device model. Each location can have multiple devices.
     */
    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    /**
     * Determine if the current location is an end node.
     *
     * An end node is defined as a location that has no child nodes. A Parent
     *
     * @return bool True if the location is an end node, false otherwise.
     */
    public function isEndNode(): bool
    {
        return $this->children()->count() === 0;
    }
}
