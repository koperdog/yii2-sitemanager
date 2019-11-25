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

/**
 * Description of Manager
 *
 * @author Koperdog <koperdog@github.com>
 */
class Manager  extends \yii\base\Component
{
    public $settings;
    public $domains;
    public $language;
    
    public $domain = "";
    
    public function __construct()
    {
        parent::__construct();
        $this->domains  = new Domains();
        $this->language = new Languages(); 
        $this->settings = new Settings($this->domains, $this->language);
        
        $this->domain = $this->domains->getDomain();
    }
}
