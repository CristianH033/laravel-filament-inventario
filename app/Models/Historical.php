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
        // @phpstan-ignore-next-line
        $changeLog = is_array($this->change_log) ? $this->change_log : [];

        if (!array_key_exists('prev_state', $changeLog) || !array_key_exists('new_state', $changeLog)) {
            return Attribute::make(
                get: fn () => []
            );
        }

        if (!is_array($changeLog['prev_state']) || !is_array($changeLog['new_state'])) {
            return Attribute::make(
                get: fn () => []
            );
        }

        // get diff between prev_state and new_state
        $diff = array_diff_assoc($changeLog['new_state'], $changeLog['prev_state']);

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
}
