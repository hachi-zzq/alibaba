<?php

namespace Hachi\Alibaba\DirectMail;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Hachi\Alibaba\Kernel\BaseClient;
use Hachi\Alibaba\Kernel\Exceptions\InvalidAddressException;
use Hachi\Alibaba\Kernel\Exceptions\MailSendException;

class Client extends BaseClient
{

    /**
     * 请求地址
     */
    const API = 'http://dm.aliyuncs.com';

    /**
     * 单邮件发送
     * @author: Zhengqian.zhu <zhuzhengqian@vchangyi.com>
     * @param $toAddress
     * @param Message $message
     * @param null $fromAlias
     * @param null $subject
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws MailSendException
     */
    public function singleSend($toAddress, Message $message, $fromAlias = null, $subject = null)
    {
        $config = $this->app->config;
        $messageContent = $message->getContent();

        $params = [
            'Action'         => 'SingleSendMail',
            'AccountName'    => $config['direct_mail']['from'],
            'ReplyToAddress' => $config['direct_mail']['reply_address'] ? 'true' : 'false',
            'AddressType'    => 1,
            'ToAddress'      => is_array($toAddress) ? implode(',', $toAddress) : $toAddress,
            'Subject'        => $subject,
            'ClickTrace'     => $config['direct_mail']['click_trace'] ? 1 : 0,
        ];

        if ($fromAlias || isset($config['direct_mail']['from_alias'])) {
            $params['FromAlias'] = $fromAlias ? $fromAlias : $config['direct_mail']['from_alias'];
        }

        if ($message instanceof HtmlMessage) {
            $params['HtmlBody'] = $messageContent;
        } elseif ($message instanceof TextMessage) {
            $params['TextBody'] = $messageContent;
        }
        try {
            $response = $this->httpPost(self::API, $params);
        } catch (ClientException | ServerException $exception) {
            $responseContent = json_decode($exception->getResponse()->getBody()->getContents(), true);
            $code = $responseContent['code'] ?? '';
            if ($code == 'InvalidToAddress.Spam') {
                throw new InvalidAddressException($responseContent['Message'] ?? '', 0, $toAddress);
            }
            throw new MailSendException($responseContent['Message'] ?? '');
        }

        if (isset($response['Message'])) {
            throw new MailSendException($response['Message']);
        }

        return $response;
    }
}
