<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Room;

class BookingTest extends TestCase
{
    public function test_user_can_access_booking_page(): void
    {
        $user = User::factory()->create();
        $room = Room::factory()->create();

        $response = $this->actingAs($user)
                         ->get("/booking/create/{$room->id}");

        $response->assertStatus(200);
    }
    
    public function test_guest_redirected_to_login(): void
    {
        $room = Room::factory()->create();
        
        $response = $this->get("/booking/create/{$room->id}");
        $response->assertRedirect('/login');
    }
}