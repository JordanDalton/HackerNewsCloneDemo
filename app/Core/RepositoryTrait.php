<?php namespace App\Core;


trait RepositoryTrait {

    /**
     * Create new model instance.
     *
     * @param array $data Attributes
     * @return user
     */
    public function createNewInstance( $data = [] )
    {
        return $this->getModel()->newInstance( $data );
    }

    /**
     * Create a record.
     *
     * @param array $attributes
     *
     * @return static
     */
    public function createRecord( $attributes = [] )
    {
        return $this->getModel()->create( $attributes );
    }

    /**
     * Return the model.
     *
     * @return User
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Return the table name of the model.
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->getModel()->getTable();
    }

    /**
     * Update an existing record with new data.
     *
     * @param       $record
     * @param array $attributes
     *
     * @return boolean
     */
    public function updateRecord( $record, $attributes = [] )
    {
        return $record->fill( $attributes )->save();
    }
} 