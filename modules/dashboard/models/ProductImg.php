<?php

namespace app\modules\dashboard\models;

use Yii;

/**
 * This is the model class for table "{{%product_img}}".
 *
 * @property int $id
 * @property int $product_id
 * @property string $alias
 * @property int $sort_id
 *
 * @property Product $product
 */
class ProductImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_img}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'sort_id'], 'integer'],
            [['alias'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'alias' => 'Alias',
            'sort_id' => 'Sort ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
