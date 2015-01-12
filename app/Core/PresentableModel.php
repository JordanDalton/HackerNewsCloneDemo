<?php namespace App\Core;

use McCool\LaravelAutoPresenter\HasPresenter;

class PresentableModel extends Model implements HasPresenter {

    /**
     * Return the name of the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return static::class . 'Presenter';
    }
} 