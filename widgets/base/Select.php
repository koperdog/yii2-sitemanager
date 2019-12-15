<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace koperdog\yii2sitemanager\widgets\base;

use koperdog\yii2sitemanager\interfaces\ReadReposotory;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Description of baseSelect
 *
 * @author Koperdog <koperdog@github.com>
 */
class Select extends \yii\base\BaseObject{
    
    protected $selectName = "select";
    
    public $select;
    
    protected $repository;
    
    protected $sessionName = "_select";
    
    public function __construct(ReadReposotory $repository, $config = [])
    {
        parent::__construct($config);
        
        $this->repository = $repository;
    }
    
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
    
    protected function defaultItemRender(): string
    {
        $selected = (\Yii::$app->session->get($this->sessionName) == null);
        return Html::tag('option', \Yii::t('app', 'General'), ['selected' => $selected,'value' => -1]);
    }
}
