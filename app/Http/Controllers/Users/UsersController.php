<?php namespace App\Http\Controllers\Users;

use App\Http\Controllers\BaseController;
use App\Http\Requests;
use App\Users\UserRepositoryInterface;

class UsersController extends BaseController {

    /**
     * @var \App\Users\UserRepositoryInterface
     */
    private $userRepository;

    /**
     * Create new UsersController instance.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct( UserRepositoryInterface $userRepository )
    {
        $this->userRepository = $userRepository;

        parent::__construct();
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update( $id )
    {
        //
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
