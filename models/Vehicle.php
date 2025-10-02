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
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $exp_adr_start
 * @property string|null $exp_adr_end
 * @property string|null $imp_adr_start
 * @property string|null $imp_adr_end
 * @property User $createdBy
 * @property User $updatedBy
 * @property string $info
 * @property TransportOrder $transportOrder
 * @property int $exp_adr_start_id
 * @property int $exp_adr_end_id
 * @property int $imp_adr_start_id
 * @property int $imp_adr_end_id
 */
class Vehicle extends \yii\db\ActiveRecord
{

    const STATUS_LIBER=0;
    const STATUS_OCUPAT=1;

    const STATUS_OPRIT=2;
    const STATUS_MARFA_GARAJ=3;

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
            [['created_at', 'updated_at', 'created_by', 'updated_by','transport_order_id','exp_adr_start_id','exp_adr_end_id','imp_adr_end_id','imp_adr_start_id'],
             'integer'],
            [['regno'], 'string', 'max' => 50],
            [['info','exp_adr_start', 'exp_adr_end', 'imp_adr_start', 'imp_adr_end'],'string', 'max'=>100],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['status'],'integer'],
            [['status'],'default','value'=>self::STATUS_LIBER],
            [['start_date', 'end_date'], 'safe'],
            [['info', 'start_date', 'end_date'], 'default', 'value' => null],
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
            'status'=>'Stare',
            'exp_adr_start' => 'Adresa Incarcare',
            'exp_adr_end' => 'Adresa Descarcare',
            'imp_adr_start' => 'Adresa Incarcare',
            'imp_adr_end' => 'Adresa Descarcare',
            'start_date' => 'Data Incarcare',
            'end_date' => 'Data Descarcare',
            'transport_order_id'=>'Comanda Transport',
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
          /*  if($this->status==0)
            {
                if($this->transportOrder !=null) {
                $this->transportOrder->status=2;
                $this->transportOrder->save();
                }
                $this->transport_order_id=null;
                $this->start_date=null;
                $this->end_date=null;
                $this->exp_adr_start=null;
                $this->exp_adr_end=null;                
                $this->imp_adr_start=null;
                $this->imp_adr_end=null;                
                $this->info=null;
                $this->exp_adr_start_id=0;
                $this->exp_adr_end_id=0;
                $this->imp_adr_start_id=0;
                $this->imp_adr_end_id=0;
            } */
            return true;
        }
        return false;
    }

    public static function getStatusList() {
        return[
            self::STATUS_LIBER=>'Liber',
            self::STATUS_OCUPAT=> 'Ocupat',
            self::STATUS_OPRIT=> 'Oprit',
            self::STATUS_MARFA_GARAJ=>'Marfuri La Garaj',
        ];
    }

    public function getStatusName(){
        return self::getStatusList()[$this->status]??'Necunoscut';
    }

      /**
     * Gets query for [[TransportOrder]].
     *
     * @return \yii\db\ActiveQuery|TransportOrderQuery
     */
    public function getTransportOrder()
    {
        return $this->hasOne(TransportOrder::class, ['id' => 'transport_order_id']);
    }

    public function getCityInfo($adrId)
    {
        $location = Location::findOne(['id'=>$adrId]);
        return $location->city??'';
    }
    
}
