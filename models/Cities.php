<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property string $name
 * @property int $state_id
 * @property string $state_code
 * @property int $country_id
 * @property string $country_code
 * @property float $latitude
 * @property float $longitude
 * @property string|null $timezone IANA timezone identifier (e.g., America/New_York)
 * @property string $created_at
 * @property string $updated_at
 * @property int $flag
 * @property string|null $wikiDataId Rapid API GeoDB Cities
 *
 * @property Countries $country
 * @property States $state
 */
class Cities extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['timezone', 'wikiDataId'], 'default', 'value' => null],
            [['created_at'], 'default', 'value' => '2014-01-01 12:01:01'],
            [['flag'], 'default', 'value' => 1],
            [['name', 'state_id', 'state_code', 'country_id', 'country_code', 'latitude', 'longitude'], 'required'],
            [['state_id', 'country_id', 'flag'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'state_code', 'timezone', 'wikiDataId'], 'string', 'max' => 255],
            [['country_code'], 'string', 'max' => 2],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => States::class, 'targetAttribute' => ['state_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::class, 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'state_id' => 'State ID',
            'state_code' => 'State Code',
            'country_id' => 'Country ID',
            'country_code' => 'Country Code',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'timezone' => 'Timezone',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'flag' => 'Flag',
            'wikiDataId' => 'Wiki Data ID',
        ];
    }

    /**
     * Gets query for [[Country]].
     *
     * @return \yii\db\ActiveQuery|CountriesQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Countries::class, ['id' => 'country_id']);
    }

    /**
     * Gets query for [[State]].
     *
     * @return \yii\db\ActiveQuery|StatesQuery
     */
    public function getState()
    {
        return $this->hasOne(States::class, ['id' => 'state_id']);
    }

    /**
     * {@inheritdoc}
     * @return CitiesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CitiesQuery(get_called_class());
    }

}
