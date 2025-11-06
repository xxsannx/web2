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
                'name' => 'Tenda Dome Standard',
                'type' => 'Standard',
                'description' => 'Tenda dome nyaman dengan kapasitas 2 orang, cocok untuk pasangan atau solo traveler yang ingin menikmati alam dengan fasilitas dasar yang memadai',
                'price' => 120000,
                'image' => 'https://images.unsplash.com/photo-1504851149312-7a075b496cc7?w=800',
                'capacity' => 2,
                'available' => true
            ],
            [
                'name' => 'Tenda Family Glamping',
                'type' => 'Family',
                'description' => 'Tenda glamping luas untuk keluarga, dilengkapi tempat tidur nyaman, area duduk yang lapang, dan fasilitas keluarga lengkap',
                'price' => 350000,
                'image' => 'https://images.unsplash.com/photo-1571863533956-01c88e79957e?w=800',
                'capacity' => 4,
                'available' => true
            ],
            [
                'name' => 'Camping Site Premium',
                'type' => 'Premium',
                'description' => 'Area camping premium dengan pemandangan gunung langsung, fasilitas lengkap, privasi maksimal, dan akses ke spot foto terbaik',
                'price' => 280000,
                'image' => 'https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?w=800',
                'capacity' => 3,
                'available' => true
            ],
            [
                'name' => 'Tenda Backpacker',
                'type' => 'Backpacker',
                'description' => 'Tenda ekonomis untuk backpacker, cocok untuk petualang solo yang mengutamakan pengalaman alam dengan budget terbatas',
                'price' => 80000,
                'image' => 'https://images.unsplash.com/photo-1539185441755-769473a23570?w=800',
                'capacity' => 1,
                'available' => true
            ],
            [
                'name' => 'Tenda Romance Sunset',
                'type' => 'Romance',
                'description' => 'Tenda khusus pasangan dengan view sunset terbaik, dilengkapi dekorasi romantis, tempat tidur premium, dan privasi total',
                'price' => 420000,
                'image' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=800',
                'capacity' => 2,
                'available' => true
            ],
            [
                'name' => 'Camping Ground Group',
                'type' => 'Group',
                'description' => 'Area camping luas untuk kelompok besar, bisa menampung hingga 8 tenda kecil, lengkap dengan area api unggun dan gathering',
                'price' => 750000,
                'image' => 'https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?w=800',
                'capacity' => 15,
                'available' => true
            ],
            [
                'name' => 'Tenda Forest View',
                'type' => 'Standard',
                'description' => 'Tenda dengan pemandangan hutan pinus, udara sejuk, dan suasana yang menenangkan untuk melepas penat',
                'price' => 150000,
                'image' => 'https://images.unsplash.com/photo-1445308394109-4ec2920981b1?w=800',
                'capacity' => 2,
                'available' => true
            ],
            [
                'name' => 'Glamping Luxury',
                'type' => 'Premium',
                'description' => 'Pengalaman glamping mewah dengan interior nyaman, kamar mandi dalam, dan fasilitas bintang 5 di alam terbuka',
                'price' => 550000,
                'image' => 'https://images.unsplash.com/photo-1596394516093-9ba11a84a6d6?w=800',
                'capacity' => 2,
                'available' => true
            ]
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}