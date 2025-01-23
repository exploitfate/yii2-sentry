Yii2 Sentry Package
==================================

Requirements
------------

```shell

sudo apt -y install php-excimer

```

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

```
php composer.phar require --prefer-dist exploitfate/yii2-sentry
```

Configuration
-------------

Add `sentry` component to bootstrap and set component config

```php
return [
    'bootstrap' => ['sentry'],
        // ...
    'components' => [
        // ...
        'sentry' => [
            'class' => 'exploitfate\yii\sentry\Sentry',
            'name' => 'website.com', // optional, uses Yii::$app->name by default
            'enabled' => false, // optional, default = false
            'options' => [
                'dsn' => 'http://1234567890:abcddefg0987654321@sentry.io/7654321',
                // 'traces_sample_rate' => 1.0,
                // Set a sampling rate for profiling - this is relative to traces_sample_rate
                // 'profiles_sample_rate' => 1.0,
            ],
        ],
        // ...
    ],
];
```
