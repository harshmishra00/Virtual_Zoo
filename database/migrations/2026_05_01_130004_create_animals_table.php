<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('species_id')->constrained()->onDelete('cascade');
            $table->foreignId('enclosure_id')->constrained()->onDelete('cascade');
            $table->integer('age')->nullable();
            $table->enum('gender', ['male', 'female', 'unknown'])->default('unknown');
            $table->decimal('weight_kg', 8, 2)->nullable();
            $table->decimal('height_cm', 8, 2)->nullable();
            $table->string('diet')->nullable();
            $table->enum('conservation_status', [
                'Least Concern',
                'Near Threatened',
                'Vulnerable',
                'Endangered',
                'Critically Endangered',
                'Extinct in Wild',
            ])->default('Least Concern');
            $table->text('description')->nullable();
            $table->text('fun_fact')->nullable();
            $table->date('arrival_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('thumbnail')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
