<?php

namespace Bex\Laravel\Facedes;

use Illuminate\Support\Facades\Facade;

class Bex extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bex';
    }
}
