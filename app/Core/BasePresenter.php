<?php namespace App\Core;

use McCool\LaravelAutoPresenter\BasePresenter as McCoolBasePresenter;

class BasePresenter extends McCoolBasePresenter {

    /**
     * Return the wrapped object.
     *
     * @return object
     */
    public function getWrappedObject()
    {
        return $this->wrappedObject;
    }
} 