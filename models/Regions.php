<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "regions".
 *
 * @property int $id
 * @property string $name
 * @property string|null $translations
 * @property string|null $created_at
 * @property string $updated_at
 * @property int $flag
 * @property string|null $wikiDataId Rapid API GeoDB Cities
 *
 * @property Countries[] $countries
 * @property Subregions[] $subregions
 */
class Regions extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'regions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['translations', 'created_at', 'wikiDataId'], 'default', 'value' => null],
            [['flag'], 'default', 'value' => 1],
            [['name'], 'required'],
            [['translations'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['flag'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['wikiDataId'], 'string', 'max' => 255],
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
        return $this->hasMany(Countries::class, ['region_id' => 'id']);
    }

    /**
     * Gets query for [[Subregions]].
     *
     * @return \yii\db\ActiveQuery|SubregionsQuery
     */
    public function getSubregions()
    {
        return $this->hasMany(Subregions::class, ['region_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return RegionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RegionsQuery(get_called_class());
    }

}
