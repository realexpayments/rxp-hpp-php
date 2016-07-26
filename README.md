# Realex HPP PHP SDK
You can sign up for a Realex account at https://www.realexpayments.com.

- PHP >= 5.3
- Composer (https://getcomposer.org/)

## Instructions ##

1. In you application root folder checkout the latest version of the project from Git:
```
    git clone https://github.com/realexpayments-developers/rxp-hpp-php.git
```
2. Inside the rxp-hpp-php directory run composer:
```
    composer update
```
3. Add a reference to the autoloader class anywhere where you need to use the sdk
```
    require __DIR__ . "/rxp-hpp-php/vendor/autoload.php";
```
4. Use the sdk <br/>
```php
$hppRequest = new HppRequest();
$hppRequest->addAmount(100)
         ->addCurrency("EUR")
         ....
```


## Usage
### Creating Request JSON for Realex JS SDK
```php
require __DIR__ . "/rxp-remote-php/vendor/autoload.php";

$hppRequest = new HppRequest();
$hppRequest->addAmount(100)
    ->addCurrency("EUR")
    ->addMerchantId("merchantid");


$realexHpp = new RealexHpp("secret");
$requestJson = $realexHpp->requestToJson($hppRequest);
```
### Consuming Response JSON from Realex JS SDK
```php
$realexHpp = new RealexHpp("secret");
$hppResponse = $realexHpp->responseFromJson(responseJson);
```
### HPP Version and HPP Select Stored Card
```php
$hppRequest = new HppRequest();
$hppRequest
	        ->addAmount("1001")
	        ->addCurrency("EUR")
	        ->addAccount("accountId")
	        ->addMerchantId("merchantId")
	        ->addAutoSettleFlag("1")
			->addPayerExists("1")
			->addPayerReference("payerRef")
			->addHppSelectStoredCard("storedCardRef");
			
$realexHpp = new RealexHpp("secret");
$requestJson = $realexHpp->requestToJson($hppRequest);
```
### HPP Post Dimension and  HPP Post Response
```php
$hppRequest = new HppRequest();
$hppRequest
	        ->addAmount("1001")
	        ->addCurrency("EUR")
	        ->addAccount("accountId")
	        ->addMerchantId("merchantId")
	        ->addAutoSettleFlag("1")
			->addPayerExists("payerRef")
			->addPayerReference("payerRef")
			->addPostDimensions("{\"iframe\":{\"height\":\"544px\",\"width\":\"768px\"}}")
			->addPostResponse("{ DCCCOMMISSIONPERCENTAGE: \"MA==\", BATCHID: \"MjAyNzc2\"}");
			
$realexHpp = new RealexHpp("secret");
$requestJson = $realexHpp->requestToJson($hppRequest);
```
## License
See the LICENSE file.


