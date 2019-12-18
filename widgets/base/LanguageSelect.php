<?php

/**
 * @link https://github.com/koperdog/yii2-treeview
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-sitemanager/blob/master/LICENSE
 */

namespace koperdog\yii2sitemanager\widgets\base;

use koperdog\yii2sitemanager\repositories\read\LanguageReadRepository;

/**
 * Generates select tag with all languages
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class LanguageSelect extends Select{
    /**
     * @var string name of select tag 
     */
    protected $selectName  = "langauge";
    
    /**
     * @var string session admin name for controll content
     */
    protected $sessionName = "_language";
    
    public function __construct(LanguageReadRepository $repository, $config = [])
    {
        parent::__construct($repository, $config);
    }
}
