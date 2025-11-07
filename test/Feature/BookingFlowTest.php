<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingFlowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/home');
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }

    /** @test */
    public function user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function authenticated_user_can_view_home()
    {
        $user = User::factory()->create();
        
        Room::create([
            'name' => 'Test Room',
            'type' => 'Single',
            'description' => 'Test Description',
            'price' => 150000,
            'image' => 'https://example.com/image.jpg',
            'capacity' => 1,
            'available' => true
        ]);

        $response = $this->actingAs($user)->get('/home');

        $response->assertStatus(200);
        $response->assertSee('Test Room');
    }

    /** @test */
    public function authenticated_user_can_view_room_detail()
    {
        $user = User::factory()->create();
        
        $room = Room::create([
            'name' => 'Test Room',
            'type' => 'Single',
            'description' => 'Test Description',
            'price' => 150000,
            'image' => 'https://example.com/image.jpg',
            'capacity' => 1,
            'available' => true
        ]);

        $response = $this->actingAs($user)->get("/room/{$room->id}");

        $response->assertStatus(200);
        $response->assertSee('Test Room');
    }

    /** @test */
    public function authenticated_user_can_create_booking()
    {
        $user = User::factory()->create();
        
        $room = Room::create([
            'name' => 'Test Room',
            'type' => 'Single',
            'description' => 'Test Description',
            'price' => 150000,
            'image' => 'https://example.com/image.jpg',
            'capacity' => 1,
            'available' => true
        ]);

        $response = $this->actingAs($user)->post('/booking/store', [
            'room_id' => $room->id,
            'check_in' => now()->addDay()->format('Y-m-d'),
            'check_out' => now()->addDays(2)->format('Y-m-d'),
        ]);

        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'room_id' => $room->id,
            'status' => 'pending'
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function booking_generates_otp()
    {
        $user = User::factory()->create();
        
        $room = Room::create([
            'name' => 'Test Room',
            'type' => 'Single',
            'description' => 'Test Description',
            'price' => 150000,
            'image' => 'https://example.com/image.jpg',
            'capacity' => 1,
            'available' => true
        ]);

        $this->actingAs($user)->post('/booking/store', [
            'room_id' => $room->id,
            'check_in' => now()->addDay()->format('Y-m-d'),
            'check_out' => now()->addDays(2)->format('Y-m-d'),
        ]);

        $booking = Booking::first();

        $this->assertNotNull($booking->otp);
        $this->assertEquals(6, strlen($booking->otp));
    }

    /** @test */
    public function user_can_verify_otp()
    {
        $user = User::factory()->create();
        
        $room = Room::create([
            'name' => 'Test Room',
            'type' => 'Single',
            'description' => 'Test Description',
            'price' => 150000,
            'image' => 'https://example.com/image.jpg',
            'capacity' => 1,
            'available' => true
        ]);

        $booking = Booking::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'check_in' => now()->addDay(),
            'check_out' => now()->addDays(2),
            'duration' => 1,
            'total_price' => 150000,
            'otp' => '123456',
            'otp_expires_at' => now()->addMinutes(10),
            'otp_verified' => false,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($user)->post("/booking/verify-otp/{$booking->id}", [
            'otp' => '123456'
        ]);

        $booking->refresh();

        $this->assertTrue($booking->otp_verified);
        $this->assertEquals('confirmed', $booking->status);
        $response->assertRedirect("/booking/success/{$booking->id}");
    }

    /** @test */
    public function guest_cannot_access_home()
    {
        $response = $this->get('/home');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function guest_cannot_create_booking()
    {
        $room = Room::create([
            'name' => 'Test Room',
            'type' => 'Single',
            'description' => 'Test Description',
            'price' => 150000,
            'image' => 'https://example.com/image.jpg',
            'capacity' => 1,
            'available' => true
        ]);

        $response = $this->post('/booking/store', [
            'room_id' => $room->id,
            'check_in' => now()->addDay()->format('Y-m-d'),
            'check_out' => now()->addDays(2)->format('Y-m-d'),
        ]);

        $response->assertRedirect('/login');
    }
}