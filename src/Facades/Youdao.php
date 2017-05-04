<?php namespace Redrain\YouDao\Facades;

use Illuminate\Support\Facades\Facade;

class YouDao extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'youdao';
    }
}