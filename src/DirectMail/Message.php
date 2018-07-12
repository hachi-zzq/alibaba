<?php
/**
 * Created by PhpStorm.
 * DateTime: 2018/7/12 11:05
 * Author: Zhengqian.zhu <zhuzhengqian@vchangyi.com>
 */

namespace Hachi\Alibaba\DirectMail;


abstract class Message
{
    protected $type;

    protected $content;

    /**
     * 文本邮件
     */
    const TYPE_TEXT = 'TEXT';

    /**
     * HTML 邮件
     */
    const TYPE_HTML = 'HTML';

    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * 消息内容
     * @return mixed
     * @author: Zhengqian.zhu <zhuzhengqian@vchangyi.com>
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * 内容
     * @return mixed
     * @author: Zhengqian.zhu <zhuzhengqian@vchangyi.com>
     */
    public function getContent()
    {
        return $this->content;
    }

}