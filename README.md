# Purpose of this fork

This is a fork to update any incompatibilities with PHP8. Below list of known problems:
- doctrine/annotations 1.2.x is incompatible with PHP8, requirement changed to accept any 1.x
- phpunit/phpunit updated to 8.3, so that tests are runnable on newer version of PHP

Contents of original README start below.

---

# Please use our new PHP SDK
We've moved. We highly recommend you use the Global Payments PHP SDK
which supports all the features of this SDK and will benefit from all future releases:
https://github.com/globalpayments/php-sdk

With the latest update (1.1.3) this SDK supports the mandatory and recommended HPP fields for 3D Secure 2. Going forward it will only receive critical security updates, no further feature updates will be released beyond 3D Secure 2.

# Realex Payments HPP PHP SDK
You can sign up for a Global Payments (formerly Realex Payments) account at https://developer.globalpay.com

## Requirements ##
- PHP >= 5.3.9
- For security and support we highly recommend you use PHP 7
- Composer (https://getcomposer.org/)

## Instructions ##

1. Add the following to your 'composer.json' file

    ```
    {
        "require": {
            "realexpayments/rxp-hpp-php": "1.1.3"
        }    
    }
    ```

2. Inside the application directory run composer:

    ```
    composer update
    ```

    OR (depending on your server configuration)

    ```
    php composer.phar update
    ```

3. Add a reference to the autoloader class anywhere you need to use the sdk

    ```php
    require_once ('vendor/autoload.php');
    ```

4. Use the sdk <br/>

    ```php
    $hppRequest = new HppRequest(); 
    $hppRequest->addMerchantId("MerchantId");
    $hppRequest->addAccount("internet");
    ....
	```

## Usage

### Creating HPP Request JSON for Realex Payments JS Library

```php
<?php
require_once ('vendor/autoload.php');

use com\realexpayments\hpp\sdk\domain\HppRequest;
use com\realexpayments\hpp\sdk\RealexHpp;
use com\realexpayments\hpp\sdk\RealexValidationException;
use com\realexpayments\hpp\sdk\RealexException;

$hppRequest = new HppRequest(); 
$hppRequest->addMerchantId("MerchantId");
$hppRequest->addAccount("internet");
$hppRequest->addAmount("1001");
$hppRequest->addCurrency("EUR");
$hppRequest->addAutoSettleFlag(TRUE);
$hppRequest->addHppVersion("2");
// 3D Secure 2 Mandatory and Recommended Fields
$hppRequest->addCustomerEmailAddress("james.mason@example.com");
$hppRequest->addCustomerMobilePhoneNumber("44|07123456789");
$hppRequest->addBillingAddressLine1("Flat 123");
$hppRequest->addBillingAddressLine2("House 456");
$hppRequest->addBillingAddressLine3("Unit 4");
$hppRequest->addBillingCity("Halifax");
$hppRequest->addBillingPostalCode("W5 9HR");
$hppRequest->addBillingCountryCode("826");
$hppRequest->addShippingAddressLine1("Apartment 825");
$hppRequest->addShippingAddressLine2("Complex 741");
$hppRequest->addShippingAddressLine3("House 963");
$hppRequest->addShippingCity("Chicago");
$hppRequest->addShippingState("IL");
$hppRequest->addShippingPostalCode("50001");
$hppRequest->addShippingCountryCode("840");

$realexHpp = new RealexHpp("Shared Secret");

try {
    $requestJson = $realexHpp->requestToJson($hppRequest, false);
    // TODO: pass the HPP request JSON to the JavaScript, iOS or Android Library
}
catch (RealexValidationException $e) {
    // TODO: Add your error handling here
}
catch (RealexException $e) {
    // TODO: Add your error handling here
}
```

### Consuming Response JSON from Realex Payments JS Library

```php
<?php
require_once ('vendor/autoload.php');

use com\realexpayments\hpp\sdk\domain\HppResponse;
use com\realexpayments\hpp\sdk\RealexHpp;

$realexHpp = new RealexHpp("mySecret");
$hppResponse = $realexHpp->responseFromJson(responseJson);
```
## License

See the LICENSE file.
