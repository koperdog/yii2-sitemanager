<?php

/*
 * Copyright 2019 Koperdog <koperdog@github.com>.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace koperdog\yii2sitemanager\components;

use koperdog\yii2sitemanager\readModels\DomainReadRepository;

/**
 * Description of Domain
 *
 * @author Koperdog <koperdog@github.com>
 */
class Domains extends \yii\base\Component
{
    /**
     * Current domain, SERVER_HOST
     * 
     * @var type string
     */
    private $current;
    
    private $service;
    
    public function __construct(DomainService $service, DomainReadRepository $repository) {
        parent::__construct();
        
        $this->current = \Yii::$app->getRequest()->serverName;
        
        $this->service    = $service;
        $this->repository = $repository;
    }
    
    public function getDomain(): string
    {
        return $this->current;
    }
    
    public function getDefault(): array
    {
        return $this->repository->getDefault();
    }
}
