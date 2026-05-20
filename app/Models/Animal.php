<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Animal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'species_id', 'enclosure_id', 'age', 'gender',
        'weight_kg', 'height_cm', 'diet', 'conservation_status',
        'description', 'fun_fact', 'arrival_date', 'is_featured', 'thumbnail',
    ];

    protected $casts = [
        'arrival_date' => 'date',
        'is_featured'  => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($animal) {
            if (empty($animal->slug)) {
                $animal->slug = Str::slug($animal->name) . '-' . Str::random(4);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function enclosure()
    {
        return $this->belongsTo(Enclosure::class);
    }

    public function images()
    {
        return $this->hasMany(AnimalImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(AnimalImage::class)->where('is_primary', true);
    }

    public function feedingSchedules()
    {
        return $this->hasMany(FeedingSchedule::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function allReviews()
    {
        return $this->hasMany(Review::class);
    }

    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function conservationBadgeColor(): string
    {
        return match ($this->conservation_status) {
            'Least Concern'        => 'green',
            'Near Threatened'      => 'lime',
            'Vulnerable'           => 'yellow',
            'Endangered'           => 'orange',
            'Critically Endangered'=> 'red',
            'Extinct in Wild'      => 'purple',
            default                => 'gray',
        };
    }

    public function averageRating(): float
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}
