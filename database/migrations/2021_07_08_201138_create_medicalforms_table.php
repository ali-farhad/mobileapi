<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicalforms', function (Blueprint $table) {
            $table->id();
            $table->integer("patient_id")->unsigned()->unique();
            $table->date("dob", 50)->nullable();
            $table->boolean('anemia')->default(0);
            $table->boolean('arthritis')->default(0);
            $table->boolean('disease')->default(0);
            $table->boolean('clotting_disorder')->default(0);
            $table->boolean('ardinal_gland_surgey')->default(0);
            $table->boolean('appendectomy')->default(0);
            $table->boolean('bariatric_surgery')->default(0);
            $table->boolean('bladder_surgery')->default(0);
            $table->boolean('cesarean_section')->default(0);
            $table->boolean('cholecystectomy')->default(0);
            $table->longText('medications')->nullable();
            $table->longText('allergies')->nullable();
            $table->boolean('fm_cancer')->default(0);
            $table->boolean('fm_anemia')->default(0);
            $table->boolean('fm_diabetes')->default(0);
            $table->boolean('fm_blood_clots')->default(0);
            $table->boolean('fm_heart_disease')->default(0);
            $table->boolean('fm_stroke')->default(0);
            $table->boolean('fm_high_blood_pressure')->default(0);
            $table->boolean('fm_hepatitis')->default(0);
         


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
        Schema::dropIfExists('medicalforms');
    }
}
