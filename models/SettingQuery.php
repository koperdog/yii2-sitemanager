<?php

namespace koperdog\yii2sitemanager\models;

/**
 * This is the ActiveQuery class for [[Setting]].
 *
 * @see Setting
 */
class SettingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Setting[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Setting|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
//    public function findByStatus($status = null, $domain_id = null, $language_id = null)
//    {
//        return $this->hasOne(SettingAssign::className(), ['setting_id' => 'id'])
//                ->andFilterWhere(['domain_id' => $domain_id]);
//    }
}
