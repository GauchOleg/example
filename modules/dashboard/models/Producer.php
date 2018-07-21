<?php

namespace app\modules\dashboard\models;

use Yii;

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

//            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 1],
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
}
