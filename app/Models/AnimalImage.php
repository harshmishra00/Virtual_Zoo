<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalImage extends Model
{
    use HasFactory;

    protected $fillable = ['animal_id', 'image_path', 'caption', 'is_primary'];

    protected $casts = ['is_primary' => 'boolean'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
