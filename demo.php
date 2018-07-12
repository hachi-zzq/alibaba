<?php
/**
 * this is a demo
 * DateTime: 2018/7/12 16:05
 * Author: Zhengqian.zhu <zhuzhengqian@vchangyi.com>
 */

require 'vendor/autoload.php';


$application = new \Hachi\Alibaba\Application([
    /**
     * access_key_id
     */
    'access_key_id'     => 'x',

    /**
     * access_key_secret
     */
    'access_key_secret' => 'x',
    'response_type'     => 'collection',

    /**
     * 邮件推送服务
     */
    'direct_mail'       => [

        /**
         * 发信人
         */
        'from'          => 'noreply@support.zhuzhengqian.com',

        /**
         * 发信人昵称
         */
        'from_alias'    => '',

        /**
         * 回信地址
         */
        'reply_address' => ''


    ]
]);

try {
    $body = $application->direct_mail->singleSend('hachi.zzq@gmail.com', new \Hachi\Alibaba\DirectMail\TextMessage('12'), 'hello', 'e');
} catch (\Hachi\Alibaba\Kernel\Exceptions\MailSendException $exception) {
    dd($exception);
}
dd($body);

