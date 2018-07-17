<?php

namespace app\modules\dashboard\searchModels;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\dashboard\models\Cart as CartModel;

/**
 * Cart represents the model behind the search form of `app\modules\dashboard\models\Cart`.
 */
class Cart extends CartModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'finished', 'product_id', 'count', 'delivery', 'prices', 'total_price'], 'integer'],
            [['order_id', 'product_info', 'customer_name', 'customer_phone', 'customer_email', 'session_id', 'create_at', 'update_at', 'customer_l_name', 'customer_o_name', 'product_code', 'address'], 'safe'],
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
        $query = CartModel::find();

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
            'status' => $this->status,
            'finished' => $this->finished,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
            'product_id' => $this->product_id,
            'count' => $this->count,
            'delivery' => $this->delivery,
            'prices' => $this->prices,
            'total_price' => $this->total_price,
        ]);

        $query->andFilterWhere(['like', 'order_id', $this->order_id])
            ->andFilterWhere(['like', 'product_info', $this->product_info])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'customer_phone', $this->customer_phone])
            ->andFilterWhere(['like', 'customer_email', $this->customer_email])
            ->andFilterWhere(['like', 'session_id', $this->session_id])
            ->andFilterWhere(['like', 'customer_l_name', $this->customer_l_name])
            ->andFilterWhere(['like', 'customer_o_name', $this->customer_o_name])
            ->andFilterWhere(['like', 'product_code', $this->product_code])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
