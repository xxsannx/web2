@extends('layouts.app')

@section('title', 'Booking - BoboPod')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Booking Room</h1>
        <p class="text-gray-600">Lengkapi form booking untuk melanjutkan</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Booking Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Detail Booking</h2>
                
                <form action="{{ route('booking.store') }}" method="POST" x-data="bookingForm()">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                    
                    <div class="space-y-6">
                        <div>
                            <label for="check_in" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Check-in
                            </label>
                            <input type="date" 
                                   id="check_in" 
                                   name="check_in" 
                                   required
                                   min="{{ date('Y-m-d') }}"
                                   x-model="checkIn"
                                   @change="calculateTotal"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="check_out" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Check-out
                            </label>
                            <input type="date" 
                                   id="check_out" 
                                   name="check_out" 
                                   required
                                   x-model="checkOut"
                                   @change="calculateTotal"
                                   :min="checkIn || '{{ date('Y-m-d') }}'"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg" x-show="duration > 0">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>Durasi:</span>
                                <span x-text="duration + ' malam'"></span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>Harga per malam:</span>
                                <span>Rp {{ number_format($room->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-2 mt-2">
                                <div class="flex justify-between font-bold text-gray-900">
                                    <span>Total:</span>
                                    <span x-text="'Rp ' + totalPrice.toLocaleString('id-ID')"></span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-150 shadow-lg hover:shadow-xl">
                            Lanjutkan ke Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Room Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Detail Room</h3>
                
                <div class="mb-4">
                    <img src="{{ $room->image }}" alt="{{ $room->name }}" class="w-full h-32 object-cover rounded-lg">
                </div>
                
                <h4 class="font-semibold text-gray-900 mb-2">{{ $room->name }}</h4>
                <p class="text-sm text-gray-600 mb-4">{{ $room->type }}</p>
                
                <div class="space-y-2 text-sm">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $room->capacity }} Orang
                    </div>
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        WiFi & AC
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="text-2xl font-bold text-indigo-600">
                        Rp {{ number_format($room->price, 0, ',', '.') }}
                    </div>
                    <div class="text-sm text-gray-600">per malam</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function bookingForm() {
    return {
        checkIn: '',
        checkOut: '',
        duration: 0,
        totalPrice: 0,
        pricePerNight: {{ $room->price }},
        
        calculateTotal() {
            if (this.checkIn && this.checkOut) {
                const start = new Date(this.checkIn);
                const end = new Date(this.checkOut);
                const diffTime = Math.abs(end - start);
                this.duration = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                this.totalPrice = this.duration * this.pricePerNight;
            }
        }
    }
}
</script>
@endsection