<?php

/**
 * District5 - Service Dispatch Helper
 *
 * @copyright District5
 *
 * @author District5
 * @link https://www.district5.co.uk
 *
 * @license This software and associated documentation (the "Software") may not be
 * used, copied, modified, distributed, published or licensed to any 3rd party
 * without the written permission of District5 or its author.
 *
 * The above copyright notice and this permission notice shall be included in
 * all licensed copies of the Software.
 *
 */
namespace District5\Helper;

class ServiceDispatcher
{

    public static function GetService(string $baseDomain, array $serviceMap) : ?string
    {
        $baseDomainParts = explode('.', $baseDomain);

        $subdomain = join('.', explode('.', $_SERVER['HTTP_HOST'], 0 - count($baseDomainParts)));
        error_log('subdomain:' . $subdomain);

        if (!array_key_exists($subdomain, $serviceMap))
        {
            error_log('no subdomain found in service map');
            return null;
        }

        return $serviceMap[$subdomain];
    }
}
