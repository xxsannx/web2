@extends('layouts.app')

@section('title', 'Booking - Pineus Tilu')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Booking Spot Camping</h1>
        <p class="text-gray-600">Lengkapi form booking untuk memulai petualangan camping Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Booking Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Formulir Booking
                </h2>
                
                <form action="{{ route('booking.store') }}" method="POST" x-data="bookingForm()">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                    
                    <div class="space-y-6">
                        <div>
                            <label for="check_in" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Tanggal Check-in
                            </label>
                            <input type="date" 
                                   id="check_in" 
                                   name="check_in" 
                                   required
                                   min="{{ date('Y-m-d') }}"
                                   x-model="checkIn"
                                   @change="calculateTotal"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
                        </div>

                        <div>
                            <label for="check_out" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Tanggal Check-out
                            </label>
                            <input type="date" 
                                   id="check_out" 
                                   name="check_out" 
                                   required
                                   x-model="checkOut"
                                   @change="calculateTotal"
                                   :min="checkIn || '{{ date('Y-m-d') }}'"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
                        </div>

                        <!-- Price Summary -->
                        <div class="bg-green-50 border-2 border-green-200 p-6 rounded-xl" x-show="duration > 0">
                            <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Ringkasan Biaya
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Durasi Camping:</span>
                                    <span x-text="duration + ' malam'"></span>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Harga per malam:</span>
                                    <span>Rp {{ number_format($room->price, 0, ',', '.') }}</span>
                                </div>
                                <div class="border-t border-green-200 pt-3 mt-3">
                                    <div class="flex justify-between font-bold text-gray-900">
                                        <span>Total Biaya:</span>
                                        <span x-text="'Rp ' + totalPrice.toLocaleString('id-ID')"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full bg-green-600 text-white py-4 rounded-xl text-lg font-semibold hover:bg-green-700 transition duration-150 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span>Lanjutkan ke Verifikasi</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Spot Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z"/>
                    </svg>
                    Detail Spot Camping
                </h3>
                
                <div class="mb-4">
                    <img src="{{ $room->image }}" alt="{{ $room->name }}" class="w-full h-32 object-cover rounded-lg shadow-md">
                </div>
                
                <h4 class="font-semibold text-gray-900 mb-2">{{ $room->name }}</h4>
                <p class="text-sm text-gray-600 mb-4 bg-green-100 text-green-800 px-3 py-1 rounded-full inline-block">{{ $room->type }}</p>
                
                <div class="space-y-2 text-sm mb-4">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Kapasitas: {{ $room->capacity }} Orang
                    </div>
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Fasilitas Lengkap
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-4">
                    <div class="text-2xl font-bold text-green-600">
                        Rp {{ number_format($room->price, 0, ',', '.') }}
                    </div>
                    <div class="text-sm text-gray-600">per malam</div>
                </div>

                <!-- Features -->
                <div class="mt-4 p-4 bg-green-50 rounded-lg">
                    <h4 class="font-semibold text-gray-900 mb-2 text-sm">Termasuk:</h4>
                    <ul class="text-xs text-gray-600 space-y-1">
                        <li>• Tenda & sleeping bag</li>
                        <li>• Akses area api unggun</li>
                        <li>• Toilet dan air bersih</li>
                        <li>• Security 24 jam</li>
                    </ul>
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