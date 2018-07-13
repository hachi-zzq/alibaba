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
         * 发信人
         */
        'from'          => '',

        /**
         * 发信人昵称
         */
        'from_alias'    => '',

        /**
         * 是否使用阿里云管理后台配置的回信地址
         */
        'reply_address' => false
    ]
];