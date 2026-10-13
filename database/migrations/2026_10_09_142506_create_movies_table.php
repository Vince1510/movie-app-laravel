<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // movies tabel aanmaken in database

    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();

            //string wordt onder water een varchar in de database
            $table->string('tmdb_id')->unique();

            $table->string('title');

            $table->text('overview')->nullable();

            $table->string('poster_path')->nullable();

            $table->string('genre')->nullable();

            $table->date('release_date')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};