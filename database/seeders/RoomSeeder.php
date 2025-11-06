<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'name' => 'Pod Single Minimalis',
                'type' => 'Single',
                'description' => 'Kamar pod single dengan desain minimalis modern, dilengkapi AC, WiFi super cepat, dan smart lighting',
                'price' => 150000,
                'image' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800',
                'capacity' => 1,
                'available' => true
            ],
            [
                'name' => 'Pod Double Cozy',
                'type' => 'Double',
                'description' => 'Kamar pod double nyaman untuk pasangan atau teman, dengan fasilitas lengkap dan privasi terjaga',
                'price' => 250000,
                'image' => 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?w=800',
                'capacity' => 2,
                'available' => true
            ],
            [
                'name' => 'Suite Premium',
                'type' => 'Suite',
                'description' => 'Suite premium dengan ruang lebih luas, sofa santai, smart TV, dan pemandangan kota',
                'price' => 450000,
                'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800',
                'capacity' => 2,
                'available' => true
            ],
            [
                'name' => 'Pod Single Tech',
                'type' => 'Single',
                'description' => 'Pod single dengan teknologi terkini, USB charging ports, smart control panel',
                'price' => 180000,
                'image' => 'https://images.unsplash.com/photo-1595526114035-0d45ed16cfbf?w=800',
                'capacity' => 1,
                'available' => true
            ],
            [
                'name' => 'Pod Double Deluxe',
                'type' => 'Double',
                'description' => 'Pod double deluxe dengan kasur king size, extra space, dan amenities premium',
                'price' => 320000,
                'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=800',
                'capacity' => 2,
                'available' => true
            ],
            [
                'name' => 'Suite Executive',
                'type' => 'Suite',
                'description' => 'Suite executive dengan workspace, meeting area, dan fasilitas bisnis lengkap',
                'price' => 550000,
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800',
                'capacity' => 3,
                'available' => true
            ]
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}