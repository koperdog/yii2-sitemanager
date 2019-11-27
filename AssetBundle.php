<?php

/**
 * AssetBundle.php
 * @author koperdog<koperdog@gmail.com>
 */

namespace koperdog\yii2sitemanager;

/**
 * Class AssetBundle
 */
class AssetBundle extends \yii\web\AssetBundle
{
    /**
     * @inherit
     */
    public $sourcePath = __DIR__. '/assets';
    
    /**
     * @inherit
     */
    public $css = [
        'css/style.css',
    ];
    
    /**
     * @inherit
     */
    public $js = [
        'js/script.js',
    ];
    
    /**
     * @inherit
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
