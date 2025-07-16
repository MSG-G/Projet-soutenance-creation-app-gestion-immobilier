<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biens', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->decimal('prix', 10, 2);
            $table->integer('surface');
            $table->string('adresse');
            $table->enum('statut', ['disponible', 'vendu', 'loue'])->default('disponible');
            $table->foreignId('proprietaire_id')->constrained()->onDelete('cascade');
            $table->foreignId('ville_id')->constrained()->onDelete('cascade');
            
            $table->foreignId('type_bien_id')->references('id')->on('types_biens')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biens');
    }
};