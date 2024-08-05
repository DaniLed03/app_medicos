<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('citas', function (Blueprint $table) {
            $table->enum('status', ['Por comenzar', 'En proceso', 'Finalizada'])->default('Por comenzar')->after('activo');
        });
    }

    public function down(): void {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
