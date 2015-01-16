<?php

use App\Roles\RoleRepositoryInterface;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {

    /**
     * The role repository implementation.
     *
     * @var App\Roles\RoleRepositoryInterface
     */
    private $roleRepository;

    /**
     * Seed records ready for insertion into the database.
     *
     * @var array
     */
    protected $roles = [];

    /**
     * Create new RolesTableSeeder instance
     *
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct( RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define a list of roles we will need to create.
        //
        $roles = [
            'Administrators',
            'Moderators',
            'Users',
            'Banned'
        ];

        // Generate the seed record for the matching application environment.
        //
        foreach( $roles as $role )
        {
            $this->roles[] = [
                'name'       => $role,
                'created_at' => new DateTime
            ];
        }

        // Now seed the database table with data.
        //
        DB::table( $this->roleRepository->getTableName() )->insert( $this->roles );
    }

} 