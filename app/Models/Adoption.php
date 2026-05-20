<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adoption extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'animal_id', 'amount', 'duration_months',
        'certificate_path', 'message', 'status', 'adopted_at', 'expires_at',
        'adopter_name', 'adopter_email'
    ];

    protected $casts = [
        'adopted_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
