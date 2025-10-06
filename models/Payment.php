<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property string $is_receipt
 * @property string $dateinvoiced
 * @property string $duedate
 * @property string $nr_cmd_trs
 * @property string $nr_factura
 * @property string $partener
 * @property float|null $valoare_ron
 * @property float|null $suma_achitata_ron
 * @property float|null $sold_ron
 * @property float|null $valoare_eur
 * @property float|null $suma_achitata_eur
 * @property float|null $sold_eur
 * @property string|null $ron
 * @property string|null $eur
 * @property string|null $paymentdate
 * @property string|null $bank
 * @property string|null $mentiuni
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class Payment extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paymentdate', 'mentiuni', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['is_receipt'], 'default', 'value' => 'N'],
            [['sold_eur'], 'default', 'value' => 0.00],
            [['ron'], 'default', 'value' => 'RON'],
            [['eur'], 'default', 'value' => 'EUR'],
            [['bank'], 'default', 'value' => ''],
            [['dateinvoiced', 'duedate', 'nr_cmd_trs', 'nr_factura', 'partener', 'created_at', 'updated_at'], 'required'],
            [['dateinvoiced', 'duedate', 'paymentdate'], 'safe'],
            [['valoare_ron', 'suma_achitata_ron', 'sold_ron', 'valoare_eur', 'suma_achitata_eur', 'sold_eur'], 'number'],
            [['mentiuni'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['is_receipt'], 'string', 'max' => 1],
            [['nr_cmd_trs', 'nr_factura'], 'string', 'max' => 50],
            [['partener', 'bank'], 'string', 'max' => 100],
            [['ron', 'eur'], 'string', 'max' => 3],
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
            'is_receipt' => 'Incasare',
            'dateinvoiced' => 'Data Factura',
            'duedate' => 'Data Scadenta',
            'nr_cmd_trs' => 'Nr Cmd Trs',
            'nr_factura' => 'Nr Factura',
            'partener' => 'Furnizor',
            'valoare_ron' => 'Valoare RON',
            'suma_achitata_ron' => 'Suma Achitata',
            'sold_ron' => 'Sold',
            'valoare_eur' => 'Valoare EURO',
            'suma_achitata_eur' => 'Suma Achitata',
            'sold_eur' => 'Sold',
            'ron' => 'RON',
            'eur' => 'EUR',
            'paymentdate' => 'Data Achitarii',
            'bank' => 'Banca',
            'mentiuni' => 'Mentiuni',
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
     * @return PaymentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PaymentQuery(get_called_class());
    }

}
