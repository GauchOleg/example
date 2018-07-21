<?php

namespace app\modules\dashboard\models;

use Yii;

/**
 * This is the model class for table "{{%meta_data}}".
 *
 * @property int $id
 * @property string $meta_key
 * @property string $meta_value
 */
class MetaData extends \yii\db\ActiveRecord
{
    const SUCCESS_MESSAGE = 'Данные успешно обновлены';
    const ERROR_MESSAGE = 'Ошибка при обновлении';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%meta_data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meta_value'], 'string'],
            [['meta_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'meta_key' => 'Meta Key',
            'meta_value' => 'Meta Value',
        ];
    }

    public function getAllData() {
        return self::find()->indexBy('meta_key')->asArray()->all();
    }
    
    public function updateMetaData($post) {
        if (isset($post['_csrf'])) {
            unset($post['_csrf']);
        }
        foreach ($post as $key => $value) {
            $obj = self::find()->where(['meta_key' => $key])->one();
            if (!is_null($obj)) {
                $obj->meta_value = $value;
                $obj->update();
                unset($obj);
            }
        }
        return true;
    }
}
