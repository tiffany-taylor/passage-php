# Passage-PHP

## Authenticating a Request
```php
<?php
use Passage;

$config = new Config(
    PASSAGE_APP_ID,
);

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
use Passage;

$config = new Config(
    PASSAGE_APP_ID,
);

$passage = new Passage($config);
$passageApp = $passage->getApp();
```

## Retrieve User Info
```php
<?php
use Passage;

$config = new Config(
    PASSAGE_APP_ID,
    PASSAGE_API_KEY
);

$passage = new Passage($config);

$app->get(
    '/authenticated_route',
    function (ServerRequest $request, Response $response) use ($passage) {
        $userId = $passage->authenticateRequest($request);
        $user = $passage->user->get($userId);
        return $user->email;
    }
);
```

## Activate/Deactivate User
```php
<?php
use Passage;

$config = new Config(
    PASSAGE_APP_ID,
    PASSAGE_API_KEY
);

$passage = new Passage($config);

$app->get(
    '/authenticated_route',
    function (ServerRequest $request, Response $response) use ($passage) {
        $userId = $passage->authenticateRequest($request);
        $user = $passage->user->get($userId);
        $user->deactivate($userId);
        $user->activate($userId);
    }
);
```

## Update User Attributes
```php
<?php
use Passage;

$config = new Config(
    PASSAGE_APP_ID,
    PASSAGE_API_KEY
);

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
        $user = $passage->user->update($userId, $attributes);
    }
);
```

## Create a User
```php
<?php
use Passage;

$config = new Config(
    PASSAGE_APP_ID,
    PASSAGE_API_KEY
);

$passage = new Passage($config);
$newUserWithEmail = $passage->user->create(
    new UserAttributes(
        'newEmail@domain.com',
    )
);
var_dump($newUserWithEmail);

$newUserWithPhone = $passage->user->create(
    new UserAttributes(
        null,
        '+15005550006',
    )
);
var_dump($newUserWithPhone);
```