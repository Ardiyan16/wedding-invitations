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
        Schema::create('bride_datas', function (Blueprint $table) {
            $table->id();
            $table->string('name_invitation');
            $table->string('slug');
            $table->string('name_groom');
            $table->string('name_bride');
            $table->string('link_instagram_man');
            $table->string('link_instagram_woman');
            $table->date('wedding_date');
            $table->time('wedding_time');
            $table->date('akad_date');
            $table->time('akad_time');
            $table->text('quote');
            $table->string('quote_resource');
            $table->string('son_to');
            $table->string('man_name_parents1');
            $table->string('woman_name_parents1');
            $table->string('daughter_to');
            $table->string('man_name_parents2');
            $table->string('woman_name_parents2');
            $table->string('address_akad');
            $table->string('link_address_akad');
            $table->string('address_wedding');
            $table->string('link_address_wedding');
            $table->string('second_address')->nullable();
            $table->string('link_second_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bride_datas');
    }
};
