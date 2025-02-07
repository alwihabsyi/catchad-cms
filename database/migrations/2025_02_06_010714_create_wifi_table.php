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
        Schema::create('wifi', function (Blueprint $table) {
            $table->string('bssid')->primary();
            $table->string('ssid')->nullable();
            $table->integer('frequency');
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
        Schema::table('wifi', function (Blueprint $table) {
            $table->dropForeign(['device_id']);
        });

        Schema::dropIfExists('wifi');
    }
};
