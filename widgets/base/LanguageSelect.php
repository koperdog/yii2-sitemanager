<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace koperdog\yii2sitemanager\widgets\base;

use koperdog\yii2sitemanager\repositories\read\LanguageReadRepository;

/**
 * Description of baseSelect
 *
 * @author Koperdog <koperdog@github.com>
 */
class LanguageSelect extends Select{
    
    protected $selectName  = "langauge";
    
    protected $sessionName = "_language";
    
    public function __construct(LanguageReadRepository $repository, $config = [])
    {
        parent::__construct($repository, $config);
    }
}
