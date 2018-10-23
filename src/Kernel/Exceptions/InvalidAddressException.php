<?php
/**
 * Created by PhpStorm.
 * DateTime: 2018/7/12 23:15
 * Author: Zhengqian.zhu <zhuzhengqian@vchangyi.com>
 */

namespace Hachi\Alibaba\Kernel\Exceptions;


use Throwable;

class InvalidAddressException extends \Exception
{
    protected $address;

    public function __construct(string $message = "", int $code = 0, $address, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getAddress()
    {
        return $this->address;
    }

}