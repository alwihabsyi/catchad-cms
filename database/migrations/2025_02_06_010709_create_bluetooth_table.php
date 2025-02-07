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
        Schema::create('bluetooth', function (Blueprint $table) {
            $table->string('address')->primary();
            $table->string('name')->nullable();
            $table->string('manufacturer');
            $table->integer('rssi');
            $table->string('device_id');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bluetooth', function (Blueprint $table) {
            $table->dropForeign(['device_id']);
        });

        Schema::dropIfExists('bluetooth');
    }
};
