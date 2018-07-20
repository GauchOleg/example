<?php

namespace app\modules\dashboard\models;

use app\helpers\FileUploaderHelper;
use Yii;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%slider}}".
 *
 * @property int $id
 * @property int $num_id
 * @property string $title
 * @property string $pre_description
 * @property string $description
 * @property string $link
 * @property string image
 * @property int $status
 * @property string $create_at
 * @property string $update_at
 * @property string $img
 */
class Slider extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_OFF    = 2;

    public $img;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%slider}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['status','num_id'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
            [['title', 'pre_description', 'link', 'image'], 'string', 'max' => 255],
            [['img'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'num_id' => 'Порядковый номер',
            'title' => 'Заголовок',
            'pre_description' => 'Краткое описание',
            'description' => 'Полное Описание',
            'image' => 'Изображение',
            'link' => 'Ссылка',
            'status' => 'Статус',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    public function beforeSave($insert)
    {
        $this->create_at = ($this->isNewRecord) ? date('Y-m-d H:i:s') : $this->create_at;
        $this->update_at = ($this->isNewRecord) ? '' : date('Y-m-d H:i:s');
        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        if (isset($this->image)) {
            unlink(Yii::getAlias('@webroot') . $this->image);
        }
        return parent::beforeDelete();
    }

    public static function getStatusList() {
        return [
            self::STATUS_ACTIVE => 'Активный',
            self::STATUS_OFF    => 'Не активный'
        ];
    }

    public function checkStatus() {
        if (isset($this->status) && !empty($this->status)) {
            if ($this->status == 1) {
                return '<span style="color: green">' . $this->getStatusList()[$this->status] . '</span>';
            } else {
                return '<span style="color: red">' . $this->getStatusList()[$this->status] . '</span>';
            }

        } else {
            return 'Ошибка';
        }
    }

    public function getImage() {
        if (isset($this->image) && !is_null($this->image)) {
            return Html::img($this->image,['style' => 'width:50px']);
        } else {
            return 'Нет';
        }
    }

    public static function getAllActiveSliders() {
        return self::find()->where(['status' => 1])->orderBy('num_id')->asArray()->all();
    }

    public function saveNewSlider() {
        if ($this->img) {
            $alias = Yii::getAlias('@webroot');
            if (!is_dir($alias . '/uploads/sliders/')) {
                mkdir($alias . '/uploads/sliders/',0777,true);
            }
            $path = '/uploads/sliders/' . trim(strtolower(Yii::$app->security->generateRandomString(16)),'_') . '.' . $this->img->extension;
            $this->img->saveAs($alias . $path);
            $file = FileUploaderHelper::resize($alias . $path,320, 180);

            if ($file) {
                $this->image = $path;
            }
        }
        $this->save(false);
    }
}
