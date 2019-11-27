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
    'settings' => [
        'class' => 'koperdog\yii2sitemanager\components\Settings',
    ],
    'domains' => [
        'class' => 'koperdog\yii2sitemanager\components\Domains',
    ],
    'languages' => [
        'class' => 'koperdog\yii2sitemanager\components\Languages',
    ],
    ...
]
... 
```

also you should add component to bootstrap config:

```php
...
'bootstrap' => ['settings'],
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

autoloaded settings:
```php
\Yii::$app->params['setting_name'];
```

If you are not sure if the setting is autoload:
```php
\Yii::$app->settings->get('setting_name');
```

<details>
  <summary>CRUD and URL config</summary>
  
CRUD settings from backend:
go to /manager

CRUD domains:
go to /manager/domains

CRUD languages:
go to /manager/languages

also, if you want use standart CRUD, you can add to Url rule config:

```php
CRUD settings from backend:
go to /manager

CRUD domains:
go to /manager/domains

CRUD languages:
go to /manager/languages
```
  
</details>