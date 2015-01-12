<?php

use App\Comments\CommentRepositoryInterface;
use App\Posts\PostRepositoryInterface;
use App\Users\UserRepositoryInterface;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder {

    /**
     * The comment repository implementation.
     *
     * @var App\Comments\CommentRepositoryInterface
     */
    private $commentRepository;

    /**
     * Seed records ready for insertion into the database.
     *
     * @var array
     */
    protected $comments = [ ];

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
     * The use repository implementation.
     *
     * @var App\Users\UserRepositoryInterface
     */
    private $userRepository;

    /**
     * Create new CommentsTableSeeder instance
     *
     * @param CommentRepositoryInterface $commentRepository
     * @param Faker                      $faker
     * @param PostRepositoryInterface    $postRepository
     * @param UserRepositoryInterface    $userRepository
     */
    public function __construct( CommentRepositoryInterface $commentRepository , Faker $faker , PostRepositoryInterface $postRepository , UserRepositoryInterface $userRepository )
    {
        $this->commentRepository = $commentRepository;
        $this->faker             = $faker->create();
        $this->postRepository    = $postRepository;
        $this->userRepository    = $userRepository;
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
        DB::table( $this->commentRepository->getTableName() )->insert( $this->comments );
    }

    /**
     * Return a list of post ids.
     *
     * @return array
     */
    public function getPostIdList()
    {
        return $this->postRepository->getIdList();
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
        // Obtain a list of post ids.
        //
        $post_ids = $this->getPostIdList();

        // Obtain a list of all user ids.
        //
        $user_ids = $this->getUserIdList();

        // Generate random comment accounts.
        //
        foreach ( range( 1 , 20 ) as $index )
        {
            $this->comments[ ] = [
                'created_at' => new DateTime ,
                'deleted_at' => null,
                'comment'    => $this->faker->sentence(),
                'post_id'    => $this->faker->randomElement( $user_ids ) ,
                'user_id'    => $this->faker->randomElement( $user_ids ) ,
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