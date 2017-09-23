<?php

namespace Bex\Laravel\Facedes;

use Illuminate\Support\Facades\Facade;

class BkmExpress extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bkmexpress';
    }
}
