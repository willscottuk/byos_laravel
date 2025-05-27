<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class Playlist extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'weekdays' => 'array',
        'active_from' => 'datetime:H:i',
        'active_until' => 'datetime:H:i',
        'refresh_time' => 'integer',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PlaylistItem::class);
    }

    public function isActiveNow(): bool
    {
        if (! $this->is_active) {
            Log::info("Playlist {$this->id} is disabled.");
            return false;
        }

        // Check weekday
        if ($this->weekdays !== null) {
            if (! in_array(now()->dayOfWeek, $this->weekdays)) {
                Log::info("Playlist {$this->id} is not active today (Weekday: " . now()->dayOfWeek . ").");
                return false;
            }
        }
        // Check time range
        if ($this->active_from !== null && $this->active_until !== null) {
            if (! now()->between($this->active_from, $this->active_until)) {
                Log::info("Playlist {$this->id} is not active at this time (Current Time: " . now()->format('H:i') . " vs Range: {$this->active_from->format('H:i')} to {$this->active_until->format('H:i')}).");
                return false;
            }
        }

        return true;
    }

    public function getLastPlaylistItem(): ?PlaylistItem
    {
        // Get the last displayed item
        $lastDisplayed = $this->items()
            ->orderByDesc('last_displayed_at')
            ->first();

        if (! $lastDisplayed) {
            Log::info("No displayed items found in Playlist {$this->id}.");
            return null;
        }

        Log::info("Last displayed item in Playlist {$this->id} is Item ID: {$lastDisplayed->id}.");

        return $lastDisplayed;
    }

    public function getNextPlaylistItem(): ?PlaylistItem
    {
        if (! $this->isActiveNow()) {
            return null;
        }

        // Get active playlist items ordered by display order
        $playlistItems = $this->items()
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        if ($playlistItems->isEmpty()) {
            Log::info("No active items found in Playlist {$this->id}.");
            return null;
        }

        // Get the last displayed item
        $lastDisplayed = $playlistItems
            ->sortByDesc('last_displayed_at')
            ->first();

        if (! $lastDisplayed || ! $lastDisplayed->last_displayed_at) {
            // If no item has been displayed yet, return the first one
            Log::info("No last displayed item found in Playlist {$this->id}, returning the first item.");
            return $playlistItems->first();
        }

        // Find the next item in sequence
        $currentOrder = $lastDisplayed->order;
        $nextItem = $playlistItems
            ->where('order', '>', $currentOrder)
            ->first();
        Log::info("Last displayed item order: {$currentOrder}, Next item order: " . ($nextItem ? $nextItem->order : 'None'));

        // If there's no next item, loop back to the first one
        if (! $nextItem) {
            return $playlistItems->first();
            Log::info("Looping back to the first item in Playlist {$this->id}.");
        }

        return $nextItem;
    }
}
