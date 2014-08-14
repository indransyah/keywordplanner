<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubcriteriaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subcriteria', function(Blueprint $table)
		{
			$table->increments('subcriterion_id');
			$table->string('subcriterion',20);
			$table->longText('description');
			$table->string('field',20);
			$table->string('conditional',50);
			$table->decimal('tpv',5,2);
			$table->decimal('rating',5,2);
			$table->integer('criterion_id')->unsigned();
			$table->foreign('criterion_id')->references('criterion_id')->on('criteria')->onDelete('cascade')->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subcriteria');
	}

}
