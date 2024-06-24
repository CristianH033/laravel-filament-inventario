<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * Get all of the items for the Location
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Item>
     */
    public function ownedItems(): HasMany
    {
        return $this->hasMany(Item::class, 'owner_id', 'id');
    }

    /**
     * Get all of the items for the Location
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Item>
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Get all items for the Location and grouped by device category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Item>
     */
    public function itemsByDeviceCategory()
    {
        $categories = Category::whereHas('devices', function ($query) {
            $query->whereHas('items', function ($query) {
                $query->where('location_id', $this->id);
            });
        })->select('id', 'name')->get();

        $categories->map(function ($category) {
            $category->statuses = Status::select('id', 'name', 'color')->get()->map(function ($status) use ($category) {
                $status->items_count = Item::whereHas('device', function ($query) use ($category) {
                    $query->where('category_id', $category->id);
                })->where('location_id', $this->id)
                    ->where('status_id', $status->id)
                    ->count();

                return $status;
            });
        });

        return $categories;
    }
}
