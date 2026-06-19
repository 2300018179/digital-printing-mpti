<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Tambahkan pengecekan if (!Schema::hasColumn(...))
            if (!Schema::hasColumn('pesanans', 'status')) {
                $table->string('status')->default('Menunggu')->after('total');
            }
            if (!Schema::hasColumn('pesanans', 'bukti_transfer')) {
                $table->string('bukti_transfer')->nullable()->after('status');
            }
        });
    }

    public function down()
    {
        // Abaikan down() jika tidak ingin menghapus kolom
    }
};