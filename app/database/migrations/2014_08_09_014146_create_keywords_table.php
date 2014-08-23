<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKeywordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('keywords', function(Blueprint $table)
		{
			$table->increments('keyword_id');
			$table->string('keyword',100);
			$table->integer('search');
			$table->decimal('competition',5,2);
			$table->decimal('bid',5,2);
			// $table->string('csv',50);
			$table->integer('word');
			$table->decimal('score',5,2);
			$table->integer('campaign_id')->unsigned();
			$table->foreign('campaign_id')->references('campaign_id')->on('campaigns')->onDelete('cascade')->onUpdate('cascade');
			/* Old fields
			$table->increments('keyword_id');
			$table->string('group',20);
			$table->string('keyword',100);
			$table->string('currency',10);
			$table->integer('search');
			$table->decimal('competition',5,2);
			$table->decimal('bid',5,2);
			$table->decimal('impression',5,2);
			$table->string('account',1);
			$table->string('plan',1);
			$table->string('extract',1);
			$table->integer('word');
			$table->string('csv',50);
			*/
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('keywords');
	}

}
