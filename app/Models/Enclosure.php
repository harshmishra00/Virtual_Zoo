<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enclosure extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'habitat_id', 'capacity', 'location_on_map', 'image'];

    public function habitat()
    {
        return $this->belongsTo(Habitat::class);
    }

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
}
