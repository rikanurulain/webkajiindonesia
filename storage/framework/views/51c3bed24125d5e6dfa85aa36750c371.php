<?php $__env->startSection('title', 'Profil Trainer – ' . $trainer->name); ?>

<?php $__env->startSection('content'); ?>


<section class="bg-gradient-to-br from-primary-dark via-primary to-primary- py-10 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="font-serif text-2xl font-bold">Profil Trainer</h1>
    </div>
</section>

<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-3xl mx-auto px-4 space-y-5">

        
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
            <div class="flex flex-col sm:flex-row">

                
                <div class="w-full sm:w-52 h-52 bg-green-100 flex-shrink-0 overflow-hidden">
                    <?php if($trainer->foto): ?>
                        <img src="<?php echo e(asset('storage/' . $trainer->foto)); ?>"
                             alt="<?php echo e($trainer->name); ?>"
                             class="w-full h-full object-cover object-top">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-5xl font-bold text-green-800">
                            <?php echo e(strtoupper(substr($trainer->name, 0, 2))); ?>

                        </div>
                    <?php endif; ?>
                </div>

                
                <div class="p-6 flex-1">
                    <?php if($trainer->bidang_keahlian): ?>
                    <span class="inline-block bg-green-100 text-green-700 text-xs font-bold
                                 px-3 py-1 rounded-full mb-3">
                        <?php echo e($trainer->bidang_keahlian); ?>

                    </span>
                    <?php endif; ?>

                    <h2 class="text-xl font-bold text-gray-900 mb-1"><?php echo e($trainer->name); ?></h2>
                    <p class="text-sm text-gray-400 mb-3">Trainer Profesional · KAJI INDONESIA</p>

                    
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <svg class="w-4 h-4 <?php echo e($i <= round($avgRating) ? 'text-amber-400' : 'text-gray-200'); ?>"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            <?php endfor; ?>
                        </div>
                        <span class="text-sm font-bold text-gray-800"><?php echo e(number_format($avgRating, 1)); ?></span>
                        <span class="text-xs text-gray-400">(<?php echo e($totalUlasan); ?> ulasan)</span>
                    </div>

                    
                    <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                        <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5a2.25 2.25 0 00-2.25 2.25m19.5 0l-9.75 6.75L2.25 6.75"/>
                        </svg>
                        <?php echo e($trainer->email); ?>

                    </div>

                    
                    <?php if($trainer->phone): ?>
                    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                        <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 6.338c0-.414.336-.75.75-.75h2.25a.75.75 0 01.75.645l.75 4.5a.75.75 0 01-.54.852l-1.5.5a11.025 11.025 0 005.557 5.557l.5-1.5a.75.75 0 01.852-.54l4.5.75a.75.75 0 01.645.75v2.25a.75.75 0 01-.75.75C10.556 21.75 2.25 13.444 2.25 6.338z"/>
                        </svg>
                        <?php echo e($trainer->phone); ?>

                    </div>
                    <?php endif; ?>

                    
                    <?php if($trainer->phone): ?>
                    <?php
                        $waPhone = preg_replace('/[^0-9]/', '', $trainer->phone);
                        $waText  = urlencode('Halo ' . $trainer->name . ', saya ingin berkonsultasi mengenai pelatihan.');
                    ?>
                    <a href="https://wa.me/<?php echo e($waPhone); ?>?text=<?php echo e($waText); ?>"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600
                              text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Hubungi via WhatsApp
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <?php if($trainer->bio): ?>
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="font-serif text-lg font-bold text-gray-900 mb-3 pb-3 border-b border-gray-100">
                Tentang Trainer
            </h3>
            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line"><?php echo e($trainer->bio); ?></p>
        </div>
        <?php endif; ?>

        
        <?php
            $programs = \App\Models\Program::where('trainer_id', $trainer->id)
                ->where('tipe', 'kurikulum')
                ->where('status', 'approved')
                ->latest()->get();
        ?>
        <?php if($programs->count() > 0): ?>
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="font-serif text-lg font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100">
                Program / Kurikulum
                <span class="text-sm font-normal text-gray-400 ml-2"><?php echo e($programs->count()); ?> program</span>
            </h3>
            <div class="space-y-3">
                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('pelatihan.detail', $prog->id)); ?>"
                   class="flex items-center gap-4 p-3 rounded-xl border border-gray-100
                          hover:border-green-200 hover:bg-green-50 transition group">
                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-green-100 flex-shrink-0
                                flex items-center justify-center text-xl">
                        <?php if($prog->gambar): ?>
                            <img src="<?php echo e(asset('storage/' . $prog->gambar)); ?>" alt="<?php echo e($prog->judul); ?>"
                                 class="w-full h-full object-cover">
                        <?php else: ?> 📚 <?php endif; ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-semibold text-gray-900 group-hover:text-green-700 truncate transition">
                            <?php echo e($prog->judul); ?>

                        </div>
                        <div class="text-xs text-gray-400 mt-0.5 flex gap-3">
                            <?php if($prog->metode): ?> <span><?php echo e(ucfirst($prog->metode)); ?></span> <?php endif; ?>
                            <?php if($prog->tingkat): ?> <span><?php echo e(ucfirst($prog->tingkat)); ?></span> <?php endif; ?>
                            <?php if($prog->total_jam): ?> <span>⏱ <?php echo e((int)$prog->total_jam); ?> jam</span> <?php endif; ?>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-green-500 flex-shrink-0 transition"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        
        <?php
            $trainerEvents = \App\Models\Event::where('trainer_id', $trainer->id)
                ->where('status', 'approved')
                ->latest()->get();
        ?>
        <?php if($trainerEvents->count() > 0): ?>
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="font-serif text-lg font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100">
                Event
                <span class="text-sm font-normal text-gray-400 ml-2"><?php echo e($trainerEvents->count()); ?> event</span>
            </h3>
            <div class="space-y-3">
                <?php $__currentLoopData = $trainerEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('pelatihan.event.detail', $ev->id)); ?>"
                   class="flex items-center gap-4 p-3 rounded-xl border border-gray-100
                          hover:border-orange-200 hover:bg-orange-50 transition group">
                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-orange-100 flex-shrink-0
                                flex items-center justify-center text-xl">
                        <?php if($ev->gambar): ?>
                            <img src="<?php echo e(asset('storage/' . $ev->gambar)); ?>" alt="<?php echo e($ev->judul); ?>"
                                 class="w-full h-full object-cover">
                        <?php else: ?> 🎪 <?php endif; ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-semibold text-gray-900 group-hover:text-orange-600 truncate transition">
                            <?php echo e($ev->judul); ?>

                        </div>
                        <div class="text-xs text-gray-400 mt-0.5">
                            📅 <?php echo e(\Carbon\Carbon::parse($ev->tanggal)->translatedFormat('d F Y')); ?>

                            <?php if($ev->lokasi): ?> · 📍 <?php echo e($ev->lokasi); ?> <?php endif; ?>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-orange-400 flex-shrink-0 transition"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="font-serif text-lg font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100">
                Ulasan
                <span class="text-sm font-normal text-gray-400 ml-2"><?php echo e($totalUlasan); ?> ulasan</span>
            </h3>

            <?php if(session('success')): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3 mb-4">
                ✅ <?php echo e(session('success')); ?>

            </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
            <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl px-4 py-3 mb-4">
                ⚠️ <?php echo e(session('error')); ?>

            </div>
            <?php endif; ?>

            <?php $__empty_1 = true; $__currentLoopData = $ulasan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="py-4 border-b border-gray-100 last:border-0">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center
                                text-sm font-bold text-green-800 flex-shrink-0">
                        <?php echo e(strtoupper(substr($item->user->name ?? 'U', 0, 1))); ?>

                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-semibold text-gray-900">
                                <?php echo e($item->user->name ?? 'Pengguna'); ?>

                            </span>
                            <span class="text-xs text-gray-400">
                                <?php echo e($item->created_at->translatedFormat('d M Y')); ?>

                            </span>
                        </div>
                        <div class="flex gap-0.5 mb-2">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <svg class="w-3.5 h-3.5 <?php echo e($i <= $item->rating ? 'text-amber-400' : 'text-gray-200'); ?>"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            <?php endfor; ?>
                        </div>
                        <?php if($item->komentar): ?>
                        <p class="text-sm text-gray-600 leading-relaxed"><?php echo e($item->komentar); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-10 text-gray-400">
                <div class="text-4xl mb-3">⭐</div>
                <p class="text-sm">Belum ada ulasan untuk trainer ini.</p>
            </div>
            <?php endif; ?>
        </div>

        
        <?php if(auth()->guard()->check()): ?>
            <?php if(!$sudahUlasan): ?>
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-serif text-lg font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100">
                    Tulis Ulasan
                </h3>
                <form action="<?php echo e(route('pelatihan.mentor.ulasan', $trainer->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                            Rating <span class="text-red-400">*</span>
                        </label>
                        <div class="flex gap-1">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                            <button type="button"
                                    data-value="<?php echo e($i); ?>"
                                    class="star-btn text-4xl text-gray-200 hover:text-amber-400
                                           transition-colors duration-100 focus:outline-none leading-none">
                                ★
                            </button>
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" name="rating" id="rating-input" value="">
                        <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                            Komentar
                        </label>
                        <textarea name="komentar" rows="3"
                            placeholder="Ceritakan pengalaman Anda bersama trainer ini..."
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                   text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-400
                                   resize-none bg-gray-50 focus:bg-white transition"><?php echo e(old('komentar')); ?></textarea>
                        <?php $__errorArgs = ['komentar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-xs text-red-500 mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold
                                   px-6 py-2.5 rounded-xl transition-colors">
                        Kirim Ulasan
                    </button>
                </form>
            </div>
            <?php else: ?>
            <div class="bg-green-50 border border-green-200 rounded-2xl p-5 text-center">
                <p class="text-sm text-green-700 font-semibold">
                    ✅ Anda sudah memberikan ulasan untuk trainer ini.
                </p>
            </div>
            <?php endif; ?>
        <?php else: ?>
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 text-center">
            <p class="text-sm text-gray-500 mb-3">Login untuk memberikan ulasan</p>
            <a href="<?php echo e(route('login')); ?>"
               class="inline-block bg-green-600 hover:bg-green-700 text-white text-sm
                      font-semibold px-6 py-2.5 rounded-xl transition-colors">
                Login Sekarang
            </a>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function setRating(val) {
    document.getElementById('rating-input').value = val;
    document.querySelectorAll('.star-btn').forEach(function(btn) {
        btn.style.color = parseInt(btn.dataset.value) <= val ? '#f59e0b' : '#e5e7eb';
    });
}

document.querySelectorAll('.star-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        setRating(parseInt(this.dataset.value));
    });
    btn.addEventListener('mouseenter', function() {
        var hovered = parseInt(this.dataset.value);
        document.querySelectorAll('.star-btn').forEach(function(b) {
            b.style.color = parseInt(b.dataset.value) <= hovered ? '#fbbf24' : '#e5e7eb';
        });
    });
    btn.addEventListener('mouseleave', function() {
        var current = parseInt(document.getElementById('rating-input').value) || 0;
        document.querySelectorAll('.star-btn').forEach(function(b) {
            b.style.color = parseInt(b.dataset.value) <= current ? '#f59e0b' : '#e5e7eb';
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\webkajiindonesia\resources\views/pages/pelatihan-pembimbing-detail.blade.php ENDPATH**/ ?>