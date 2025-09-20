<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Subregions]].
 *
 * @see Subregions
 */
class SubregionsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Subregions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Subregions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
