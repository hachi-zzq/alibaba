# 阿里云 SDK 工具包

> author:zhuzhengqian<hachi.zzq@gmail.com>


## 这个包是什么？

这个 SDK 包含阿里云部分云产品，目前已经集成的包括以下服务：

- 邮件推送
- 语言合成（TTS）


## 如何安装

### composer 引入

```$shell

composer require hachi-zzq/alibaba

```

## 开始使用

### 配置文件

```php
<?php

/**
 * 阿里云参数配置
 */
return [
    /**
     * access_key_id
     */
    'access_key_id'     => 'access_key_id',

    /**
     * access_key_secret
     */
    'access_key_secret' => 'access_key_secret',

    'response_type' => 'collection',

    /**
     * 邮件推送服务
     */
    'direct_mail'   => [

        /**
         * 发信人，必须与阿里云后台配置的发信人一致
         */
        'from'          => '',

        /**
         * 发信人昵称
         */
        'from_alias'    => '',

        /**
         * 回信地址
         */
        'reply_address' => false
    ]
];

```

## 使用示例
```php
<?php

### 初始化应用
$application = new \Hachi\Alibaba\Application([
    /**
     * access_key_id
     */
    'access_key_id'     => 'access_key_id',

    /**
     * access_key_secret
     */
    'access_key_secret' => 'access_key_secret',
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
        'reply_address' => true
    ]
]);

### 调用邮件发送

#### 发送文本邮件

$textMessage = new \Hachi\Alibaba\DirectMail\TextMessage('这个是一个文本内容');

try {
    $body = $application->direct_mail->singleSend('hachi.zzq@gmail.com', $textMessage, '发送别名', '这个是主题');
} catch (\Hachi\Alibaba\Kernel\Exceptions\MailSendException $exception) {
    dd($exception);
}

#### 发送HTML邮件

$html = "
<p>这个是段落</p>
";

$htmlMessage = new \Hachi\Alibaba\DirectMail\HtmlMessage($html);

try {
    $body = $application->direct_mail->singleSend('hachi.zzq@gmail.com', $htmlMessage, '发送别名', '这个是主题');
} catch (\Hachi\Alibaba\Kernel\Exceptions\MailSendException $exception) {
    dd($exception);
}

dd($body);


### 调用语言合成

$outSteam = $application->tts->speak('我是文本');

file_put_contents('/tmp/demo.mp3',$outSteam);


```
