<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property int $id
 * @property string $name
 * @property string|null $iso3
 * @property string|null $numeric_code
 * @property string|null $iso2
 * @property string|null $phonecode
 * @property string|null $capital
 * @property string|null $currency
 * @property string|null $currency_name
 * @property string|null $currency_symbol
 * @property string|null $tld
 * @property string|null $native
 * @property string|null $region
 * @property int|null $region_id
 * @property string|null $subregion
 * @property int|null $subregion_id
 * @property string|null $nationality
 * @property string|null $timezones
 * @property string|null $translations
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $emoji
 * @property string|null $emojiU
 * @property string|null $created_at
 * @property string $updated_at
 * @property int $flag
 * @property string|null $wikiDataId Rapid API GeoDB Cities
 *
 * @property Cities[] $cities
 * @property Regions $region0
 * @property States[] $states
 * @property Subregions $subregion0
 */
class Countries extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iso3', 'numeric_code', 'iso2', 'phonecode', 'capital', 'currency', 'currency_name', 'currency_symbol', 'tld', 'native', 'region', 'region_id', 'subregion', 'subregion_id', 'nationality', 'timezones', 'translations', 'latitude', 'longitude', 'emoji', 'emojiU', 'created_at', 'wikiDataId'], 'default', 'value' => null],
            [['flag'], 'default', 'value' => 1],
            [['name'], 'required'],
            [['region_id', 'subregion_id', 'flag'], 'integer'],
            [['timezones', 'translations'], 'string'],
            [['latitude', 'longitude'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['iso3', 'numeric_code'], 'string', 'max' => 3],
            [['iso2'], 'string', 'max' => 2],
            [['phonecode', 'capital', 'currency', 'currency_name', 'currency_symbol', 'tld', 'native', 'region', 'subregion', 'nationality', 'wikiDataId'], 'string', 'max' => 255],
            [['emoji', 'emojiU'], 'string', 'max' => 191],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::class, 'targetAttribute' => ['region_id' => 'id']],
            [['subregion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subregions::class, 'targetAttribute' => ['subregion_id' => 'id']],
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
            'iso3' => 'Iso3',
            'numeric_code' => 'Numeric Code',
            'iso2' => 'Iso2',
            'phonecode' => 'Phonecode',
            'capital' => 'Capital',
            'currency' => 'Currency',
            'currency_name' => 'Currency Name',
            'currency_symbol' => 'Currency Symbol',
            'tld' => 'Tld',
            'native' => 'Native',
            'region' => 'Region',
            'region_id' => 'Region ID',
            'subregion' => 'Subregion',
            'subregion_id' => 'Subregion ID',
            'nationality' => 'Nationality',
            'timezones' => 'Timezones',
            'translations' => 'Translations',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'emoji' => 'Emoji',
            'emojiU' => 'Emoji U',
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
        return $this->hasMany(Cities::class, ['country_id' => 'id']);
    }

    /**
     * Gets query for [[Region0]].
     *
     * @return \yii\db\ActiveQuery|RegionsQuery
     */
    public function getRegion0()
    {
        return $this->hasOne(Regions::class, ['id' => 'region_id']);
    }

    /**
     * Gets query for [[States]].
     *
     * @return \yii\db\ActiveQuery|StatesQuery
     */
    public function getStates()
    {
        return $this->hasMany(States::class, ['country_id' => 'id']);
    }

    /**
     * Gets query for [[Subregion0]].
     *
     * @return \yii\db\ActiveQuery|SubregionsQuery
     */
    public function getSubregion0()
    {
        return $this->hasOne(Subregions::class, ['id' => 'subregion_id']);
    }

    /**
     * {@inheritdoc}
     * @return CountriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountriesQuery(get_called_class());
    }

}
