Service Dispatch Helper
========================================

### About

This library is designed to facilitate a microservice architecture that is split using subdomains whilst keeping instance costs down during development / early stage.
It allows you to split your application into microservices while running them on the same GCP App Engine instance (or any other cloud provider application as a service platform). 


### Installing

This library requires no other libraries.

* Require in your composer
    * `"district5/service-dispatch-helper": "*"`


### Usage

When calling the helper function, you should pass it the base domain name you are working on that all the subdomains hang from.
For example, if our domains are `api-d.d5.gs` and `app-d.d5.gs`, we want `api-d` to map to the api microservice, and `app-d` to map to the main app. This could be achieved with the following:
```php
$baseDomain = 'd5.gs';
$serviceMap = array(
        'api-d' => 'api',
        'app-d' => 'default'
    );

$microservice = \District5\Helper\ServiceDispatcher::GetService($baseDomain, $serviceMap);
```

You should integrate the library at an early point in the application, after composer vendor integration but before you decide on which microservice you are bootstrapping.

```php
<?php

// other initialisation here...

require 'vendor/autoload.php';


$gaeService = getenv('GAE_SERVICE');
if ($gaeService === null || $gaeService === 'default')
{
    $baseDomain = 'd5.gs';
    $serviceMap = array(
        'api-d' => 'api',
        'app-d' => 'default'
    );

    $overrideService = \District5\Helper\ServiceDispatcher::GetService($baseDomain, $serviceMap);
    if ($overrideService !== null && $gaeService !== $overrideService)
    {
        $gaeService = $overrideService;
    }
}

// select the microservice to bootstrap 
if ($gaeService == 'promo')
{
    // any promo specific stuff here

    $app = new \PROJECT\Bootstrap\BootstrapPromo();
}
else if ($gaeService == 'api')
{
    // any api specific stuff here

    $app = new \PROJECT\Bootstrap\BootstrapAPI();
}
else if ($gaeService == 'default' || $gaeService == 'client')
{
    // any client specific stuff here

    $app = new \PROJECT\Bootstrap\BootstrapClient();
}
else
{
    // unrecognised service, log an error and abort
    error_log('unrecognised gaeService:' . $gaeService);
    
    // TODO: throw an error
    return;
}

$app->run();
```