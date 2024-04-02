<?php

/**
 * District5 Service Dispatcher Library
 *
 * @author      District5 <hello@district5.co.uk>
 * @copyright   District5 <hello@district5.co.uk>
 * @link        https://www.district5.co.uk
 *
 * MIT LICENSE
 *
 *  Permission is hereby granted, free of charge, to any person obtaining
 *  a copy of this software and associated documentation files (the
 *  "Software"), to deal in the Software without restriction, including
 *  without limitation the rights to use, copy, modify, merge, publish,
 *  distribute, sublicense, and/or sell copies of the Software, and to
 *  permit persons to whom the Software is furnished to do so, subject to
 *  the following conditions:
 *
 *  The above copyright notice and this permission notice shall be
 *  included in all copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 *  EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 *  MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 *  NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 *  LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 *  OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 *  WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace District5\ServiceDispatch;

class ServiceSelector
{
    protected array $serviceMap;

    public function __construct(array $serviceMap)
    {
        $this->serviceMap = $serviceMap;
    }

    /**
     * Gets a service name from the SERVER variable containing port number.
     *
     * @param string $serverPortVariableKey
     * @return string|null
     */
    public function getServiceFromServerPort(string $serverPortVariableKey = 'SERVER_PORT'): ?string
    {
        if (!isset($_SERVER[$serverPortVariableKey])) {
            return null;
        }

        return $this->getServiceFromPort($_SERVER[$serverPortVariableKey]);
    }

    /**
     * Gets a service name from the SERVER variable containing the host and a base domain.
     *
     * @param string $baseDomain
     * @param string $serverHostVariableKey
     * @return string|null
     */
    public function getServiceFromServerSubdomain(string $baseDomain, string $serverHostVariableKey = 'HTTP_HOST'): ?string
    {
        if (!isset($_SERVER[$serverHostVariableKey])) {
            return null;
        }

        return $this->getServiceFromSubdomain($baseDomain, $_SERVER[$serverHostVariableKey]);
    }

    /**
     * Gets a service name given the port number.
     *
     * @param string $port
     * @return string|null
     */
    public function getServiceFromPort(string $port): ?string
    {
        if (!array_key_exists($port, $this->serviceMap)) {
            return null;
        }

        return $this->serviceMap[$port];
    }

    /**
     * Gets a service name given the current host and a base domain.
     *
     * @param string $baseDomain
     * @param string $currentHost
     * @return string|null
     */
    public function getServiceFromSubdomain(string $baseDomain, string $currentHost): ?string
    {
        $baseDomainParts = explode('.', $baseDomain);

        $subdomain = join('.', explode('.', $currentHost, 0 - count($baseDomainParts)));

        if (!isset($this->serviceMap[$subdomain])) {
            return null;
        }

        return $this->serviceMap[$subdomain];
    }
}
