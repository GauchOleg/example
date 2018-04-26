<?php

namespace app\modules\dashboard\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\helpers\Translit;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $alias
 * @property string $code
 * @property string $price
 * @property string $text
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property int $new
 * @property int $sale
 * @property string $create_at
 * @property string $update_at
 *
 * @property Category $category
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $images;

    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'integer'],
            [['price'], 'number'],
            [['text'], 'string'],
            [['create_at', 'update_at'], 'safe'],
            [['name', 'alias', 'seo_title', 'seo_keywords', 'seo_description'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 60],
            [['new', 'sale'], 'string', 'max' => 1],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],

            [['images'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'images' => 'Фото',
            'name' => 'Название',
            'alias' => 'Alias',
            'code' => 'Код',
            'price' => 'Цена',
            'text' => 'Описание',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
            'new' => 'Новинка',
            'sale' => 'Распродажа',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    public function beforeSave($insert)
    {
        $this->name = trim($this->name);
        $this->alias = $this->checkAlias();
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return array
     */
    public static function getCategoryList() {
        return ArrayHelper::map(Category::find()->asArray()->all(),'id','name');
    }

    /**
     * @return mixed
     */
    public function getCategoryName() {
        return self::getCategoryList()[$this->category_id];
    }

    /**
     * @return mixed|string
     *  if find equals alias, concat random char else return translit string @alias
     */
    private function checkAlias() {
        $alias = Translit::str2url($this->name);
        if (self::find()->where(['alias' => $alias])->all()) {
            return $alias . '-' . strtolower(Yii::$app->security->generateRandomString(1));
        } else {
            return $alias;
        }
    }
}
