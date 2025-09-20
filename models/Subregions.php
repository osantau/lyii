<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subregions".
 *
 * @property int $id
 * @property string $name
 * @property string|null $translations
 * @property int $region_id
 * @property string|null $created_at
 * @property string $updated_at
 * @property int $flag
 * @property string|null $wikiDataId Rapid API GeoDB Cities
 *
 * @property Countries[] $countries
 * @property Regions $region
 */
class Subregions extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subregions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['translations', 'created_at', 'wikiDataId'], 'default', 'value' => null],
            [['flag'], 'default', 'value' => 1],
            [['name', 'region_id'], 'required'],
            [['translations'], 'string'],
            [['region_id', 'flag'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['wikiDataId'], 'string', 'max' => 255],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::class, 'targetAttribute' => ['region_id' => 'id']],
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
            'translations' => 'Translations',
            'region_id' => 'Region ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'flag' => 'Flag',
            'wikiDataId' => 'Wiki Data ID',
        ];
    }

    /**
     * Gets query for [[Countries]].
     *
     * @return \yii\db\ActiveQuery|CountriesQuery
     */
    public function getCountries()
    {
        return $this->hasMany(Countries::class, ['subregion_id' => 'id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery|RegionsQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Regions::class, ['id' => 'region_id']);
    }

    /**
     * {@inheritdoc}
     * @return SubregionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubregionsQuery(get_called_class());
    }

}
