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
        Schema::create('operator_services', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class,'operator_id');
            $table->foreignIdFor(\App\Models\Service::class,'service_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operator_services');
    }
};
