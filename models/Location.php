<?php

namespace app\models;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "location".
 *
 * @property int $id
 * @property int $countries_id
 * @property int $states_id
 * @property int $cities_id
 * @property string $address
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property Countries $country
 * @property States $ctate
 * @property Cities $city
 * 

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
            [['countries_id', 'states_id', 'cities_id', 'address'], 'required'],
            [['countries_id', 'states_id', 'cities_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
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
            'states_id' => 'Regiune',
            'cities_id' => 'Localitate',
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

     public function getCountry()
    {
        return $this->hasOne(Countries::class, ['id' => 'countries_id']);
    }
    public function getState()
    {
        return $this->hasOne(States::class, ['id' => 'states_id']);
    }
    public function getCity()
    {
        return $this->hasOne(Cities::class, ['id' => 'cities_id']);
    }

}
