<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "location".
 *
 * @property int $id
 * @property int $countries_id
 * @property int $states_id
 * @property int $cities_id
 * @property int $partner_id
 * @property string $company
 * @property string $country
 * @property string $region
 * @property string $city
 * @property string $address
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 */
class Location extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'location';
    }
        public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by'], 'default', 'value' => null],
            [['partner_id'], 'default', 'value' => 0],
            [['address'], 'default', 'value' => ''],
            [['company', 'city','address','country'], 'required'],
            [['countries_id', 'states_id', 'cities_id', 'partner_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['company', 'country', 'city'], 'string', 'max' => 100],
            [['region'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'countries_id' => 'Tara',
            'states_id' => 'States ID',
            'cities_id' => 'Cities ID',
            'partner_id' => 'Firma',
            'company' => 'Firma',
            'country' => 'Tara',
            'region' => 'Regiune',
            'city' => 'Oras',
            'address' => 'Adresa',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * {@inheritdoc}
     * @return LocationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LocationQuery(get_called_class());
    }
   /*public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            $this->countries_id=Countries::find()->where(['name'=>$this->country])->one()->id;
            return true;
        }
        return false;
    } */
}
