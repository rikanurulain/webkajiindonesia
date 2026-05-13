<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            // ── Kolom untuk KURIKULUM ──
            $table->unsignedInteger('jumlah_materi')->nullable()->after('konten_kurikulum');
            $table->decimal('total_jam', 5, 1)->nullable()->after('jumlah_materi');
            $table->unsignedInteger('jumlah_sesi')->nullable()->after('total_jam');
            $table->boolean('sertifikat')->default(false)->after('jumlah_sesi');

            // ── Kolom untuk MATERI ──
            $table->string('link_video')->nullable()->after('konten_materi');
            $table->string('file_materi')->nullable()->after('link_video');
            $table->unsignedInteger('durasi')->nullable()->after('file_materi'); // dalam menit
            $table->unsignedInteger('urutan')->nullable()->after('durasi');
            $table->unsignedBigInteger('kurikulum_id')->nullable()->after('urutan');

            $table->foreign('kurikulum_id')
                  ->references('id')
                  ->on('programs')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropForeign(['kurikulum_id']);
            $table->dropColumn([
                'jumlah_materi', 'total_jam', 'jumlah_sesi', 'sertifikat',
                'link_video', 'file_materi', 'durasi', 'urutan', 'kurikulum_id',
            ]);
        });
    }
};