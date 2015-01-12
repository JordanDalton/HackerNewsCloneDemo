<?php namespace App\Core;

trait SoftDeleteRepositoryTrait {

    /**
     * Restore a record that was previously soft-deleted.
     *
     * @param $record
     */
    public function restoreRecord( $record )
    {
        return $record->restore();
    }

    /**
     * Soft delete a record.
     *
     * @param  $record
     * @return boolean
     */
    public function softDeleteRecord( $record )
    {
        return $record->delete();
    }
} 