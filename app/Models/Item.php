<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'serial',
        'internal_serial',
        'device_id',
        'location_id',
        'status_id',
        'comments',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'device_id' => 'integer',
        'location_id' => 'integer',
        'status_id' => 'integer',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::updated(function (Item $item) {
            $item->historicals()->create([
                'item_id' => $item->id,
                'change_log' => [
                    'prev_state' => [
                        'serial' => $item->getOriginal('serial'),
                        'internal_serial' => $item->getOriginal('internal_serial'),
                        'device' => Device::find($item->getOriginal('device_id'))->display_name ?? 'No device',
                        'location' => Location::find($item->getOriginal('location_id'))->name ?? 'No location',
                        'status' => Status::find($item->getOriginal('status_id'))->name ?? 'No status',
                        'comments' => $item->getOriginal('comments'),
                    ],
                    'new_state' => [
                        'serial' => $item->serial,
                        'internal_serial' => $item->internal_serial,
                        'device' => $item->device?->display_name,
                        'location' => $item->location?->name,
                        'status' => $item->status?->name,
                        'comments' => $item->comments,
                    ],
                ],
                'change_date' => now(),
                'reason' => request()->input('reason') ?? 'No reason provided',
            ]);
        });
    }

    /**
     * Get the device that owns the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Device, Item>
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * Get the location that owns the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Location, Item>
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the status that owns the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Status, Item>
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Get all of the historicals for the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Historical>
     */
    public function historicals(): HasMany
    {
        return $this->hasMany(Historical::class);
    }
}
