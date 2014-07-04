<?php
/**
 * Short description for JawboneUP.php
 *
 * @package JawboneUP
 * @author n3xtchen <echenwen@gmail.com>
 * @version 0.1
 * @copyright (C) 2014 n3xtchen <echenwen@gmail.com>
 * @license GPL V2
 */
namespace Jawbone;

class Up
{
    const Version = 'v.1.1';
    const JWB_API = 'https://jawbone.com/nudge/api/v.1.1/';

    private $client_id;
    private $client_secret;
    private $access_token;
    private $refresh_token;

    public function __construct($config)
    {
        foreach ($config as $k => $v) {
            $this->$k = $v;
        }

        return $this;
    }

    /**
     * 获取私有变量
     */
    public function __get($name)
    {
        return isset($this->$name) ?  $this->$name : null;
    }

    /**
     * 将数组转化成 QueryString
     *
     */
    public function arr2qs($data)
    {
        $qs = '';
        if (!empty($data)) {
            $qd = [];

            foreach ($data as $k => $v) {
                $qd[] = $k.'='.urlencode($v);
            }

            $qs = implode('&', $qd);
        }

        return $qs;
    }

    public function curl($uri, $method='GET', $data=[])
    {
        // 将数组转化成 QueryString
        $query_string = $this->arr2qs($data);

        // 初始化一个 cURL 对象
        $curl = curl_init();

        // 设置参数
        $opts = [
            CURLOPT_URL            => self::JWB_API.$uri,
            // 设置header
            CURLOPT_HEADER         => 0,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer '.$this->access_token,
                'Accept: application/json'
            ],
            CURLOPT_CUSTOMREQUEST  => $method,  // 设置 method
            CURLOPT_RETURNTRANSFER => 1 // 要求结果保存到字符串中
        ];
        curl_setopt_array($curl, $opts);

        // 设置传送的参数
        if (in_array($method, ['PUT', 'POST'])) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $query_string);
        }

        // 运行cURL，请求网页
        $data = curl_exec($curl);

        // 关闭URL请求
        curl_close($curl);

        return JSON_DECODE($data, 1);
    }

    public function get($ep, $xid=null)
    {
        $uri = (isset($xid) ? '' : 'users/@me/')
            . $ep
            . (isset($xid) ? '/'.$xid : '');

        return $this->curl($uri);
    }

    public function post($ep, $data=[])
    {
        $uri = 'users/@me/'.$ep;

        return $this->curl($uri, 'POST', $data);
    }

    public function delete($ep, $xid)
    {
        $uri = $ep.'/'.$xid;

        return $this->curl($uri, 'DELETE');
    }
}
