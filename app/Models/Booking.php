<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'check_in',
        'check_out',
        'duration',
        'total_price',
        'otp',
        'otp_expires_at',
        'otp_verified',
        'status'
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'otp_expires_at' => 'datetime',
        'otp_verified' => 'boolean',
        'total_price' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function generateOTP()
    {
        $this->otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->otp_expires_at = now()->addMinutes(10);
        $this->save();
        return $this->otp;
    }

    public function verifyOTP($otp)
    {
        if ($this->otp === $otp && $this->otp_expires_at > now()) {
            $this->otp_verified = true;
            $this->status = 'confirmed';
            $this->save();
            return true;
        }
        return false;
    }
}