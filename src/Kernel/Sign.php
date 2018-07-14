<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hachi\Alibaba\Kernel;

use function GuzzleHttp\Psr7\stream_for;
use GuzzleHttp\Psr7\Uri;
use Hachi\Alibaba\Application;
use Hachi\Alibaba\Kernel\Contracts\SignInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Class Config.
 *
 * @author overtrue <i@overtrue.me>
 */
class Sign implements SignInterface
{
    protected $app;

    private $dateTimeFormat = 'Y-m-d\TH:i:s\Z';

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * 构造规范化字符串用于计算签名（Signature）
     *
     * @param $str
     * @return mixed|string
     */
    private function percentEncode($str)
    {
        $res = urlencode($str);
        $res = preg_replace('/\+/', '%20', $res);
        $res = preg_replace('/\*/', '%2A', $res);
        $res = preg_replace('/%7E/', '~', $res);
        return $res;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array $requestOptions
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function applyToRequest(RequestInterface $request, array $requestOptions = []): RequestInterface
    {
        if (strtoupper($request->getMethod()) == 'GET') {
            $params = $request->getUri()->getQuery();
        } else {
            $params = $request->getBody()->getContents();
        }

        $parameters = [];

        foreach (explode('&', $params) as $value) {
            $explodeValue = explode('=', $value);
            $parameters[$explodeValue[0]] = urldecode($explodeValue[1]);
        }

        $parameters['Format'] = 'JSON';
        $parameters['RegionId'] = 'cn-hangzhou';
        $parameters['Version'] = '2015-11-23';
        $parameters['AccessKeyId'] = $this->app->config['access_key_id'];
        $parameters['SignatureMethod'] = 'HMAC-SHA1';
        $parameters['Timestamp'] = gmdate($this->dateTimeFormat);
        $parameters['SignatureVersion'] = '1.0';
        $parameters['SignatureNonce'] = rand(100000, 999999);
        ksort($parameters);

        $CanonicalizedQueryString = '';
        foreach ($parameters as $key => $value) {
            $CanonicalizedQueryString .= '&' . $this->percentEncode($key) . '=' . $this->percentEncode($value);
        }

        $stringToSign = strtoupper($request->getMethod()) . '&%2F&' . $this->percentEncode(substr($CanonicalizedQueryString, 1));
        $sign = hash_hmac('sha1', $stringToSign, $this->app->config['access_key_secret'] . "&", true);
        $sign = base64_encode($sign);

        $parameters['Signature'] = $sign;

        if (strtoupper($request->getMethod()) == 'GET') {
            $request = $request->withUri(new Uri(http_build_query($parameters)));
        } else {
            $request = $request->withBody(stream_for(http_build_query($parameters)));
        }

        return $request;
    }


}
