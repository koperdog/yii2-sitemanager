<?php

/**
 * @link https://github.com/koperdog/yii2-treeview
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-sitemanager/blob/master/LICENSE
 */

namespace koperdog\yii2sitemanager\widgets;

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Widget domains list, changes admin domain for controll content
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class DomainList extends \yii\base\Widget
{
    /**
     * @var array|string Link controller change domain
     */
    public $link = ['/manager/ajax/change-domain'];
    
    /**
     * @var array options of tag select
     */
    public $optionsList = [];
    
    /**
     * @var array options for wrapper
     */
    public $options = ['class' => 'change-zone'];
    
    /**
     * select koperdog\yii2sitemanager\widgets\base\DomainSelect
     */
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
        
        $view->registerJsVar('urlDomainChange', Url::to($this->link));
        
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
            'class'  => base\DomainSelect::className(),
            'select' => $this
        ]);
    }
}
