<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description'
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
