<?php

namespace Hachi\Alibaba\TTS;

use Hachi\Alibaba\Kernel\BaseClient;

class Client extends BaseClient
{

    /**
     * 语言合成
     * @param $text
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @author: Zhengqian.zhu <zhuzhengqian@vchangyi.com>
     */
    public function speak($text)
    {
        $this->setTtsSing();

        $utcDate = gmdate("D, d M Y H:i:s T");
        $accept = 'audio/mp3, application/json';
        $contentType = 'text/plain';
        $response = $this->request('https://nlsapi.aliyun.com/speak', 'POST', [
            'query'   => [
                'encode_type' => 'mp3',
                'volume'      => 100
            ],
            'body'    => $text,
            'headers' => [
                'Content-Type' => $contentType,
                'Accept'       => $accept,
                'Date'         => $utcDate,
            ],
            'stream'  => true
        ], true);

        return $response->getBody()->getContents();

    }


    protected function setTtsSing()
    {
        $this->setSign(new Sign($this->app));
    }

}
