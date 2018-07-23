<?php

namespace app\modules\dashboard\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\helpers\Translit;
use yii\helpers\Html;
use yii\helpers\Url;

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
 * @property string $checkboxes
 * @property string $small_text
 * @property int $new
 * @property int $sale
 * @property string $create_at
 * @property string $update_at
 *
 * @property Category $category
 */
class Product extends \yii\db\ActiveRecord
{
    public $add_to_cart;

    /**
     * @inheritdoc
     */

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
            [['text','small_text'], 'string'],
            [['create_at', 'update_at'], 'safe'],
            [['name', 'alias', 'seo_title', 'seo_keywords', 'seo_description'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 60],
            [['new', 'sale'], 'string', 'max' => 1],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['name'], 'required', 'message' => '{attribute} не может быть пустым'],
            [['checkboxes'], 'safe'],

//            [['images'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 5],
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
            'small_text' => 'Краткое описание',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
            'new' => 'Новинка',
            'sale' => 'Распродажа',
            'checkboxes' => 'Чекбоксы',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'add_to_cart' => 'В корзину',
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
        $this->checkboxes = $this->prepareCheckboxValue();
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
        if (is_null($this->category_id)) {
            return null;
        }
        return self::getCategoryList()[$this->category_id];
    }

    /**
     * @return string
     */
    public function checkSale() {
        if ($this->sale) {
            return '<span style="color: green">Да</span>';
        } else {
            return '<span style="color: red">Нет</span>';
        }
    }

    /**
     * @return string
     */
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
        if  ($this->isNewRecord) {
            return $this->getNewAlias($alias);
        } else {
            if ($alias == $this->alias) {
                return $alias;
            } else {
                return $this->getNewAlias($alias);
            }
        }
    }

    private function getNewAlias($alias) {
        if (self::find()->where(['alias' => $alias])->all()) {
            return $alias . '-' . strtolower(Yii::$app->security->generateRandomString(1));
        } else {
            return $alias;
        }
    }

    private function prepareCheckboxValue() {
        if (!empty($this->checkboxes)) {
            return implode(',',array_keys($this->checkboxes));
        } else {
            return;
        }
    }

    public function getCheckboxesListByCategoryId() {
        $allCheckbox = Checkbox::find()->where(['category_id' => $this->category_id])->andWhere(['active' => 1])->asArray()->all();
        return $this->prepareArrayCheckboxes($allCheckbox);
    }

    private function prepareArrayCheckboxes($allCheckbox) {
        $checkboxes = array_flip($this->checkboxesToArray());
        $data = ArrayHelper::map($allCheckbox,'id','name');
        $result = [];
        foreach ($data as $key => $value) {
            $result[$key] = [
                'id' => $key,
                'name' => $value,
                'active' => (key_exists($key,$checkboxes)) ? 1 : 0
            ];
        }
        return $result;
    }

    public function getCheckboxByProductId() {
        $ids = $this->checkboxesToArray();
        return Checkbox::find()->where(['id' => $ids])->asArray()->all();
    }

    private function getCheckboxByIdAsArray($ids) {
        return Checkbox::find()->where(['id' => $ids])->asArray()->all();
    }

    public function getCheckboxById() {
        if ($checkboxes = $this->checkboxes){
            $ids = $this->checkboxesToArray();
            $models = $this->getCheckboxByIdAsArray($ids);
            if (!is_null($models)) {
                return implode(',',ArrayHelper::map($models,'name','name'));
            } else {
                return 'метки не заданы';
            }
        }
    }

    private function checkboxesToArray() {
        return explode(',',$this->checkboxes);
    }

    public static function getAllProductByCategoryId($category_id,$pagination) {
        if ($pagination) {
            return Product::find()->where(['category_id' => $category_id]);
        } else {
            return Product::find()->where(['category_id' => $category_id])->limit(9)->all();
        }

    }

    public static function getAllProductByCheckboxId($checked,$category_id,$pagination = false) {

        if (empty($checked)) {
            return self::getAllProductByCategoryId($category_id,$pagination);
        } else {
            $allProducts = self::find()->where(['category_id' => $category_id])->asArray()->all();
            $ids = self::getProductIdByCheckboxes($allProducts,$checked);
            if ($pagination) {
                return self::find()->where(['in','id', $ids]);
            } else {
                return self::find()->where(['in','id', $ids])->all();
            }
        }
    }

    private function getProductIdByCheckboxes($productBySetCategory,$checked) {
        $ids = [];
        foreach ($productBySetCategory as $product) {
            if (isset($product['checkboxes']) && !empty($product['checkboxes'])) {
                $checkboxes = explode(',',$product['checkboxes']);
                if (array_intersect($checkboxes,$checked)) {
                    $ids[] = $product['id'];
                }
            }
        }
        return $ids;
    }

    public static function getCheckedCheckbox($sessionIds,$postId) {
        $checked = [];
        if (is_array($sessionIds)) {
            if (in_array($postId,$sessionIds)) {
                $unset = array_search($postId,$sessionIds);
                unset($sessionIds[$unset]);
            } else {
                array_push($sessionIds,$postId);
            }
            $checked = $sessionIds;
        } else {
            array_push($checked,$postId);
        }
        return $checked;
    }

    public static function getPrice(self $product) {
        if ($product->price) {
            return $product->price . ' грн.';
        } else {
            return 'нет';
        }
    }

    public static function getProductByAlias($alias) {
        $product = self::find()->where(['alias' => $alias])->one();
        if (!is_null($product)) {
            return $product;
        } else {
            return false;
        }
    }

    // TODO нужно переписать через связь
    public static function getCategoryByProductId($productId) {
        if (!is_null($productId) && $productId) {
            $product = self::findOne($productId);
            return Category::findOne(['id' => $product->category_id]);
        } else {
            return false;
        }
    }

    public static function checkSaleNewOption(self $product) {
        $data = '';
        if (!is_null($product->sale) && $product->sale) {
            $data .= "<span class='label label-warning product-action'>Товар со скидой!</span>";
        }
        if (!is_null($product->new) && $product->new) {
            $data .= "<br><span class='label label-info product-action'>Новинка!</span>";
        }
        return $data;
    }

    public static function getBredCrumbs(self $product) {
        $homeUrl = Url::to(['/']);
        $categoryAlias = Url::to(['/category', 'id' => $product->category->alias]);
        $current = mb_strtolower($product->name);

        return  Html::a(mb_strtolower('главная'),[$homeUrl],['class' => 'breadcrumbs']) . ' / ' .
                Html::a(mb_strtolower($product->category->name),$categoryAlias,['class' => 'breadcrumbs']) . ' / ' .
                Html::a(mb_strtolower($current),false,['class' => 'disabled']);
    }
    
    public static function getProductById($productId) {
        return self::find()->where(['id' => $productId])->asArray()->one();
    }

    public function getParams($checked,$category) {
        $params ['ProductSearch'] = [
            'alias' => Yii::$app->session->get('alias'),
            'id' => self::getAllProductByCheckboxId($checked, $category->id,true),
        ];
//        array_push($params,Yii::$app->session->get('alias'));
        return $params;
    }

    public static function getProductOnIndexPage() {
        $sale = self::find()->where(['sale' => 1])->andWhere(['new' => 0])->orderBy('id')->limit(6)->asArray()->all();
        $new = self::find()->where(['new' => 1])->andWhere(['sale' => 0])->orderBy('id')->limit(3)->asArray()->all();
        $products = ArrayHelper::merge($sale,$new);
        shuffle($products);
        return $products;
    }

    public static function getImgByProductId($products) {
        $ids = [];
        foreach ($products as $product) {
            if ($product['id']) {
                array_push($ids,$product['id']);
            }
        }
        return ProductImg::find()->where(['in','product_id',$ids])->andWhere(['sort_id' => 1])->indexBy('product_id')->asArray()->all();
    }

    public static function getCategoryNameByProductId($product_id) {
        $product = self::findOne(['id' => $product_id]);
        $category = Category::find()->where(['id' => $product['category_id']])->asArray()->one();
        return $category['name'];
    }

    public function getLinkName() {
        return Html::a($this->name,['product/view','alias' => $this->alias]);
    }

    public function getCategoryLink() {
        return Html::a($this->category->name,['/category', 'id' => $this->category->alias]);
    }

    public function getPriceInView() {
        if ($this->price) {
            return $this->price . ' грн.';
        } else {
            return 'нет';
        }
    }

    public function addToCart() {
        return Html::a('В корзину','#',['class' => "btn btn-outline did add-cart", 'data-id' => $this->id]);
    }

    public static function getAllProductAsArray() {

        return $data = ArrayHelper::map(self::find()->asArray()->all(),'id','name');

        $result = [];
        array_walk_recursive($data, function ($item, $key) use (&$result) {
            $result[] = $item;
        });

        return $result;
    }

}
