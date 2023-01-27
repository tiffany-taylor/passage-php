# Passage-PHP

Examples that process HTTP requests use the Slim Framework to show how authenticated requests would work. They can be replaced with anything that provides a PSR-7 HTTP request.

## Authenticating a Request
The Passage SDK can be used to authenticate a request by checking that the request contains a valid authentication token. Your App ID must be provided to Passage to verify JWTs.

```php
<?php
use Passage\SDK\Client as Passage;
use Passage\SDK\Config;
use \Psr\Http\Message\ServerRequestInterface as ServerRequest;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;

$config = new Config(
    $_ENV['PASSAGE_APP_ID'],
);

$app = AppFactory::create();
$app->addRoutingMiddleware();

$passage = new Passage($config);

$app->get(
    '/authenticated_route',
    function (ServerRequest $request, Response $response) use ($passage) {
        try {
            $userId = $passage->authenticateRequest($request);
        } catch (Unauthenticated $exception) {
            return $response->withStatus(401)->write('Unauthorized');
        }

        return $response->withStatus(200)->render();
    }
);
```

## Retrieve App Info

Information about an app can be retrieved using the `\Passage\SDK\Client::getApp()` method.

```php
<?php
use Passage\SDK\Client as Passage;
use Passage\SDK\Config;

$config = new Config(
    $_ENV['PASSAGE_APP_ID'],
);

$passage = new Passage($config);
$passageApp = $passage->getApp();
```

## Retrieve User Info

Information about a user can be retrieved using the `\Passage\SDK\Client::get()` method. You will need to use a Passage API key, which can be created in the Passage Console under your Application Settings. This API key grants your web server access to the Passage management APIs to get and update information about users. This API key must be protected and stored in an appropriate secure storage location. It should never be hard-coded in the repository.

```php
<?php
use Passage\SDK\Client as Passage;
use Passage\SDK\Config;
use \Psr\Http\Message\ServerRequestInterface as ServerRequest;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;

$config = new Config(
    $_ENV['PASSAGE_APP_ID'],
    $_ENV['PASSAGE_API_KEY']
);

$app = AppFactory::create();
$app->addRoutingMiddleware();

$passage = new Passage($config);

$app->get(
    '/authenticated_route',
    function (ServerRequest $request, Response $response) use ($passage) {
        $userId = $passage->authenticateRequest($request);
        $user = $passage->users->get($userId);
        return $user->email;
    }
);
```

## Activate/Deactivate User

A user can be activated or deactivated within the Passage SDK. These actions require an API Key and deactivating a user will prevent them from logging into your application with Passage.

```php
<?php
use Passage\SDK\Client as Passage;
use Passage\SDK\Config;
use \Psr\Http\Message\ServerRequestInterface as ServerRequest;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;

$config = new Config(
    $_ENV['PASSAGE_APP_ID'],
    $_ENV['PASSAGE_API_KEY']
);

$app = AppFactory::create();
$app->addRoutingMiddleware();

$passage = new Passage($config);

$app->get(
    '/authenticated_route',
    function (ServerRequest $request, Response $response) use ($passage) {
        $userId = $passage->authenticateRequest($request);
        $user = $passage->users->get($userId);
        $passage->users->deactivate($user);
        $passage->users->activate($user);
    }
);
```

## Update User Attributes

User's attributes can also be updated with the Passage SDK. This action requires an API key.

```php
<?php
use Passage\SDK\Client as Passage;
use Passage\SDK\Config;
use Passage\SDK\UserAttributes;
use Passage\SDK\Metadata;
use \Psr\Http\Message\ServerRequestInterface as ServerRequest;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;

$config = new Config(
    $_ENV['PASSAGE_APP_ID'],
    $_ENV['PASSAGE_API_KEY']
);

$app = AppFactory::create();
$app->addRoutingMiddleware();

$passage = new Passage($config);
$attributes = new UserAttributes(
    'newEmail@domain.com',
    '+15005550006',
    new Metadata(
        ['exampleField' => 123],
    )
);

$app->get(
    '/authenticated_route',
    function (ServerRequest $request, Response $response) use ($passage) {
        $userId = $passage->authenticateRequest($request);
        $user = $passage->users->update($userId, $attributes);
    }
);
```

## Create a User

A Passage user can be created by providing an `email` or `phone` (phone number must be a valid E164 phone number).

```php
<?php
use Passage\SDK\Client as Passage;
use Passage\SDK\Config;
use Passage\SDK\UserAttributes;

$config = new Config(
    $_ENV['PASSAGE_APP_ID'],
    $_ENV['PASSAGE_API_KEY']
);

$passage = new Passage($config);
$newUserWithEmail = $passage->users->create(
    new UserAttributes(
        'newEmail@domain.com',
    )
);
var_dump($newUserWithEmail);

$newUserWithPhone = $passage->users->create(
    new UserAttributes(
        null,
        '+15005550006',
    )
);
var_dump($newUserWithPhone);
```