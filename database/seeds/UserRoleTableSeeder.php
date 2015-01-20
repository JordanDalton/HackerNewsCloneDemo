<?php

use App\Roles\RoleRepositoryInterface;
use App\Users\UserRepositoryInterface;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder {

    /**
     * Faker
     *
     * @var Faker\Factory
     */
    protected $faker;

    /**
     * Seed records ready for insertion into the database.
     *
     * @var array
     */
    protected $user_role = [ ];

    /**
     * The user repository implementation.
     *
     * @var App\Users\UserRepositoryInterface
     */
    private $userRepository;

    /**
     * This role repository implementation.
     *
     * @var App\Roles\RoleRepositoryInterface
     */
    private $roleRepository;

    /**
     * Create new UsersTableSeeder instance
     *
     * @param Faker                   $faker
     * @param UserRepositoryInterface $userRepository
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct( Faker $faker , UserRepositoryInterface $userRepository , RoleRepositoryInterface $roleRepository )
    {
        $this->faker          = $faker->create();
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate the seed record for the matching application environment.
        //
        switch ( App::environment() )
        {
            case 'local':
                $this->localRun();
                break;
        }

        // Now seed the database table with data.
        //
        DB::table( 'user_role' )->insert( $this->user_role );
    }

    /**
     * Create seed data for local environment.
     *
     * @return void
     */
    public function localRun()
    {
        // Obtain a list of available role ids.
        //
        $roleIds = $this->roleRepository->getIdList();

        // Obtain a list of available user ids.
        //
        $userIds = $this->userRepository->getIdList();

        // Count the number of user ids minus the admin account.
        //
        $userIdCountLessAdmin = count($userIds) - 1;

        // Create a standard administrator account role for the admin account (user #1).
        //
        $this->user_role[ ] = [
            'role_id' => 1 ,
            'user_id' => 1 ,
        ];

        // Generate random user accounts.
        //
        foreach ( range( 1 , $userIdCountLessAdmin ) as $index )
        {
            $role_id = $this->faker->numberBetween($min = 2, $max = count($roleIds));
            $user_id = $this->faker->unique()->numberBetween($min = 2, $max = count($userIds));

            if( $user_id == 2 ) $role_id = 3;

            $this->user_role[ ] = [
                'role_id' => $role_id,
                'user_id' => $user_id
            ];
        }
    }
} 