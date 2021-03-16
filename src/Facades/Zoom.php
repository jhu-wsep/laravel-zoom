<?php

namespace MacsiDigital\Zoom\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \MacsiDigital\Zoom\Meeting meeting()
 * @method static \MacsiDigital\Zoom\User user()
 *
 */
class Zoom extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'zoom';
    }
}
