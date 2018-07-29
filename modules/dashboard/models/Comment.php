<?php

namespace app\modules\dashboard\models;

use app\modules\user\models\UserMeta;
use Yii;
use app\modules\user\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property string $text
 * @property string $username
 * @property int $active
 * @property string $create_at
 * @property string $update_at
 *
 * @property Product $product
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    const DEFAULT_USERNAME = 'Гость';
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'product_id' => Yii::t('app', 'Ссылка на товар'),
            'text' => Yii::t('app', 'Текст комментария'),
            'username' => Yii::t('app', 'Логин'),
            'active' => Yii::t('app', 'Активность'),
            'create_at' => Yii::t('app', 'Дата'),
            'update_at' => Yii::t('app', 'Update At'),
        ];
    }
    
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->create_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getAllCommentsByProductId($product_id) {
        return self::find()->where(['product_id' => $product_id])->andWhere(['active' => 1])->all();
    }
    
    public function addComment() {
        $this->username = $this->getUserNameByUserId($this->user_id);
        $this->active = false;
        if ($this->save(false)) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserNameByUserId($user_id) {
        if (empty($user_id)) {
            return self::DEFAULT_USERNAME;
        }
        $userMeta = new UserMeta();
        $username = $userMeta->getValueByKeyAndUserId($user_id,'first_name');
        if (!empty($username)) {
            return $username;
        } else {
            return self::DEFAULT_USERNAME;
        }
    }

    public function getStatusList() {
        return [
            self::STATUS_ACTIVE => 'Да',
            self::STATUS_INACTIVE => 'Нет',
        ];
    }

    public function getActiveStatus() {
        $color = '';
        $text = '';
        switch ($this->active) {
            case 1 : $color = 'success'; $text = 'Да';
                break;
            case 0 : $color = 'danger'; $text = 'Нет';
                break;
        }
        return '<a href="'. Url::to(['/dashboard/comment/update-status?id=' . $this->id]) .'" class="label label-sm label-' . $color .' status">' . $text . '</a>';
    }

    public function getCommentById($id) {
        return self::findOne($id);
    }

    public function getProductLink() {
        $product = Product::find()->where(['id' => $this->product_id])->one();

        return Html::a($product->name,['/product/view','alias' => $product->alias],['target' => '_blank']);

    }

    public function getUserName() {
        if (!is_null($this->user_id)) {
            $user = new User();
            $user->findUserById($this->user_id);
            return $user->username;
        } else {
            return 'Не зарегистрирован';
        }
    }
}
