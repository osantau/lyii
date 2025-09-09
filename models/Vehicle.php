<?php

namespace app\models;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "vehicle".
 *
 * @property int $id
 * @property string $regno
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property string $info
 */
class Vehicle extends \yii\db\ActiveRecord
{

    const STATUS_LIBER=0;
    const STATUS_OCUPAT=1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['regno'], 'required'],
            [['regno'], 'unique'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['regno'], 'string', 'max' => 50],
            [['info'],'string', 'max'=>100],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['status'],'integer'],
            [['status'],'default','value'=>self::STATUS_LIBER],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'regno' => 'Nr. Inmatriculare',
            'created_at' => 'Data Creare',
            'updated_at' => 'Ultima Modificare',
            'created_by' => 'Creat De',
            'updated_by' => 'Actualizat De',
            'info'=> 'Info',
        ];
    }
  public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
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
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * {@inheritdoc}
     * @return VehicleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VehicleQuery(get_called_class());
    }

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            $this->regno=trim(strtoupper($this->regno));
            return true;
        }
        return false;
    }

    public static function getStatusList() {
        return[
            self::STATUS_LIBER=>'Liber',
            self::STATUS_OCUPAT=> 'In Cursa',
        ];
    }

    public function getStatusName(){
        return self::getStatusList()[$this->status]??'Necunoscut';
    }

}
