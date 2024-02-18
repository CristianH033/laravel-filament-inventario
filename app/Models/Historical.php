<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Historical extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'item_id',
        'change_log',
        'change_date',
        'reason',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'item_id' => 'integer',
        'change_log' => 'array',
        'change_date' => 'datetime',
    ];

    protected $appends = ['display_changes'];

    /**
     * Get the item that owns the Historical
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Item, Historical>
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the changes attribute
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute<array<array<string, string>>, never>
     */
    public function displayChanges(): Attribute
    {
        // get diff between prev_state and new_state
        $diff = array_diff_assoc($this->change_log['new_state'], $this->change_log['prev_state']);

        $changes = [];

        foreach ($diff as $key => $value) {
            $changes[] = [
                'field' => __($key),
                'prev' => $this->change_log['prev_state'][$key],
                'new' => $value,
            ];
        }

        return Attribute::make(
            get: fn () => $changes
        );
    }

    // public function getM
}
