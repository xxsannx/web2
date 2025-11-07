<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Room;

class RoomModelTest extends TestCase
{
    public function test_room_creation(): void
    {
        $room = Room::factory()->create([
            'name' => 'Test Room',
            'type' => 'Standard',
            'price' => 100000,
        ]);

        $this->assertDatabaseHas('rooms', [
            'name' => 'Test Room',
            'type' => 'Standard',
        ]);
    }
    
    public function test_room_availability(): void
    {
        $availableRoom = Room::factory()->create(['available' => true]);
        $unavailableRoom = Room::factory()->create(['available' => false]);
        
        $this->assertTrue($availableRoom->available);
        $this->assertFalse($unavailableRoom->available);
    }
}