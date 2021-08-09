<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string("fullname", 100);
            $table->string('email', 50)->unique();
            $table->string('phone');
            $table->string('password', 70);
            $table->enum('speacility', ['Allergy and immunology', 'Urology', 'Ophthalmology', 'Obstetrics and gynecology', 'Anesthesiology', 'Dermatology', 'Diagnostic radiology', 'Family medicine', 'Pathology', 'Pediatrics']);
            $table->integer('years_of_experience');
            $table->integer("is_logged_in")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
