<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique(); // Powiązanie z tabelą users
            $table->text('description')->nullable(); // Opis firmy
            $table->string('address')->nullable(); // Adres firmy
            $table->string('phone')->nullable(); // Numer telefonu
            $table->string('email')->nullable(); // Email firmy
            $table->timestamps();

            // Klucz obcy
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }

};
