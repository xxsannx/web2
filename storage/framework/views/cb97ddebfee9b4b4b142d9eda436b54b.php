<?php $__env->startSection('title', 'Home - Pineus Tilu'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-green-700 to-emerald-800 text-white overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
            <h1 class="text-5xl font-extrabold mb-6 animate-pulse">Pineus Tilu</h1>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Temukan pengalaman camping tak terlupakan di alam terbuka dengan pemandangan menakjubkan</p>
            <div class="flex flex-wrap justify-center gap-3 mb-8">
                <span class="bg-white/20 backdrop-blur-sm px-6 py-2 rounded-full text-sm font-medium">🏔️ Pemandangan Gunung</span>
                <span class="bg-white/20 backdrop-blur-sm px-6 py-2 rounded-full text-sm font-medium">🌲 Udara Segar</span>
                <span class="bg-white/20 backdrop-blur-sm px-6 py-2 rounded-full text-sm font-medium">🔥 Api Unggun</span>
                <span class="bg-white/20 backdrop-blur-sm px-6 py-2 rounded-full text-sm font-medium">⛺ Tenda Nyaman</span>
            </div>
            <a href="#camping-spots" class="inline-block bg-white text-green-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
                Jelajahi Spot Camping
            </a>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-white shadow-lg sticky top-16 z-40 border-b" x-data="{ showFilter: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <button @click="showFilter = !showFilter" class="w-full md:hidden bg-green-600 text-white px-4 py-3 rounded-lg mb-4 flex items-center justify-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
            </svg>
            <span x-text="showFilter ? 'Sembunyikan Filter' : 'Tampilkan Filter'"></span>
        </button>
        
        <form method="GET" action="<?php echo e(route('home')); ?>" class="md:flex items-end space-y-4 md:space-y-0 md:space-x-6" :class="{'hidden': !showFilter}" x-show="true">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z"/>
                    </svg>
                    Tipe Camping
                </label>
                <select name="type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
                    <option value="">Semua Tipe Camping</option>
                    <option value="Standard" <?php echo e(request('type') == 'Standard' ? 'selected' : ''); ?>>🏕️ Standard</option>
                    <option value="Family" <?php echo e(request('type') == 'Family' ? 'selected' : ''); ?>>👨‍👩‍👧‍👦 Family</option>
                    <option value="Premium" <?php echo e(request('type') == 'Premium' ? 'selected' : ''); ?>>⭐ Premium</option>
                    <option value="Backpacker" <?php echo e(request('type') == 'Backpacker' ? 'selected' : ''); ?>>🎒 Backpacker</option>
                    <option value="Romance" <?php echo e(request('type') == 'Romance' ? 'selected' : ''); ?>>💖 Romance</option>
                    <option value="Group" <?php echo e(request('type') == 'Group' ? 'selected' : ''); ?>>👥 Group</option>
                </select>
            </div>
            
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                    Budget Maksimal
                </label>
                <input type="number" name="max_price" value="<?php echo e(request('max_price')); ?>" 
                       placeholder="Contoh: 300000" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
            
            <div class="flex space-x-3">
                <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition font-semibold shadow-lg flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span>Cari</span>
                </button>
                
                <a href="<?php echo e(route('home')); ?>" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg hover:bg-gray-300 transition font-semibold flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Reset</span>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Camping Spots -->
<div id="camping-spots" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Spot Camping Terbaik</h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">Pilih spot camping favorit Anda dan rasakan pengalaman menginap di alam yang tak terlupakan</p>
    </div>
    
    <?php if($rooms->count() > 0): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="camping-card group">
            <div class="relative h-64 overflow-hidden">
                <img src="<?php echo e($room->image); ?>" alt="<?php echo e($room->name); ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-sm font-semibold shadow-lg">
                    <?php echo e($room->type); ?>

                </div>
                <div class="absolute bottom-4 left-4 text-white">
                    <h3 class="text-xl font-bold mb-1"><?php echo e($room->name); ?></h3>
                    <div class="flex items-center space-x-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span><?php echo e($room->capacity); ?> Orang</span>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e($room->description); ?></p>
                
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-2xl font-bold text-green-600">Rp <?php echo e(number_format($room->price, 0, ',', '.')); ?></span>
                        <span class="text-gray-500 text-sm">/malam</span>
                    </div>
                    <a href="<?php echo e(route('room.show', $room->id)); ?>" 
                       class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php else: ?>
    <div class="text-center py-16 bg-white rounded-2xl shadow-lg">
        <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Tidak ada spot camping tersedia</h3>
        <p class="text-gray-600 mb-6">Coba ubah filter pencarian Anda atau hubungi kami untuk informasi lebih lanjut</p>
        <a href="<?php echo e(route('home')); ?>" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
            Tampilkan Semua Spot
        </a>
    </div>
    <?php endif; ?>
</div>

<!-- Features Section -->
<div class="bg-gradient-to-br from-green-50 to-emerald-100 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Mengapa Memilih Pineus Tilu?</h2>
            <p class="text-xl text-gray-600">Kami menyediakan pengalaman camping terbaik dengan fasilitas lengkap dan pelayanan terbaik</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition">
                <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-xl mb-3">Aman & Terjamin</h3>
                <p class="text-gray-600">Area camping terjaga 24 jam dengan security profesional untuk kenyamanan Anda</p>
            </div>
            
            <div class="text-center bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition">
                <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-xl mb-3">Pemandangan Eksklusif</h3>
                <p class="text-gray-600">Nikmati view gunung, sunrise, dan alam yang memukau dari setiap spot camping</p>
            </div>
            
            <div class="text-center bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition">
                <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-xl mb-3">Harga Terjangkau</h3>
                <p class="text-gray-600">Dari Rp 80.000/malam, pengalaman camping berkualitas untuk semua kalangan</p>
            </div>
            
            <div class="text-center bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition">
                <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-xl mb-3">Lokasi Strategis</h3>
                <p class="text-gray-600">Dekat dengan jalur pendakian, sumber air, dan fasilitas pendukung lainnya</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-gradient-to-r from-green-600 to-emerald-700 text-white py-16">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-4">Siap untuk Petualangan Camping?</h2>
        <p class="text-xl mb-8 opacity-90">Bergabunglah dengan ribuan traveler yang telah merasakan pengalaman tak terlalu di Pineus Tilu</p>
        <a href="<?php echo e(route('home')); ?>#camping-spots" class="inline-block bg-white text-green-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg text-lg">
            Booking Sekarang 🏕️
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/home.blade.php ENDPATH**/ ?>