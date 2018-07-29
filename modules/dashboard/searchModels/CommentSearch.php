<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 29.07.18
 * Time: 17:36
 */

namespace app\modules\dashboard\searchModels;


use app\modules\dashboard\models\Comment;
use app\modules\dashboard\models\Product;
Use app\modules\user\models\User;
use yii\data\ActiveDataProvider;

class CommentSearch extends Comment {

    public function rules()
    {
        return [
            [['user_id', 'product_id', 'active'], 'integer'],
            [['text','username'], 'string'],
            [['create_at', 'update_at'], 'safe'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function search($params) {
        $query = Comment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'active' => $this->active,
            'username' => $this->username,
            'create_at' => $this->create_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->username]);

        return $dataProvider;
    }
}