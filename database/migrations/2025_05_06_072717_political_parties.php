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
        Schema::create('political_parties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->string('party_name')->unique();
            $table->string('party_acronym')->unique();
            $table->string('registration_number')->unique();
            $table->string('president_name');
            $table->string('contact_phone')->nullable();
            $table->text('headquarters_address')->nullable();
            $table->integer('founded_year')->nullable();
            $table->string('certificate_url')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('slogan')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('president_photo_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
