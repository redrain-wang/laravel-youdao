<?php

namespace Redrain\YouDao;

class LaravelYouDao
{

    /**
     * 发送消息
     * @param string $url
     * @param array $data
     */
    public function send($url, $data)
    {
        $this->pubu_curlHttpPost($url, $data, 1, false);
    }

    /**
     * @param string $url
     * @param array $data
     * @param bool $ssl
     * @param integer $timeOut
     * @return string
     */
    public function pubu_curlHttpPost($url, $data, $timeOut = 15, $ssl = false)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url); //设置链接
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeOut);
        curl_setopt($curl, CURLOPT_POST, 1); //设置为POST方式
        if (!$ssl) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data)); //POST数据
        $output = curl_exec($curl);
        curl_close($curl);

        app('log')->info('pubu_curlHttpPost', ['url' => $url, 'param' => $data, 'content' => $output]);

        return $output;
    }
}