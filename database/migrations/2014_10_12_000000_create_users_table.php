<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
            $table->increments('id');
            $table->timestamp('created_at');
            $table->timestamp('deleted_at')->nullable();
			$table->string('email')->unique();
			$table->boolean('email_authenticated')->default(0);
			$table->timestamp('email_authenticated_at')->nullable();
			$table->string('email_authentication_code', 60)->unique();
			$table->string('password', 60);
            $table->string('remember_token', 100)->nullable();
            $table->string('username')->unique();
			$table->timestamp('updated_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
