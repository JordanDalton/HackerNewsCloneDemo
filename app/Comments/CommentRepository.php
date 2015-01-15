<?php namespace App\Comments;

use App\Core\RepositoryTrait;

class CommentRepository implements CommentRepositoryInterface {

    use RepositoryTrait;

    /**
     * The comment model.
     *
     * @var Comment
     */
    private $model;

    /**
     * Create new CommentRepository instance.
     *
     * @param Comment $model
     */
    public function __construct( Comment $model )
    {
        $this->model = $model;
    }

    /**
     * Locate comment record by it's ID number.
     *
     * @param $id
     *
     * @return mixed
     */
    public function findById( $id )
    {
        return $this->findByIdWith( $id );
    }

    /**
     * Fetch comment record by it's ID number and include related data as needed.
     *
     * @param int   $id
     * @param array $with
     * @param array $columns
     *
     * @return mixed
     */
    public function findByIdWith( $id , $with = [ ] , $columns = [ '*' ] )
    {
        return $this->getModel()->with( $with )->findOrFail( $id , $columns );
    }

    /**
     * Fetch comment record by it's ID number and include related replies.
     *
     * @param $id
     *
     * @return mixed
     */
    public function findByIdWithReplies( $id )
    {
        return $this->findByIdWith( $id, ['post', 'replies', 'replies.user', 'user'] );
    }

    /**
     * Fetch the latest records and return them in paginated form.
     *
     * @param int   $per_page The number of record to show on each page.
     * @param array $columns  The columns that we want returned.
     *
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedNewestWithReplies( $per_page = 15 , $columns = [ '*' ] )
    {
        return $this->getModel()->with(['post', 'replies', 'user'])->latest()->paginate( $per_page, $columns );
    }
} 