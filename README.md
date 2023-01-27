# Passage-PHP

## Authenticating a Request
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