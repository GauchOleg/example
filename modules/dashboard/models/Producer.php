<?php

namespace app\modules\dashboard\models;

use Yii;
use app\helpers\FileUploaderHelper;
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
 * @property string $img
 */
class Producer extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = true;
    const STATUS_DISABLE = false;

    public $img;
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

    public function saveNewProvider() {
        if ($this->img) {
            $alias = Yii::getAlias('@webroot');
            if (!is_dir($alias . '/uploads/provider/')) {
                mkdir($alias . '/uploads/provider/',0777,true);
            }
            $path = '/uploads/provider/' . trim(strtolower(Yii::$app->security->generateRandomString(16)),'_') . '.' . $this->img->extension;
            $this->img->saveAs($alias . $path);
            $file = FileUploaderHelper::resize($alias . $path,400, 200);
            if ($file) {
                $this->image = $path;
            }
        }
        $this->save(false);
    }
}
