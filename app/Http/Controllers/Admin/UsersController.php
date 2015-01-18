<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminEditUserFormRequest;
use App\Users\UserRepositoryInterface;
use Input;

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
        // Capture any provided search criteria.
        //
        $criteria = Input::get('user', false);

        // Fetch a paginated listing of all users in the system.
        //
        $users = $criteria
               ? $this->userRepository->getPaginatedResourceListingByCriteria( $criteria )
               : $this->userRepository->getPaginatedResourceListing();

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
        // Fetch the user record from the database.
        //
        $user = $this->userRepository->findById( $id );

        // Redirect the user to the user's profile page.
        //
        return redirect()->to($user->present()->getProfileLink());
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
        $user = $this->userRepository->findByIdWithRoles( $id );

        // Capture the roles that are assigned to the user.
        //
        $assigned_role_ids = $user->roles->lists('id');

        // Show the page.
        //
        return routeView()->withUser( $user )->withAssignedRoleIds( $assigned_role_ids );
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
        $user = $this->userRepository->findByIdWithRoles( $id );

        // Update the record.
        //
        $this->userRepository->updateRecord( $user, $request->except('_token') );

        // Update the roles assigned to the user.
        //
        if ( $request->has('roles') )
        {
            // Attach role(s) to the user's account.
            //
            $this->userRepository->attachRoles( $user , $request->input('roles') );
        }

        // Restore the record if requested.
        //
        if ( $request->has('restore') )
        {
            // Restore the user record.
            //
            $this->userRepository->restoreRecord( $user );
        }

        // Delete the record if requested.
        //
        if ( $request->has('delete') )
        {
            // Restore the user record.
            //
            $this->userRepository->softDeleteRecord( $user );
        }

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
