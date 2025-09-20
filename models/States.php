<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "states".
 *
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property string $country_code
 * @property string|null $fips_code
 * @property string|null $iso2
 * @property string|null $iso3166_2
 * @property string|null $type
 * @property int|null $level
 * @property int|null $parent_id
 * @property string|null $native
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $timezone IANA timezone identifier (e.g., America/New_York)
 * @property string|null $created_at
 * @property string $updated_at
 * @property int $flag
 * @property string|null $wikiDataId Rapid API GeoDB Cities
 *
 * @property Cities[] $cities
 * @property Countries $country
 */
class States extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'states';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fips_code', 'iso2', 'iso3166_2', 'type', 'level', 'parent_id', 'native', 'latitude', 'longitude', 'timezone', 'created_at', 'wikiDataId'], 'default', 'value' => null],
            [['flag'], 'default', 'value' => 1],
            [['name', 'country_id', 'country_code'], 'required'],
            [['country_id', 'level', 'parent_id', 'flag'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'fips_code', 'iso2', 'native', 'timezone', 'wikiDataId'], 'string', 'max' => 255],
            [['country_code'], 'string', 'max' => 2],
            [['iso3166_2'], 'string', 'max' => 10],
            [['type'], 'string', 'max' => 191],
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
            'country_id' => 'Country ID',
            'country_code' => 'Country Code',
            'fips_code' => 'Fips Code',
            'iso2' => 'Iso2',
            'iso3166_2' => 'Iso3166 2',
            'type' => 'Type',
            'level' => 'Level',
            'parent_id' => 'Parent ID',
            'native' => 'Native',
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
     * Gets query for [[Cities]].
     *
     * @return \yii\db\ActiveQuery|CitiesQuery
     */
    public function getCities()
    {
        return $this->hasMany(Cities::class, ['state_id' => 'id']);
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
     * {@inheritdoc}
     * @return StatesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StatesQuery(get_called_class());
    }

}
