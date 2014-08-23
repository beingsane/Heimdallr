<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessResourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('access_resources', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('ident')->index();
            $table->string('description')->nullable();
            $table->string('route')->index();
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
		Schema::drop('access_resources');
	}

}
