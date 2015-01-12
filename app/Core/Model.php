<?php namespace App\Core;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Str;

class Model extends EloquentModel {

    /**
     * Generate a unique string for a given column
     *
     * @param string $field_name The name of the field we want to work with.
     * @param int    $length     How many characters do you want?
     *
     * @return string
     */
    public function generateUnique( $field_name , $length = 60 )
    {
        // Generate a random 60 character string.
        //
        $string = Str::random( 60 );

        /*
         * We will make up to 20 attempts to generate a unique string.
         */
        foreach ( range( 1 , 20 ) as $attempt )
        {
            // Check if the string is already being used.
            //
            $inUse = $this->where( $field_name , '=' , $string )->count();

            // If the string is not being used then we we will use it.
            //
            if ( ! $inUse ) break;

            // Otherwise we will need to generate a new string to try.
            //
            else $string = Str::random( 60 );
        }

        // Return the string.
        //
        return $string;
    }
} 