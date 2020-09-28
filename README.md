# close-php

PHP bindings to the Close.cpm API

## Installation

This library supports PHP 7.1 and later

The recommended way to install close-php is through [Composer](https://getcomposer.org):

```sh
composer require mckltech/close-php php-http/guzzle6-adapter
```

## Clients

Initialize your client using your access token:

```php
use Close\CloseClient;

$client = new CloseClient('<insert_key_here>');
```

> If you already have an API key you can find it [here](https://app.close.com/settings/api/). If you want to create or learn more about API Keys then you can find more info [here](https://app.close.com/settings/api/).
## API Versions

This library is intended to work with V1 of the Close API

## Exceptions

Exceptions are handled by HTTPlug. Every exception thrown implements `Http\Client\Exception`. See the [http client exceptions](http://docs.php-http.org/en/latest/httplug/exceptions.html) and the [client and server errors](http://docs.php-http.org/en/latest/plugins/error.html).
The SDK may return an unsuccessful HTTP response, for example when a resource is not found (404).
If you want to catch errors you can wrap your API call into a try/catch block:

```php
try {
    $user = $client->contacts->getContact("570680a8a1bcbca8a90001b9");
} catch(Http\Client\Exception $e) {
    if ($e->getCode() == '404') {
        // Handle 404 error
        return;
    } else {
        throw $e;
    }
}
```

## Credit

This library is not endorsed or maintained by Close.com

This library is based on the awesome work of the team at https://github.com/intercom/intercom-php
