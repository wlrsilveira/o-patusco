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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('animal_name', 255);
            $table->integer('animal_age');
            $table->text('symptoms');
            $table->date('date');
            $table->enum('period', ['morning', 'afternoon']);
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('animal_type_id');
            $table->foreign('doctor_id')->references('id')
                ->on('users');
            $table->foreign('animal_type_id')->references('id')
                ->on('animal_types');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
