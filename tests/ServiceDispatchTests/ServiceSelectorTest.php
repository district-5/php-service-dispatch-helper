<?php

namespace District5Tests\ServiceDispatchTests;

use District5\ServiceDispatch\ServiceSelector;
use PHPUnit\Framework\TestCase;

class ServiceSelectorTest extends TestCase
{

    public function testPortNumberWithValidServices()
    {
        $serviceMap = [
            '8001' => 'api',
            '8002' => 'admin',
            '8003' => 'web-client'
        ];

        $selector = new ServiceSelector($serviceMap);

        $this->assertEquals('api', $selector->getServiceFromPort('8001'));
        $this->assertEquals('admin', $selector->getServiceFromPort('8002'));
        $this->assertEquals('web-client', $selector->getServiceFromPort('8003'));
    }

    public function testPortNumberWithNoValidServices()
    {
        $serviceMap = [];

        $selector = new ServiceSelector($serviceMap);

        $this->assertNull($selector->getServiceFromPort('8001'));
    }

    public function testSubdomainWithValidServices()
    {
        $serviceMap = [
            'api' => 'api',
            'admin' => 'admin',
            'www' => 'web-client'
        ];

        $selector = new ServiceSelector($serviceMap);

        $this->assertEquals('api', $selector->getServiceFromSubdomain('district5.co.uk', 'api.district5.co.uk'));
        $this->assertEquals('admin', $selector->getServiceFromSubdomain('district5.co.uk', 'admin.district5.co.uk'));
        $this->assertEquals('web-client', $selector->getServiceFromSubdomain('district5.co.uk', 'www.district5.co.uk'));
    }

    public function testSubdomainWithNoValidServices()
    {
        $serviceMap = [
            'www2' => 'web-client'
        ];

        $selector = new ServiceSelector($serviceMap);

        $this->assertNull($selector->getServiceFromSubdomain('district5.co.uk', 'www.district5.co.uk'));
    }
}
