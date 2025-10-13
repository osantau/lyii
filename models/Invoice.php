<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "invoice".
 *
 * @property int $id
 * @property string $dateinvoiced
 * @property string $duedate
 * @property int $duedays
 * @property string|null $paymentdate
 * @property string $nr_factura
 * @property string $partener
 * @property float|null $valoare_ron
 * @property float|null $suma_achitata_ron
 * @property float|null $sold_ron
 * @property float|null $valoare_eur
 * @property float|null $suma_achitata_eur
 * @property float|null $sold_eur
 * @property float|null $diferenta
 * @property string $moneda
 * @property string $is_customer
 * @property string|null $mentiuni
 * @property string|null $credit_note
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class Invoice extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paymentdate', 'mentiuni', 'credit_note', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['duedays'], 'default', 'value' => 0],
            [['diferenta'], 'default', 'value' => 0.00],
            [['moneda'], 'default', 'value' => ''],
            [['is_customer'], 'default', 'value' => 'Y'],
            [['dateinvoiced', 'duedate', 'nr_factura', 'partener', 'created_at', 'updated_at'], 'required'],
            [['dateinvoiced', 'duedate', 'paymentdate'], 'safe'],
            [['duedays', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['valoare_ron', 'suma_achitata_ron', 'sold_ron', 'valoare_eur', 'suma_achitata_eur', 'sold_eur', 'diferenta'], 'number'],
            [['nr_factura'], 'string', 'max' => 50],
            [['partener'], 'string', 'max' => 100],
            [['moneda'], 'string', 'max' => 3],
            [['is_customer'], 'string', 'max' => 1],
            [['mentiuni', 'credit_note'], 'string', 'max' => 4000],
            [['nr_factura'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dateinvoiced' => 'Dateinvoiced',
            'duedate' => 'Duedate',
            'duedays' => 'Duedays',
            'paymentdate' => 'Paymentdate',
            'nr_factura' => 'Nr Factura',
            'partener' => 'Partener',
            'valoare_ron' => 'Valoare Ron',
            'suma_achitata_ron' => 'Suma Achitata Ron',
            'sold_ron' => 'Sold Ron',
            'valoare_eur' => 'Valoare Eur',
            'suma_achitata_eur' => 'Suma Achitata Eur',
            'sold_eur' => 'Sold Eur',
            'diferenta' => 'Diferenta',
            'moneda' => 'Moneda',
            'is_customer' => 'Is Customer',
            'mentiuni' => 'Mentiuni',
            'credit_note' => 'Credit Note',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
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
     * @return InvoiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InvoiceQuery(get_called_class());
    }

}
