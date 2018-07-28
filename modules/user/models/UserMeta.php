<?php

namespace app\modules\user\models;

use Yii;
use yii\web\UploadedFile;
use app\helpers\FileUploaderHelper;
/**
 * This is the model class for table "{{%user_meta}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $meta_key
 * @property string $meta_value
 *
 * @property Users $user
 *
 * use meta_key for client profile: 'first_name','last_name','add_phone','about','site','image','spam'
 */
class UserMeta extends \yii\db\ActiveRecord {

    public $image;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_meta}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id'], 'integer'],
            [['meta_key', 'meta_value'], 'required'],
            [['meta_key'], 'string', 'max' => 255],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id'            => Yii::t('user', 'ID'),
            'user_id'       => Yii::t('user', 'User ID'),
            'meta_key'      => Yii::t('user', 'Meta Key'),
            'meta_value'    => Yii::t('user', 'Meta Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Update user meta
     */
    private function updateUserMeta($userId, $key, $value){
        if(null === $model = static::find()->where(['user_id' => $userId, 'meta_key' => $key ])->one()){
            $model = new static();
            $model->user_id = $userId;
            $model->meta_key = $key;
            $model->meta_value = $value;
            return $model->save();
        }else{
            return $model->updateAttributes([
                'meta_key' => $key,
                'meta_value' => $value,
            ]);
        }
    }

    public function updateMetaData($post) {
        $userId = $post['userId'];
        unset($post['_csrf']);
        unset($post['userId']);
        foreach ($post as $key => $value) {
            $this->updateUserMeta($userId,$key,$value);
        }
        return true;
    }

    public function uploadImage($post) {
        $userId = $post['userId'];
        unset($post['_csrf']);
        unset($post['userId']);
        $image = UploadedFile::getInstance($this, 'image');
        if ($image instanceof UploadedFile) {
            if (null !== $image = FileUploaderHelper::saveAs($image, 'uploads' . DIRECTORY_SEPARATOR . 'users', explode('x', '200x200'), Yii::$app->request->post('img'))) {
                $this->updateUserMeta($userId,'image',$image['thumbSrc']);
                $basePath = Yii::getAlias('@webroot');
                if (is_file($basePath . $image['imgSrc'])) {
                    unlink($basePath . $image['imgSrc']);
                }
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    private function getValueByKeyAndUserId($userId,$key) {
        return $this->find()->where(['user_id' => $userId])->andWhere(['meta_key' => $key])->one();
    }

    public function deleteImageByUserId($post) {
        $userId = $post ['userId'];
        $model = $this->getValueByKeyAndUserId($userId,'image');
        if (is_file($file = Yii::getAlias('@webroot') . $model->meta_value)) {
            unlink($file);
        } else {
            return false;
        }
        if (!is_null($this->updateUserMeta($userId,'image',''))) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * @var $order is model Cart
     * @var $userId is identity User id
     */
    public function addNewClient($order,$userId) {
        if (isset($order->customer_phone)) {
            $this->user_id = $userId;
            $this->meta_key = 'phone';
            $this->meta_value = $order->customer_phone;
            $this->save();
        }
        if (isset($order->customer_name)) {
            $this->user_id = $userId;
            $this->meta_key = 'first_name';
            $this->meta_value = $order->customer_name;
            $this->save();
        }
        if (isset($order->customer_l_name)) {
            $this->user_id = $userId;
            $this->meta_key = 'last_name';
            $this->meta_value = $order->customer_l_name;
            $this->save();
        }
        return true;
    }

}