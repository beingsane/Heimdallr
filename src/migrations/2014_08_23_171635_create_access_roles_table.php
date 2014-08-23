<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('access_roles', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('ident')->index();
            $table->string('description')->nullable();
            $table->integer('level', false);
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
		Schema::drop('access_roles');
	}

}
