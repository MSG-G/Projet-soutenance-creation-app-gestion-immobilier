<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('types_biens', function (Blueprint $table) {
            $table->string('nom')->after('id');
        });
    }

    public function down()
    {
        Schema::table('types_bien', function (Blueprint $table) {
            $table->dropColumn('nom');
        });
    }
};
