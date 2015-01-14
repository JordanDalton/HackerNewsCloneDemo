<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function(Blueprint $table)
		{
			$table->increments('id');
            $table->timestamp('created_at');
            $table->timestamp('deleted_at')->nullable();
            $table->text('comment');
            $table->integer('parent_id')->nullable();
            $table->float('penalties')->unsigned()->default(0.25);
            $table->integer('post_id');
            $table->integer('user_id');
            $table->timestamp('updated_at')->nullable();
            $table->integer('votes')->unsigned()->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comments');
	}

}
