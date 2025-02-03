<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rezerwacje', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id'); // ID usługodawcy
            $table->unsignedBigInteger('service_id'); // ID usługi
            $table->unsignedBigInteger('client_id');  // ID klienta
            $table->date('date');                     // Data wizyty
            $table->time('time');                     // Godzina wizyty
            $table->timestamps();

            // Klucze obce
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rezerwacje');
    }
};
