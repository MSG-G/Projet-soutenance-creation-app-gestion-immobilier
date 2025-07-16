<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->text('message')->nullable()->after('bien_id');
            $table->string('nom')->nullable()->after('message');
            $table->string('email')->nullable()->after('nom');
            $table->string('telephone')->nullable()->after('email');
            $table->unsignedBigInteger('client_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['message', 'nom', 'email', 'telephone']);
        });
    }
};
