<?php

use App\Users\UserRepositoryInterface;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Faker
     *
     * @var Faker\Factory
     */
    protected $faker;

    /**
     * The user repository implementation.
     *
     * @var App\Users\UserRepositoryInterface
     */
    private $userRepository;

    /**
     * Seed records ready for insertion into the database.
     *
     * @var array
     */
    protected $users = [ ];

    /**
     * Create new UsersTableSeeder instance
     *
     * @param UserRepositoryInterface $userRepository
     * @param Faker                   $faker
     */
    public function __construct( UserRepositoryInterface $userRepository , Faker $faker )
    {
        $this->userRepository = $userRepository;
        $this->faker          = $faker->create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a administrator account.
        //
        $this->generateAdministratorAccount();

        // Generate the seed record for the matching application environment.
        //
        switch ( App::environment() )
        {
            case 'local':
                $this->localRun();
                break;
            case 'production':
                $this->productionRun();
                break;
        }

        // Now seed the database table with data.
        //
        DB::table( $this->userRepository->getTableName() )->insert( $this->users );
    }

    /**
     * Create an administrator account that will later be placed in the database.
     *
     * @return void
     */
    public function generateAdministratorAccount()
    {
        // Create a standard administrator account.
        //
        $this->users[ ] = [
            'active'                    => true,
            'created_at'                => new DateTime ,
            'email'                     => "administrator@example.com" ,
            'email_authenticated'       => true ,
            'email_authenticated_at'    => new DateTime,
            'email_authentication_code' => $this->userRepository->getModel()->generateUniqueEmailAuthenticationCode() ,
            'password'                  => Hash::make( 'password' ) ,
            'username'                  => 'Administrator'
        ];
    }

    /**
     * Create seed data for local environment.
     *
     * @return void
     */
    public function localRun()
    {
        // Generate random user accounts.
        //
        foreach ( range( 1 , 20 ) as $index )
        {
            $email_authenticated = $this->faker->boolean;

            $this->users[ ] = [
                'active'                    => $email_authenticated ? true : false,
                'created_at'                => new DateTime ,
                'email'                     => "user{$index}@me.com" ,
                'email_authenticated'       => $email_authenticated ,
                'email_authenticated_at'    => $email_authenticated ? new DateTime : null,
                'email_authentication_code' => $this->userRepository->getModel()->generateUniqueEmailAuthenticationCode() ,
                'password'                  => Hash::make( 'password' ) ,
                'username'                  => "user{$index}" ,
            ];
        }
    }

    /**
     * Create seed data for production environment.
     *
     * @return void
     */
    public function productionRun()
    {
        //
    }
} 