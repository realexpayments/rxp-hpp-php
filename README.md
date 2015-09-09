# Realex Payments HPP PHP SDK
You can sign up for a free Realex Payments sandbox account at https://www.realexpayments.co.uk/developers

## Requirements ##
- PHP >= 5.3.9
- Composer (https://getcomposer.org/)

## Instructions ##

1. Add the following to your 'composer.json' file

    ```
    {
        "require": {
            "realexpayments/rxp-hpp-php": "1.0.0"
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
    require_once ( 'vendor/autoload.php' );
    ```

4. Use the sdk <br/>

    ```php
	$hppRequest = ( new HppRequest() )
		->addMerchantId( "myMerchantId" )
		->addAccount( "mySubAccount" )
        ....
	```

##SDK Example##

### Creating Request JSON for Realex JS SDK

```php
require_once ( 'vendor/autoload.php' );

use com\realexpayments\hpp\sdk\domain\HppRequest;
use com\realexpayments\hpp\sdk\RealexHpp;

$hppRequest = ( new HppRequest() )
	->addMerchantId( "myMerchantId" )
	->addAccount( "mySubAccount" )
	->addAmount( "1001" )
	->addCurrency( "EUR" )
	->addAutoSettleFlag( "1" );

$supplementaryData = array();
$supplementaryData['key1'] = 'value1';
$supplementaryData['key2'] = 'value2';

$hppRequest->addSupplementaryData( $supplementaryData );	
	
$realexHpp = new RealexHpp( "mySecret" );
$requestJson = $realexHpp->requestToJson( $hppRequest );
```

### Consuming Response JSON from Realex Payments JS SDK

```php
require_once ( 'vendor/autoload.php' );

use com\realexpayments\hpp\sdk\domain\HppResponse;
use com\realexpayments\hpp\sdk\RealexHpp;

$realexHpp = new RealexHpp( "mySecret" );
$hppResponse = $realexHpp->responseFromJson( responseJson );
```

## License

See the LICENSE file.