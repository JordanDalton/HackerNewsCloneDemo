<?php namespace App\Http\Controllers;

class HomeController extends Controller {

    /**
     * Features List
     *
     * @var array
     */
    public $features = [
        'backend'  => [],
        'frontend' => [],
    ];

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
        $this->middleware( 'auth' , [ 'except' => ['features'] ] );
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}

    /**
     * Features Page
     *
     * @resturn Response
     */
    public function features()
    {
        // Compile feature list.
        //
        $this->compileFeatureList();

        // Show the page.
        //
        return routeView()->withFeatures( $this->getFeatureList() );
    }

    public function compileFeatureList()
    {
        $this->setFeature('Powered by Laravel 5', 'Laravel is the most modern framework in the history of PHP.', 'backend');
        $this->setFeature('Clean, Scalable Code', 'The source code is well commented and designed to scale.', 'backend');
        $this->setFeature('User Management', 'Edit, update and delete user accounts.', 'backend');
        $this->setFeature('User Level Assignments', 'Assign users as administrators, moderators, general users, or banned users.', 'backend');
        $this->setFeature('Role Management', 'Create, edit, update, and delete role types.', 'backend');
        $this->setFeature('Posts Management', 'Edit and delete posts made on the site.', 'backend');
        $this->setFeature('Comments Management', 'Edit and delete comments made on the site.', 'backend');
        $this->setFeature('Votes Management', 'Delete votes made on the site.', 'backend');

        $this->setFeature('Designed with Bootstrap', 'The frontend is designed with Twitter Bootstrap. Little CSS overrides have been made.');
        $this->setFeature('Ranking Algorithm', 'We use same ranking algorithm as Hacker News.');
        $this->setFeature('Sharing', 'Share your link with the community.');
        $this->setFeature('Ask', 'Ask a question to the community.');
        $this->setFeature('Commenting', 'Comment on any link or comment posted.');
        $this->setFeature('Voting', 'Vote up a post or comment that you like.');
        $this->setFeature('Karma', 'Increase your karma ranking as you post or make comments.');
        $this->setFeature('Login', 'Log into your account using email and password.');
        $this->setFeature('Registration', 'Sign up using username, email, and password.');
        $this->setFeature('Password Reset', 'Easily request your password to be reset.');
    }

    public function getFeatureList()
    {
        return $this->features;
    }

    public function setFeature( $label, $description, $frontend_or_backend = 'frontend' )
    {
        $this->features[$frontend_or_backend][] = [
            'label' => $label,
            'description' => $description
        ];
    }
}
