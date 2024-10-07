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
        Schema::create('remessas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('governmentId');
            $table->string('email');
            $table->string('debtAmount');
            $table->string('debtDueDate');
            $table->string('debtID');
            $table->boolean('isBoletoMaked')->default(false);
            $table->boolean('isEmailSent')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remessas');
    }
};
