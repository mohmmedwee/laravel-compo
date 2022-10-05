<?php

namespace Ostah\LaravelCompo;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ostah\LaravelCompo\Skeleton\SkeletonClass
 */
class LaravelCompoFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-compo';
    }
}
