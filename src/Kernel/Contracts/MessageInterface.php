<?php


namespace Hachi\Alibaba\Kernel\Contracts;

interface MessageInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return mixed
     */
    public function transformForJsonRequest(): array;

    /**
     * @return string
     */
    public function transformToXml(): string;
}
