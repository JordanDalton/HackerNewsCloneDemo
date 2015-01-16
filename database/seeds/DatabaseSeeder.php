<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

    /**
     * Define a list of tables that will need to be truncated.
     *
     * @var array
     */
    protected $tables = [
        'roles',
        'users',
        'user_role',
        'posts',
        'comments',
    ];

    /**
     * List of seeder classes that will need to be called.
     *
     * @var array
     */
    protected $seeders = [
        'RolesTableSeeder',
        'UsersTableSeeder',
        'UserRoleTableSeeder',
        'PostsTableSeeder',
        'CommentsTableSeeder',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->truncateTables();
        $this->callSedderClasses();
    }

    /**
     * Truncate Tables
     *
     * @return Void
     */
    public function truncateTables()
    {
        foreach( $this->tables as $table )
        {
            DB::table($table)->truncate();
        }
    }

    /**
     * Call Seeder Class
     *
     * @return Void
     */
    public function callSedderClasses()
    {
        foreach( $this->seeders as $seeder )
        {
            $this->call( $seeder );
        }
    }
}