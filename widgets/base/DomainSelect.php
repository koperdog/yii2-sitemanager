<?php

/**
 * @link https://github.com/koperdog/yii2-sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-sitemanager/blob/master/LICENSE
 */

namespace koperdog\yii2sitemanager\widgets\base;

use koperdog\yii2sitemanager\repositories\read\DomainReadRepository;

/**
 * Generates select tag with all domains
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class DomainSelect extends Select{
    
    /**
     * @var string name of select tag 
     */
    protected $selectName = "domain";
    
    /**
     * @var string session admin name for controll content
     */
    protected $sessionName = "_domain";
    
    public function __construct(DomainReadRepository $repository, $config = [])
    {
        parent::__construct($repository, $config);
    }
}
