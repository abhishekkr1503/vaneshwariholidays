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
            [['id', 'invoiceId', 'companyId'], 'integer'],
            [['buyerName', 'buyerAddress', 'date'], 'safe'],
            [['gst', 'totalAmount'], 'number'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Invoice::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'invoiceId' => $this->invoiceId,
            'date' => $this->date,
            'companyId' => $this->companyId,
            'totalAmount' => $this->totalAmount,
        ]);

        $query->andFilterWhere(['like', 'buyerName', $this->buyerName])
            ->andFilterWhere(['like', 'buyerAddress', $this->buyerAddress]);

        $query->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
