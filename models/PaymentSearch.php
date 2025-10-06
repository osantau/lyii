<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Payment;

/**
 * PaymentSearch represents the model behind the search form of `app\models\Payment`.
 */
class PaymentSearch extends Payment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['is_receipt', 'dateinvoiced', 'duedate', 'nr_cmd_trs', 'nr_factura', 'partener', 'ron', 'eur', 'paymentdate', 'bank', 'mentiuni'], 'safe'],
            [['valoare_ron', 'suma_achitata_ron', 'sold_ron', 'valoare_eur', 'suma_achitata_eur', 'sold_eur'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Payment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'dateinvoiced' => $this->dateinvoiced,
            'duedate' => $this->duedate,
            'valoare_ron' => $this->valoare_ron,
            'suma_achitata_ron' => $this->suma_achitata_ron,
            'sold_ron' => $this->sold_ron,
            'valoare_eur' => $this->valoare_eur,
            'suma_achitata_eur' => $this->suma_achitata_eur,
            'sold_eur' => $this->sold_eur,
            'paymentdate' => $this->paymentdate,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'is_receipt', $this->is_receipt])
            ->andFilterWhere(['like', 'nr_cmd_trs', $this->nr_cmd_trs])
            ->andFilterWhere(['like', 'nr_factura', $this->nr_factura])
            ->andFilterWhere(['like', 'partener', $this->partener])
            ->andFilterWhere(['like', 'ron', $this->ron])
            ->andFilterWhere(['like', 'eur', $this->eur])
            ->andFilterWhere(['like', 'bank', $this->bank])
            ->andFilterWhere(['like', 'mentiuni', $this->mentiuni]);

        return $dataProvider;
    }
}
