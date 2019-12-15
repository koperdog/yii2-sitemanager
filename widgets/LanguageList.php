<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace koperdog\yii2sitemanager\widgets;

use yii\helpers\Html;
use yii\helpers\Url;


/**
 * Description of DomainList
 *
 * @author Koperdog <koperdog@github.com>
 */
class LanguageList extends \yii\base\Widget
{
    
    public $link = ['/manager/ajax/change-language'];
    
    public $optionsList = [];
    public $options = ['class' => 'change-zone'];
    
    private $select;
    
    public function init()
    {
        parent::init();
        
        $this->initSelect();
    }

    public function run(): string
    {
        parent::run();
        $view = $this->getView();
        \koperdog\yii2sitemanager\AssetBundle::register($view);
        
        $view->registerJsVar('urlLanguageChange', Url::to($this->link));
        
        return $this->renderList();
    }
    
    private function renderList(): string
    {
        $content  = Html::beginTag('div', $this->options);
        $content .= $this->select->render();
        $content .= Html::endTag('div');
        
        return $content;
    }
    
    private function initSelect(): void
    {        
        $this->select = \Yii::createObject([
            'class'  => base\LanguageSelect::className(),
            'select' => $this
        ]);
    }
}
