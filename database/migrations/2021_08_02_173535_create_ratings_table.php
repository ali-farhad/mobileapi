<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->longText("comment");
            $table->unsignedBigInteger("doctor_id");
            $table->unsignedBigInteger("user_id");
            $table->text("label");
            $table->decimal('neg', 18, 17);
            $table->decimal('pos', 18, 17);
            $table->decimal('neutral', 18, 17);
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
        Schema::dropIfExists('ratings');
    }
}
