<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScbSettingsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('scb_settings'))
		{
			Schema::create('scb_settings', function (Blueprint $table)
			{
				$table->increments('id');
				$table->string('name', 255)->unique();
				$table->text('value');
				$table->timestamps();
				$table->timestamp('expires_at')->nullable();
			});
		}
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
