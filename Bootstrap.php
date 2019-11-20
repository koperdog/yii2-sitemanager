<?php

namespace koperdog\yii2settings;

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

namespace koperdog\yii2settings;

use Yii;
use yii\base\BootstrapInterface;

/**
 * Description of Bootstrap
 *
 * @author Koperdog <koperdog@github.com>
 * @version 1.0
 */
class Bootstrap implements BootstrapInterface{
    
    public function bootstrap($app)
    {
        SettingsForm::$html = $app->view->renderAjax('views/fields/text', ['text' => "AGA TEST"]);
        exit;
    }
}
