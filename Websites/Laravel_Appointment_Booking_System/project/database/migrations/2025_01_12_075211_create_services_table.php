<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('providerID')->constrained('users')->onDelete('cascade');
            //$table->unsignedBigInteger('providerID'); // Foreign key (usługodawca)
            $table->string('name'); // Nazwa usługi
            $table->integer('duration'); // Czas trwania w minutach
            $table->decimal('price', 8, 2); // Cena usługi
            $table->timestamps(); // Kolumny created_at i updated_at

            // Opcjonalnie: klucz obcy
            // $table->foreign('providerID')->references('id')->on('providers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
