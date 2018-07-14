<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Hachi\Alibaba\TTS;

use Hachi\Alibaba\Kernel\Contracts\SignInterface;
use Psr\Http\Message\RequestInterface;
use Hachi\Alibaba\Application;

/**
 * Class Config.
 *
 * @author overtrue <i@overtrue.me>
 */
class Sign implements SignInterface
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }


    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array $requestOptions
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function applyToRequest(RequestInterface $request, array $requestOptions = []): RequestInterface
    {
        $bodyBased = base64_encode(md5($request->getBody()->getContents(), true));
        $feature = strtoupper($request->getMethod()) . "\n" . $request->getHeader('Accept')[0] . "\n" . $bodyBased . "\n" . $request->getHeader('Content-Type')[0] . "\n" . $request->getHeader('Date')[0];

        $sign = base64_encode(hash_hmac('sha1', $feature, $this->app->config['access_key_secret'], true));

        $request = $request->withHeader('Authorization', sprintf('Dataplus %s:%s', $this->app->config['access_key_id'], $sign));

        return $request;
    }

}
