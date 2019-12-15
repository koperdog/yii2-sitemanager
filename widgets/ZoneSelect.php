<?php

namespace koperdog\yii2sitemanager\widgets;

use yii\helpers\Html;

class ZoneSelect extends \yii\base\Widget{
    
    public $formUrl = ['ajax/change'];
    
    public $optionsList = [];
    public $optionsItem = [];
    public $optionsLink = [];

    private $selects;
    
    public function init() {
        parent::init();
        
        $this->initSelects();
    }

    public function run(): string {
        parent::run();
        
        return $this->render();
    }
    
    private function render(): string
    {
        $content  = Html::beginTag('div', $this->options)
        
        $content .= $this->renderSelects();
        $content .= $this->renderSendBtn();
        
        $content .= Html::endForm();
        
        return $content;
    }
    
    private function renderSelects(): string
    {
        $content = '';
        
        foreach($this->selects as $select){
            $content .= $select->render();
        }
        
        return $content;
    }
    
    private function initSelects(): void
    {
        $this->selects['language'] =  \Yii::createObject([
            'class'  => base\LanguageSelect::className(),
            'select' => $this
        ]);
        
        $this->selects['domain'] =  \Yii::createObject([
            'class'  => base\DomainSelect::className(),
            'select' => $this
        ]);
    }
    
    private function renderSendBtn(): string
    {
        return Html::submitButton($this->sendButtonText, $this->optionsSendButton);
    }
}
