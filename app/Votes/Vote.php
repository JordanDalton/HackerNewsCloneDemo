<?php namespace App\Votes;

use App\Core\PresentableSoftDeleteModel;
use App\Users\User;

class Vote extends PresentableSoftDeleteModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'votes';

    /**
     * Define a list of fields which we will ignore values of zero (0).
     *
     * @var array
     */
    protected $fields_to_ignore_zeros = ['user_id'];

    /**
     * Define which fields we will allowed to be searched.
     *
     * @var array
     */
    protected $searchable_fields = ['voteable_id', 'voteable_type', 'user_id'];

    /**
     * Query scope that will fetch records that fall within
     * a provided search criteria.
     *
     * @param $query
     * @param array   $search_parameters
     *
     * @return $this
     */
    public function scopeCriteria( $query, $search_parameters )
    {
        // Define a list of allowable search fields.
        //
        $search_parameters = $this->searchableFields( $search_parameters );

        return $query->where( function( $query ) use( $search_parameters )
        {
            // Drop any array that have blank values.
            //
            $search_parameters = dropBlankArrayValues($search_parameters);

            // Iterate through the list of $likeField and generate
            // a like statement for each.
            //
            foreach( $search_parameters as $field => $search_value )
            {
                // Ignore fields with 0 as the value.
                //
                if( in_array($field, $this->fields_to_ignore_zeros) && $search_value == 0) continue;

                $query->orWhere($field, 'like', "%$search_value%");
            }
        });
    }

    /**
     * Return a list of user fields that are allowed to be searched upon.
     *
     * @param array $requested_fields
     *
     * @return array
     */
    public function searchableFields( $requested_fields = [] )
    {
        // Ignore any fields that we are not allowing to be searched.
        //
        return array_only($requested_fields, $this->searchable_fields);
    }

    /**
     * Return the user that cast the vote
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo( User::class );
    }

    /**
     * Polymorphic target for submitting votes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function voteable()
    {
        return $this->morphTo();
    }
} 