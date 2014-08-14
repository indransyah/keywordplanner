<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcriteriaJudgmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subcriteria_judgments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('subcriterion_id')->unsigned();
			$table->decimal('judgment',5,2);
			$table->integer('compared_subcriterion_id')->unsigned();
			// $table->integer('criterion_id')->unsigned();
			$table->foreign('subcriterion_id')->references('subcriterion_id')->on('subcriteria')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('compared_subcriterion_id')->references('subcriterion_id')->on('subcriteria')->onDelete('cascade')->onUpdate('cascade');
			// $table->foreign('criterion_id')->references('criterion_id')->on('criteria')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subcriteria_judgments');
	}

}
