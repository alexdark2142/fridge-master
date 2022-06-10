<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (!Schema::hasTable('freezing_rooms')) {
            Schema::create('freezing_rooms', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->unsignedInteger('location_id');
                $table->smallInteger('temperature');
                $table->unsignedSmallInteger('total_blocks');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        if (Schema::hasTable('freezing_rooms')) {
            Schema::dropIfExists('freezing_rooms');
        }
    }
};
