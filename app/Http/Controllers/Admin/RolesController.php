<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCreateRoleFormRequest;
use App\Http\Requests\AdminEditRoleFormRequest;
use App\Roles\RoleRepositoryInterface;
use App\Users\UserRepositoryInterface;
use Input;

class RolesController extends Controller {

    /**
     * The role repository implementation.
     *
     * @var \RoleRepositoryInterface
     */
    private $roleRepository;

    /**
     * Create new RolesController instance.
     *
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct( RoleRepositoryInterface $roleRepository )
    {
        $this->roleRepository = $roleRepository;
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
        $criteria = Input::get( 'criteria' , false );

        // Fetch a paginated listing of all roles in the system.
        //
        $roles = $criteria
            ? $this->roleRepository->getPaginatedResourceListingByCriteria( $criteria )
            : $this->roleRepository->getPaginatedResourceListing();

        // Show the page.
        //
        return routeView()->withRoles( $roles );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Create new role instance.
        //
        $role = $this->roleRepository->createNewInstance();

        // Show the page.
        //
        return routeView()->withRole( $role );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\AdminCreateRoleFormRequest $request
     *
     * @return Response
     */
    public function store( AdminCreateRoleFormRequest $request )
    {
        // Create a new role record.
        //
        $this->roleRepository->createRecord( $request->only( 'core' , 'name' ) );

        // Send the user back to the list page and flash a message that states
        // that the role record was successfully created.
        //
        return redirect()->route( 'admin.roles.index' )->withRoleCreatedSuccessfully( true );
    }

    /**
     * Display the specified resource.
     *
     * @param  int                    $id
     * @param UserRepositoryInterface $userRepository
     *
     * @return Response
     */
    public function show( $id , UserRepositoryInterface $userRepository )
    {
        // Capture any supplied search criteria.
        //
        $criteria = Input::get( 'user', [] );

        // Fetch the role with all assigned users.
        //
        $role = $this->roleRepository->findById( $id );

        // Fetch the users assigned to the role.
        //
        $users = $userRepository->findWithinRoleByCriteria( $role , $criteria );

        // Show the page.
        //
        return routeView()->withRole( $role )->withUsers( $users );
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
        // Fetch the role account from the database.
        //
        $role = $this->roleRepository->findNonCoreRoleById( $id );

        // Show the page.
        //
        return routeView()->withRole( $role );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int                     $id
     * @param AdminEditRoleFormRequest $request
     *
     * @return Response
     */
    public function update( $id , AdminEditRoleFormRequest $request )
    {
        // Fetch the role account from the database.
        //
        $role = $this->roleRepository->findNonCoreRoleById( $id );

        // Update the record.
        //
        $this->roleRepository->updateRecord( $role , $request->except( '_token' ) );

        // Restore the record if requested.
        //
        if ( $request->has( 'restore' ) )
        {
            // Restore the role record.
            //
            $this->roleRepository->restoreRecord( $role );
        }

        // Delete the record if requested.
        //
        if ( $request->has( 'delete' ) )
        {
            // Restore the role record.
            //
            $this->roleRepository->softDeleteRecord( $role );
        }

        // If the role is now a core role we will redirect the user to the
        // role list page instead.
        //
        if ( $role->isCore() )
        {
            return redirect()->route( 'admin.roles.index' )->withRoleUpdatedSuccessfully( true );
        }

        // Send the role back to the page and flash a message to them that
        // states the role record was successfully updated.
        //
        return redirect()->back()->withRoleUpdatedSuccessfully( true );
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