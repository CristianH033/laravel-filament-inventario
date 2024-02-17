<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'model',
        'category_id',
        'brand_id',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'category_id' => 'integer',
        'brand_id' => 'integer',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = ['display_name'];

    /**
     * Get the category that owns the Device
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Category, Device>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand that owns the Device
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Brand, Device>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get all of the items for the Device
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Item>
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /** @return \Illuminate\Database\Eloquent\Casts\Attribute<string, never> */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->brand?->name . ' ' . $this->model
        );
    }
}
