<?php

namespace app\modules\dashboard\models;

use app\helpers\FileUploaderHelper;
use Yii;
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

    public static function getStatusList() {
        return [
            self::STATUS_ACTIVE => 'Активный',
            self::STATUS_OFF    => 'Не активный'
        ];
    }

    public function saveNewSlider() {
        if ($this->img) {
            $alias = Yii::getAlias('@webroot');
            if (!is_dir($alias . '/uploads/sliders/')) {
                mkdir($alias . '/uploads/sliders/',0777,true);
            }
            $path = '/uploads/sliders/' . $this->img->baseName . '.' . $this->img->extension;
            $this->img->saveAs($alias . $path);
            $file = FileUploaderHelper::resize($alias . $path,320,250);

            if ($file) {
                $this->image = $path;
                $this->save();
            }
        }
    }
}
