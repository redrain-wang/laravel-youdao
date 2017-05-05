<?php

namespace Redrain\YouDao\Controllers;

class YouDaoController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        ob_end_clean();
    }

    public function get($keyWord)
    {
        $url = 'http://fanyi.youdao.com/openapi.do?keyfrom=' . $this->youdaoKeyFrom . '&key=' . $this->youdaoApiKey .
            '&type=data&doctype=json&version=1.1&q=' . urlencode(trim($keyWord));

        $json = self::curlHttpGet($url);

        $array = json_decode($json, 1);

        return $array['errorCode'] == 0 ? $this->getHtml($array) : '';
    }

    /**
     * curl GET 请求
     * @param $url
     * @param $timeOut
     * @param bool $ssl
     * @param array $header
     * @return mixed
     */
    public static function curlHttpGet($url, $ssl = false, $timeOut = 10, $header = [])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url); //设置链接
        curl_setopt($curl, CURLOPT_HEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeOut);
        if ($ssl) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $response = curl_exec($curl);

        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            app('log')->info('HttpUtil_curlHttpGet', ['url' => $url, 'error' => $err]);
        } else {
            app('log')->info('HttpUtil_curlHttpGet', ['url' => $url, 'response' => $response]);
            return $response;
        }

    }


    public function getHtml($array)
    {
        $html = "<div class='youdao_content'><h2>{$array['query']}</h2>";
        $html .= "<div class='youdao_content2'><b>{$array['translation'][0]}</b></div>";
        if(isset($array['basic']['explains']) && count($array['basic']['explains']) > 0){
            foreach($array['basic']['explains'] as $e_item){
                $html .= "<p class='youdao_explain'>{$e_item}</p>";
            }
        }

//        if (isset($array['web']) && count($array['web']) > 0) {
//            $html .= "<div class='youdao_content3'>";
//            foreach ($array['web'] as $item) {
//                $html .= "<div class='web_key'>{$item['key']}";
//                foreach($item['value'] as $item2){
//                    $html .= "<div class='web_value'>{$item2}</div>";
//
//                }
//                $html .= "</div>";
//            }
//
//            $html .= "</div>";
//
//        }


        $html .= "</div>";

        return $html;
    }


}