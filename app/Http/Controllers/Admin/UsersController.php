<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminEditUserFormRequest;
use App\Users\UserRepositoryInterface;

class UsersController extends Controller {

    /**
     * The user repository implementation.
     *
     * @var \UserRepositoryInterface
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Fetch a paginated listing of all users in the system.
        //
        $users = $this->userRepository->getPaginatedResourceListing();

        // Show the page.
        //
        return routeView()->withUsers( $users );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Show the page.
        //
        return routeView();
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
        //
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
        // Fetch the user account from the database.
        //
        $user = $this->userRepository->findById( $id );

        // Show the page.
        //
        return routeView()->withUser( $user );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int                     $id
     * @param AdminEditUserFormRequest $request
     *
     * @return Response
     */
    public function update( $id , AdminEditUserFormRequest $request )
    {
        // Fetch the user account from the database.
        //
        $user = $this->userRepository->findById( $id );

        // Update the record.
        //
        $this->userRepository->updateRecord( $user, $request->except('_token') );

        // Send the user back to the page and flash a message to them that
        // states the user record was successfully updated.
        //
        return redirect()->back()->withUserUpdatedSuccessfully(true);
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
