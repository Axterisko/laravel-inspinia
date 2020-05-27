<?php

namespace Axterisko\Inspinia\Facades;

use Illuminate\Support\Facades\Facade;

class Inspinia extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'inspinia';
    }
}
