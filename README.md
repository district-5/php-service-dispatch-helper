Service Dispatch Helper
========================================

### About

This library is designed to facilitate a microservice architecture that is split using subdomains whilst keeping instance costs down during development / early stage.
It allows you to split your application into microservices while running them within the same containerised images (or for example within the same GCP App Engine instance). 


### Installing

This library requires no other libraries.

* Require in your composer
    * `"district5/service-dispatch-helper": "*"`


### Usage

When calling the helper function, you should pass it the base domain name you are working on that all the subdomains hang from.
For example, if our domains are `api.district5.co.uk` and `www.district5.co.uk`, we want `api-service` to map to the api microservice, and `web-service` to map to the main app. This could be achieved with the following:
```php
$baseDomain = 'd5.gs';
$serviceMap = [
        'api' => 'api-service',
        'www' => 'web-service'
    ];

$selector = new \District5\ServiceDispatch\ServiceSelector($serviceMap);
$service = $selector->getServiceFromServerSubdomain('district5.co.uk');
```
