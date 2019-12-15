<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace koperdog\yii2sitemanager\widgets\base;

use koperdog\yii2sitemanager\repositories\read\DomainReadRepository;

/**
 * Description of baseSelect
 *
 * @author Koperdog <koperdog@github.com>
 */
class DomainSelect extends Select{
    
    protected $selectName = "domain";
    
    protected $sessionName = "_domain";
    
    public function __construct(DomainReadRepository $repository, $config = [])
    {
        parent::__construct($repository, $config);
    }
}
