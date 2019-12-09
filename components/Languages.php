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

use koperdog\yii2sitemanager\repositories\read\LanguageReadRepository;
use koperdog\yii2sitemanager\useCases\LanguageService;

/**
 * Description of Languages
 *
 * @author Koperdog <koperdog@github.com>
 */
class Languages extends \yii\base\Component
{    
    private static $current;
    
    private $languageService;
    private $languageRepository;
    
    public function __construct(LanguageService $service, LanguageReadRepository $repository)
    {
        parent::__construct();
        
        $this->languageService    = $service;
        $this->languageRepository = $repository;
        
        $this->getCurrent(\Yii::$app->language);
    }
    
    public function getCurrent(string $code_local): array
    {
        if(self::$current === null){
            try{
                self::$current = $this->languageRepository->getByCodeLocal($code_local);
            } catch(\DomainException $e){
                self::$current = $this->getDefault();
            }
        }
        
        return self::$current;
    }
    
    public function getCurrentId(): int
    {
        return self::$current['id'];
    }
    
    public function getDefault(): array
    {
        return $this->languageRepository->getDefault();
    }
}
