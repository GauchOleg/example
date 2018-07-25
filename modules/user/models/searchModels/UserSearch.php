<?php

namespace app\modules\user\models\searchModels;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\user\models\User;
use app\modules\user\models\UserMeta;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property int $role
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 * @property string $referral_code
 * @property string $create_date
 * @property int $status
 *
 * @property UserMeta[] $userMetas
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'role', 'password', 'auth_key', 'access_token', 'referral_code', 'create_date', 'status'], 'safe'],
            [['role', 'status'], 'integer'],
            [['create_date'], 'safe'],
            [['username'], 'string', 'max' => 60],
            [['email'], 'string', 'max' => 100],
            [['password'], 'string', 'max' => 64],
            [['auth_key'], 'string', 'max' => 32],
            [['access_token'], 'string', 'max' => 40],
            [['referral_code'], 'string', 'max' => 12],
            [['referral_code'], 'unique'],
            [['username'], 'unique'],
            [['email'], 'unique'],
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
        $query = User::find();

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
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
