<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScbSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::exists('scb_settings'))
            {
        Schema::create('scb_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255)->unique();
            $table->text('value');
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
        Schema::dropIfExists('scb_settings');
    }
}
