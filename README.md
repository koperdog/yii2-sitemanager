Settings Module
===============
Settings for multilanguage, multidomain site

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist koperdog/yii2-sitemanager "*"
```

or add

```
"koperdog/yii2-sitemanager": "*"
```

to the require section of your `composer.json` file.


Add the component to your common config:

```php
...
'components' => [
    ...
    'manager' => [
        'class' => 'koperdog\yii2sitemanager\components\Manager',
    ],
    ...
]
... 
```

and add the module to backend config:

```php
'modules' => [
    'manager' => [
        'class' => 'koperdog\yii2sitemanager\Module',
    ],
],
```

Then start the migration (console):
```php
php yii migrate --migrationPath=@vendor/koperdog/yii2-sitemanager/migrations
```
Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
\Yii::$app->settings->get('setting_name');
```
check [docs]docs another methods

CRUD settings from backend:
go to /manager

CRUD domains:
go to /manager/domains

CRUD languages:
go to /manager/languages