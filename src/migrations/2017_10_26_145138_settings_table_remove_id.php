<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SettingsTableRemoveId extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('scb_settings'))
		{
			Schema::table('scb_settings', function (Blueprint $table)
			{
				try
				{
					DB::statement("ALTER TABLE `scb_settings` DROP `id`;");
					DB::statement("AALTER TABLE `scb_settings` ADD PRIMARY KEY(`name`);");
				}
				catch (\Exception $e)
				{
				}
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
	}
}
