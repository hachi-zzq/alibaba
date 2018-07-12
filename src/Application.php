<?php

namespace Hachi\Alibaba;

use Hachi\Alibaba\Kernel\ServiceContainer;
use Hachi\Alibaba\DirectMail\ServiceProvider as DirectMailServiceProvider;
/**
 * Application.
 *
 * @property \Hachi\Alibaba\DirectMail\Client $direct_mail
 * @property \Hachi\Alibaba\Kernel\Config $config
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        DirectMailServiceProvider::class
    ];

}
