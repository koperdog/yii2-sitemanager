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
php yii migrate --migrationPath=@koperdog/yii2-settings/migrations
```
Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \koperdog\yii2settings\AutoloadExample::widget(); ?>```

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
...```