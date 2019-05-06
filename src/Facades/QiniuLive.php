<?php

namespace Laoliu\Qiniu\Live\Facades;

use Illuminate\Support\Facades\Facade;

class QiniuLive extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'QiniuLive';
    }
}
