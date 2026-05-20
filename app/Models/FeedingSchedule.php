<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedingSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_id', 'feed_time', 'food_type', 'quantity_kg', 'days_of_week', 'notes',
    ];

    protected $casts = [
        'days_of_week' => 'array',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function getPeriodAttribute(): string
    {
        $hour = (int) substr($this->feed_time, 0, 2);
        if ($hour < 12) return 'Morning';
        if ($hour < 17) return 'Afternoon';
        return 'Evening';
    }
}
