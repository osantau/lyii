<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Invoice;

/**
 * InvoiceSearch represents the model behind the search form of `app\models\Invoice`.
 */
class InvoiceSearch extends Invoice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'duedays', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['dateinvoiced', 'duedate', 'paymentdate', 'nr_factura', 'partener', 'moneda', 'is_customer', 'mentiuni', 'credit_note'], 'safe'],
            [['valoare_ron', 'suma_achitata_ron', 'sold_ron', 'valoare_eur', 'suma_achitata_eur', 'sold_eur', 'diferenta'], 'number'],
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
        $query = Invoice::find();

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
            'duedays' => $this->duedays,
            'paymentdate' => $this->paymentdate,
            'valoare_ron' => $this->valoare_ron,
            'suma_achitata_ron' => $this->suma_achitata_ron,
            'sold_ron' => $this->sold_ron,
            'valoare_eur' => $this->valoare_eur,
            'suma_achitata_eur' => $this->suma_achitata_eur,
            'sold_eur' => $this->sold_eur,
            'diferenta' => $this->diferenta,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'nr_factura', $this->nr_factura])
            ->andFilterWhere(['like', 'partener', $this->partener])
            ->andFilterWhere(['like', 'moneda', $this->moneda])
            ->andFilterWhere(['like', 'is_customer', $this->is_customer])
            ->andFilterWhere(['like', 'mentiuni', $this->mentiuni])
            ->andFilterWhere(['like', 'credit_note', $this->credit_note]);

        return $dataProvider;
    }
}
