<?php

/**
 * @link https://github.com/koperdog/yii2-sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-sitemanager/blob/master/LICENSE
 */

namespace koperdog\yii2sitemanager;

/**
 * AssetBundle
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
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
        'js/manager.js',
    ];
    
    /**
     * @inherit
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
