<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitat extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'region', 'climate', 'image', 'description'];

    public function enclosures()
    {
        return $this->hasMany(Enclosure::class);
    }

    public function animals()
    {
        return $this->hasManyThrough(Animal::class, Enclosure::class);
    }
}
