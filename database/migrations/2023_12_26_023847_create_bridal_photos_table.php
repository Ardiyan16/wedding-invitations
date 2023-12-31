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
        Schema::create('bridal_photos', function (Blueprint $table) {
            $table->id();
            $table->integer('bride_id');
            $table->string('photo_group');
            $table->string('photo_man');
            $table->string('photo_woman');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bridal_photos');
    }
};
