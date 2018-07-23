<?php

namespace app\modules\dashboard\searchModels;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\dashboard\models\Product;

/**
 * ProductSearch represents the model behind the search form of `app\modules\dashboard\models\Product`.
 */
class ProductSearch extends Product
{
    public $search;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['name', 'alias', 'code', 'text', 'seo_title', 'seo_keywords', 'seo_description', 'new', 'sale', 'create_at', 'update_at'], 'safe'],
            [['price'], 'number'],
            [['search'], 'string', 'min' => 3],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Product::find();

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

        if (isset($this->search)) {
            $query->andFilterWhere(
                ['like', 'name', $this->search]
            );
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_keywords', $this->seo_keywords])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description])
            ->andFilterWhere(['like', 'new', $this->new])
            ->andFilterWhere(['like', 'sale', $this->sale])
            ->andFilterWhere(['like','search',$this->name]);

        return $dataProvider;
    }

    public function searchByProduct($params) {
        if (!isset($params['ProductSearch'])) {
            $params['ProductSearch'] = $params;
        }
        return $this->search($params);
    }
}
