<?php namespace App\Http\Controllers\Users;

use App\Exceptions\NotAllowedException;
use App\Http\Requests;
use App\Http\Requests\EditUserFormRequest;
use App\Users\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use App;

class UsersController extends Controller {

    /**
     * The user repository implementation.
     *
     * @var \App\Users\UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create new UsersController instance.
     *
     * @param UserRepositoryInterface $userRepository
     * @param Request                 $request
     */
    public function __construct( UserRepositoryInterface $userRepository , Request $request )
    {
        $this->userRepository = $userRepository;
        $this->request        = $request;

        // Require the user to be logged with the show method being the only exception
        //
        $this->middleware(
            'auth' , [
            'except' => [
                'show' ,
            ]
        ] );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show( $id )
    {
        // Fetch the user record from the database.
        //
        $user = $this->userRepository->findByUsername( $id );

        // Show the page.
        //
        return routeView()->withUser( $user );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit( $id )
    {
        // Fetch the user record from the database.
        //
        $user = $this->userRepository->findByUsername( $id );

        // Check if the users trying to access this page is NOT the account holder.
        //
        if ( $user->isNotAccountHolder() )
        {
            return App::abort('403', 'Unauthorized action.');
        }

        // Show the page.
        //
        return routeView()->withUser( $user );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int                $id
     * @param EditUserFormRequest $request
     *
     * @return Response
     */
    public function update( $id , EditUserFormRequest $request )
    {
        // Fetch the user record from the database.
        //
        $user = $this->userRepository->simplyFindByUsername( $id );

        // Update the user record.
        //
        $this->userRepository->updateRecord( $user, $request->only('username', 'email', 'about', 'password') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy( $id )
    {
        //
    }
}
