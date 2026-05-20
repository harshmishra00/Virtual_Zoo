<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enclosures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('habitat_id')->constrained()->onDelete('cascade');
            $table->integer('capacity');
            $table->string('location_on_map')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enclosures');
    }
};
