<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Voer de migratie uit: maakt de koppeltabel 'movie_user' aan.
     */
    public function up(): void
    {
        Schema::create('movie_user', function (Blueprint $table) {
            $table->id();

            // Relaties met de 'users' en 'movies' tabellen
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('movie_id')->constrained()->cascadeOnDelete();

            // Voorkomt dat dezelfde film dubbel wordt opgeslagen bij één gebruiker
            $table->unique(['user_id', 'movie_id']);

            $table->timestamps();
        });
    }

    /**
     * Draai de migratie terug.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_user');
    }
};