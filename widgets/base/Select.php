<?php

/**
 * @link https://github.com/koperdog/yii2-treeview
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-sitemanager/blob/master/LICENSE
 */

namespace koperdog\yii2sitemanager\widgets\base;

use koperdog\yii2sitemanager\interfaces\ReadReposotory;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Base class for generating select tag
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class Select extends \yii\base\BaseObject{
    /**
     * @var string name of select tag 
     */
    protected $selectName = "select";
    
    /**
     * @var \yii\base\Widget owner this select tag
     */
    public $select;
    
    /**
     * @var ReadReposotory for getting value
     */
    protected $repository;
    
    /**
     * @var string session admin name for controll content
     */
    protected $sessionName = "_select";
    
    public function __construct(ReadReposotory $repository, $config = [])
    {
        parent::__construct($config);
        
        $this->repository = $repository;
    }
    
    /**
     * Render list section
     * 
     * @return string
     */
    public function render(): string
    {
        $options = ArrayHelper::merge(
                $this->select->optionsList, 
                ['id' => 'change_'.$this->selectName, 'name' => $this->selectName]
                );
        
        $content  = Html::beginTag('select', $options);
        $content .= $this->renderItems();
        $content .= Html::endTag('select');
        
        return $content;
    }
    
    /**
     * Render items
     * 
     * @return string
     */
    protected function renderItems(): string
    {
        $items    = $this->repository->getAll();
        $content .= $this->defaultItemRender(); 
        
        foreach($items as $item){
            $selected = (\Yii::$app->session->get($this->sessionName) == $item['id']);
            $content .= Html::tag('option', $item['name'], ['selected' => $selected, 'value' => $item['id']]);
        }
        
        return $content;
    }
    
    /**
     * Render default item
     * 
     * @return string
     */
    protected function defaultItemRender(): string
    {
        $selected = (\Yii::$app->session->get($this->sessionName) == null);
        return Html::tag('option', \Yii::t('app', 'General'), ['selected' => $selected,'value' => -1]);
    }
}
