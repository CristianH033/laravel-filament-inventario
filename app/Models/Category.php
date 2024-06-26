<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Category extends Model
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
     * Get all of the devices for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Device>
     */
    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    /**
     * Get all the items for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough<Item, Device>
     */
    public function items(): HasManyThrough
    {
        return $this->hasManyThrough(Item::class, Device::class);
    }
}
