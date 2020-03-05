<?php

/**
 * @link https://github.com/koperdog/yii2-sitemanager
 * @copyright Copyright (c) 2019 Koperdog
 * @license https://github.com/koperdog/yii2-sitemanager/blob/master/LICENSE
 */

namespace koperdog\yii2sitemanager\useCases;

use koperdog\yii2sitemanager\repositories\LanguageRepository;
use \koperdog\yii2sitemanager\models\{
    Language, 
    forms\LanguageForm
};

/**
 * Language Service (UseCases) for langauge model
 *
 * @author Koperdog <koperdog@dev.gmail.com>
 * @version 1.0
 */
class LanguageService {
    /**
     * @var LanguageRepository repository of language model
     */
    private $languageRepository;
    
    public function __construct(LanguageRepository $language)
    {
        $this->languageRepository = $language;
    }
    
    /**
     * Updates language
     * @param Language $model
     * @return bool
     */
    public function update(Language $model): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->languageRepository->save($model);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    /**
     * Creates language
     * 
     * @param LanguageForm $form
     * @return bool
     */
    public function create(LanguageForm $form): bool
    {
        $language = new Language([
            'name'       => $form->name,
            'code'       => $form->code,
            'code_local' => $form->code_local,
            'status'     => $form->status,
            'is_default' => $form->is_default,
        ]);
        
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->languageRepository->save($language);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        
        return true;
    }
    
    /**
     * Deletes language
     * 
     * @param Language $model
     * @return bool
     */
    public function delete(Language $model): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $model->unlinkAll('settings', true);
            $this->languageRepository->delete($model);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }
    
    /**
     * Makes default langauge
     * 
     * @param Language $model
     * @return bool
     */
    public function makeDefault(Language $model): bool
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $default = $this->languageRepository->getDefault();
            $default->is_default = false;
            
            $model->is_default   = true;
            $this->languageRepository->save($default);
            $this->languageRepository->save($model);
            $transaction->commit();
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }
}
