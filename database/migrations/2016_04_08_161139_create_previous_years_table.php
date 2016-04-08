<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreviousYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('previous_years', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('year_name');
            $table->integer('year_percentage');
            $table->decimal('mark');
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
        Schema::drop('previous_years');
    }
}
