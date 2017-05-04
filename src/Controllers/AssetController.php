<?php

namespace Redrain\YouDao\Controllers;

use Illuminate\Http\Response;

class AssetController extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        ob_end_clean();
    }

    public function getJs()
    {
        $file = __DIR__ . '/../Resource/js/jquery-3.2.1.min.js';
        $content = file_get_contents($file);
        $jsFile = __DIR__. '/../Resource/js/base.js';

        $jsContent = file_get_contents($jsFile);
        $content .= $jsContent;
        $response = new Response($content, 200, ['Content-Type' => 'text/javascript']);

        return $this->cacheResponse($response);
    }

    public function getCss()
    {
        $file = __DIR__ . '/../Resource/css/base.css';
        $content = file_get_contents($file);
        $response = new Response($content, 200, ['Content-Type' => 'text/css']);

        return $this->cacheResponse($response);
    }

    /**
     * @param Response $response
     * @return Response
     */
    protected function cacheResponse(Response $response)
    {
        $response->setMaxAge(31536000);
        $response->setSharedMaxAge(31536000);
        $response->setExpires(new \DateTime('+1 year'));

        return $response;
    }
}