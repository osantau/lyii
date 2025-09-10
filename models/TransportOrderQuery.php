<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TransportOrder]].
 *
 * @see TransportOrder
 */
class TransportOrderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TransportOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TransportOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
