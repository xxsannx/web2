<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'price',
        'image',
        'capacity',
        'available'
    ];

    protected $casts = [
        'available' => 'boolean',
        'price' => 'decimal:2'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Accessor untuk tipe camping
    public function getCampingTypeAttribute()
    {
        return $this->type . ' Camping';
    }
}