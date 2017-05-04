<?php

namespace Redrain\YouDao\Controllers;

use \Illuminate\Routing\Controller;

class BaseController extends  Controller
{
	protected $youdaoApiKey;
	protected $youdaoKeyFrom;

	public function __construct()
    {
        $this->youdaoApiKey = config('youdao.youdao_api_key');
        $this->youdaoKeyFrom = config('youdao.youdao_key_from');
    }
}