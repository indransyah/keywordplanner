<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriteriaJudgmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('criteria_judgments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('criterion_id')->unsigned();
			$table->decimal('judgment',5,2);
			$table->integer('compared_criterion_id')->unsigned();
			$table->foreign('criterion_id')->references('criterion_id')->on('criteria')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('compared_criterion_id')->references('criterion_id')->on('criteria')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('criteria_judgments');
	}

}
