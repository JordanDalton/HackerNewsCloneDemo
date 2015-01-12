<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
            $table->increments('id');
            $table->timestamp('created_at');
            $table->timestamp('deleted_at')->nullable();
            $table->text('text')->nullable();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->integer('user_id');
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
		Schema::drop('posts');
	}

}
