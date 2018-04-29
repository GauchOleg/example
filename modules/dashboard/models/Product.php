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

    public function beforeDelete()
    {
        $this->checkImg();
        return parent::beforeDelete();
    }

    public function beforeSave($insert)
    {
        $this->name = trim($this->name);
        $this->alias = $this->checkAlias();
        $this->create_at = ($this->isNewRecord) ? date('Y-m-d H:i:s') : $this->create_at;
        $this->update_at = ($this->isNewRecord) ? '' : date('Y-m-d H:i:s');
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

    public function checkSale() {
        if ($this->sale) {
            return '<span style="color: green">Да</span>';
        } else {
            return '<span style="color: red">Нет</span>';
        }
    }

    public function checkNew() {
        if ($this->new) {
            return '<span style="color: green">Да</span>';
        } else {
            return '<span style="color: red">Нет</span>';
        }
    }

    /**
     * @return bool
     */
    public function checkImg() {
        $imgs = ProductImg::find()->where(['product_id' => $this->id])->indexBy('id')->asArray()->all();
        $ids = array_keys($imgs);
        $this->deleteAllImagesFromDb($ids);
        $this->unsetAllImages($imgs);
        return true;
    }

    /**
     * @param $data
     */
    private function unsetAllImages($data) {
        if (!empty($data) && is_array($data)) {
            $path = Yii::getAlias('@webroot');
            foreach ($data as $item) {
                if (is_file($link = $path . $item['alias'])) {
                    unlink($link);
                }
            }
        }
    }

    /**
     * @param $ids
     */
    private function deleteAllImagesFromDb($ids) {
        if (!empty($ids) && is_array($ids)) {
            ProductImg::deleteAll(['id' => $ids]);
        }
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
