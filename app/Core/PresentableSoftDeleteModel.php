<?php namespace App\Core;

use Illuminate\Database\Eloquent\SoftDeletes;

class PresentableSoftDeleteModel extends PresentableModel {

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
} 