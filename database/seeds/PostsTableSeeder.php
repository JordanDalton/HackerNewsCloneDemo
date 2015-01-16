<?php

use App\Posts\PostRepositoryInterface;
use App\Users\UserRepositoryInterface;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder {

    /**
     * Faker
     *
     * @var Faker\Factory
     */
    protected $faker;

    /**
     * The post repository implementation.
     *
     * @var App\Posts\PostRepositoryInterface
     */
    private $postRepository;

    /**
     * Seed records ready for insertion into the database.
     *
     * @var array
     */
    protected $posts = [ ];

    /**
     * The user repository implementation.
     *
     * @var App\Users\UserRepositoryInterface
     */
    private $userRepository;

    /**
     * Create new PostsTableSeeder instance
     *
     * @param Faker                   $faker
     * @param PostRepositoryInterface $postRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct( Faker $faker , PostRepositoryInterface $postRepository , UserRepositoryInterface $userRepository )
    {
        $this->faker          = $faker->create();
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
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
            case 'production':
                $this->productionRun();
                break;
        }

        // Now seed the database table with data.
        //
        DB::table( $this->postRepository->getTableName() )->insert( $this->posts );
    }

    /**
     * Return the list of user ids.
     *
     * @return array
     */
    public function getUserIdList()
    {
        return $this->userRepository->getIdList();
    }

    /**
     * Create seed data for local environment.
     *
     * @return void
     */
    public function localRun()
    {
        // Obtain a list of all of the user ids.
        //
        $user_ids = $this->getUserIdList();

        // Generate random post accounts.
        //
        foreach ( range( 1 , 20 ) as $index )
        {
            $ask = $this->faker->boolean();

            $this->posts[ ] = [
                'ask'        => $ask,
                'created_at' => $this->faker->dateTimeBetween($startDate = '-1 day', $endDate = 'now'),
                'show'       => $ask ? false : $this->faker->boolean(),
                'text'       => $this->faker->realText($maxNbChars = 200, $indexSize = 2) ,
                'title'      => $this->faker->realText($maxNbChars = 25, $indexSize = 2) ,
                'url'        => $ask ? null : $this->faker->url ,
                'user_id'    => $this->faker->randomElement( $user_ids ),
                'votes'      => $this->faker->randomDigitNotNull
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