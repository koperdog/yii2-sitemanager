<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace koperdog\yii2settings\useCases;

use koperdog\yii2settings\repositories\{
    SettingRepository,
    DomainRepository,
    LanguageRepository
};

/**
 * Description of SettingService
 *
 * @author Koperdog <koperdog@github.com>
 */
class LanguageService {
    private $setting;
    private $domain;
    private $language;
    
    public function __construct(DomainRepository $setting, SettingRepository $domain, LanguageRepository $language)
    {
        $this->setting  = $setting;
        $this->domain   = $domain;
        $this->language = $language;
    }
    
}
