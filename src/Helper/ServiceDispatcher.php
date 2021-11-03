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

    /**
     * @param string $baseDomain
     * @param array $serviceMap
     * @param string $serverVariableKey
     * @return string|null
     *
     * @deprecated
     */
    public static function GetService(string $baseDomain, array $serviceMap, string $serverVariableKey = 'HTTP_HOST') : ?string
    {
        return static::getServiceFromSubdomain($baseDomain, $serviceMap, $serverVariableKey);
    }

    public static function getServiceFromPort(array $serviceMap, string $serverVariableKey = 'SERVER_PORT') : ?string
    {
        if (!array_key_exists($_SERVER[$serverVariableKey], $serviceMap)) {
            return null;
        }

        return $_SERVER[$serverVariableKey];
    }

    public static function getServiceFromSubdomain(string $baseDomain, array $serviceMap, string $serverVariableKey = 'HTTP_HOST') : ?string
    {
        $baseDomainParts = explode('.', $baseDomain);

        $subdomain = join('.', explode('.', $_SERVER[$serverVariableKey], 0 - count($baseDomainParts)));

        if (!array_key_exists($subdomain, $serviceMap)) {
            return null;
        }

        return $serviceMap[$subdomain];
    }
}
