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
        Schema::table('adoptions', function (Blueprint $table) {
            if (!Schema::hasColumn('adoptions', 'adopter_name')) {
                $table->string('adopter_name')->nullable();
            }
            if (!Schema::hasColumn('adoptions', 'adopter_email')) {
                $table->string('adopter_email')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adoptions', function (Blueprint $table) {
            $table->dropColumn(['adopter_name', 'adopter_email']);
        });
    }
};
