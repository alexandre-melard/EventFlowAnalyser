<?php
/**
 * Created by JetBrains PhpStorm.
 * User: A140980
 * Date: 12/11/12
 * Time: 23:14
 * To change this template use File | Settings | File Templates.
 */
namespace Atos\Worldline\Fm\Integration\Ucs\EventFlowAnalyser\DependencyInjection;

use Doctrine\Common\Cache\Cache;

class CacheAware
{
    protected $cache;

    public function __construct(Cache $c)
    {
        $this->cache = $c;
    }

    public function setCache($cache)
    {
        $this->cache = $cache;
    }

}
