<?php

namespace app\modules\dashboard\models;

use Yii;
use app\helpers\FileUploaderHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "producer".
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property int $active
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property string $file
 */
class Producer extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = true;
    const STATUS_DISABLE = false;

    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'producer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['active'], 'integer'],
            [['name', 'image', 'seo_title', 'seo_keywords', 'seo_description'], 'string', 'max' => 255],

            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'image' => 'Фото',
            'description' => 'Описание',
            'active' => 'Активность',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
        ];
    }

    public static function getStatusList() {
        return [
            self::STATUS_ACTIVE => 'Активный',
            self::STATUS_DISABLE => 'Отключен',
        ];
    }

    public function getPhoto() {
        if (!empty($this->image)) {
            return Html::img($this->image,['style' => 'width:80px']);
        }
    }

    public function getStatus() {
        if ($this->active == 1) {
            return "<span style='color: green'>" . $this->getStatusList()[$this->active] . "</span>";
        } else {
            return "<span style='color: red'>" . $this->getStatusList()[$this->active] . "</span>";
        }
    }

    public function saveNewProvider() {
        if ($this->file) {
            $alias = Yii::getAlias('@webroot');
            if (!is_dir($alias . '/uploads/producer/')) {
                mkdir($alias . '/uploads/producer/',0777,true);
            }
            $path = '/uploads/producer/' . trim(strtolower(Yii::$app->security->generateRandomString(16)),'_') . '.' . $this->file->extension;
            $this->file->saveAs($alias . $path);
            $file = FileUploaderHelper::resize($alias . $path,400, 200);
            if ($file) {
                $this->image = $path;
            }
        }
        $this->save(false);
    }

    public function getProducerById($id) {
        return $this->find()->where(['id' => $id])->one();
    }

    public static function getAllActiveProducers() {
        return self::find()->where(['active' => 1])->asArray()->all();
    }

    public function deleteImage($post) {
        if (isset($post['id'])) {
            $obg = $this->find()->where(['id' => $post['id']])->one();
            if (unlink(Yii::getAlias('@webroot') . $obg->image)) {
                $obg->image = null;
                if ($obg->save(false)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
