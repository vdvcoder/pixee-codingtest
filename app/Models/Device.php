<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
    /** @use HasFactory<\Database\Factories\DeviceFactory> */
    use HasFactory;

    protected $fillable = [
        'location_id',
        'name',
        'device_type',
        'mac_address',
        'ip_address',
        'last_ping',
        'width',
        'height',
        'rotation',
    ];

    protected $casts = [
        'last_ping' => 'datetime',
    ];

    /**
     * Get the location associated with the device.
     *
     * This method defines an inverse one-to-many relationship
     * between the Device model and the Location model.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the status attribute for the device based on the last ping time.
     *
     * This method calculates the status of the device by comparing the current time
     * with the time of the last ping. The status is determined as follows:
     * - 'green': If the last ping was less than 10 minutes ago.
     * - 'yellow': If the last ping was between 10 and 30 minutes ago.
     * - 'red': If the last ping was more than 30 minutes ago or if there is no last ping.
     */
    public function getStatusAttribute()
    {
        if (! $this->last_ping) {
            return 'red';
        }

        return match (true) {
            $this->last_ping->diffInMinutes(now()) < 10 => 'green',
            $this->last_ping->diffInMinutes(now()) < 30 => 'yellow',
            default => 'red',
        };

    }
}
