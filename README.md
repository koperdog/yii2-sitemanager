Settings Module
===============
Settings for multilanguage, multidomain site

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist koperdog/yii2-settings "*"
```

or add

```
"koperdog/yii2-settings": "*"
```

to the require section of your `composer.json` file.


Add the component to your common config:

```php
...
'components' => [
    ...
    'settings' => [
        'class' => 'koperdog\yii2settings\components\Settings',
    ],
    ...
]
... 
```

and add the module to backend config:

```php
'modules' => [
    'settings' => [
        'class' => 'koperdog\yii2settings\Module',
    ],
],
```

Then start the migration (console):
```php
php yii migrate --migrationPath=@vendor/koperdog/yii2-settings/migrations
```
Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
\Yii::$app->settings->get('setting_name');
```
check [docs]docs another methods

CRUD settings from backend:
go to /settings

CRUD domains:
go to /settings/domains

CRUD languages:
go to /settings/languages