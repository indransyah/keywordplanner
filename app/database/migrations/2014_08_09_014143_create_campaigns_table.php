<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('campaigns', function(Blueprint $table)
		{
			$table->increments('campaign_id');
			$table->string('campaign',100);
			$table->string('csv',50);
			$table->enum('status', array('up to date', 'out of date'));
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('campaigns');
	}

}
