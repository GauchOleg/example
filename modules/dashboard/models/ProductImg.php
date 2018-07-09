<?php

namespace app\modules\dashboard\models;

use app\helpers\FileUploaderHelper;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\UploadedFile;

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
    public $file;
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
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 9],
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

    public static function getImgByProductId($product_id) {
        $img = self::find()->where(['product_id' => $product_id])->limit(1)->one();

        if (is_null($img)) {
            return null;
        }
        return Html::img($img->alias,['style' => 'width:350px; height:200px']);
    }

    public function checkImg($product_id) {
        $imgs = self::find()->where(['product_id' => $product_id])->all();
        if ($imgs) {
            return $imgs;
        } else {
            return false;
        }
    }

    /**
     * @param $product_id
     * @return string
     */
    public function getFirstImg($product_id) {
        $img = self::find()->where(['product_id' => $product_id])->limit(1)->one();
        if (is_null($img)) {
            return null;
        }
        return Html::img($img->alias,['style' => 'width:60px']);
    }

    /**
     * @param $data
     * @param $product_id
     * @return bool
     */
    public function saveAll($data, $product_id) {
        $imgs = $this->checkImg($product_id);
        if ($imgs) {
            $img = end($imgs);
            $sort_id = ($img->sort_id * 1) + 1;
        } else {
            $sort_id = 1;
        }
        foreach ($data as $item) {
            $model = new ProductImg();
            $model->product_id = $product_id;
            $model->alias = $item;
            $model->sort_id = $sort_id;
            $model->save(false);
            $sort_id++;
        }
        return true;
    }

    /**
     * @param $post
     * @param $product_id
     * @return array
     */
    public function upload($post,$product_id) {

        $files = $this->prepareDataFiles($post);
        $filesData = $this->sortDataFiles($files);
        $fileAlias = $this->saveAllImg($filesData,$product_id);
        $this->resizeImg($fileAlias);

        return $fileAlias;

    }

    /**
     * @param $data
     */
    private function resizeImg($data) {
        foreach ($data as $item) {
            $path = Yii::getAlias('@webroot') . $item;
            FileUploaderHelper::resize($path, 800, 600);
        }
    }

    private function checkEmptyDataForm($filesData) {
//        dd($filesData);
        if (is_array($filesData)) {
            $i = 0;
            foreach ($filesData as $item) {
                if (empty($item['tmp_name'])) {
                    unset($filesData[$i]);
                }
                $i++;
            }
            return $filesData;
        }
    }

    /**
     * @param $filesData
     * @param $product_id
     * @return array
     */
    private function saveAllImg ($filesData,$product_id) {

        $filesData = $this->checkEmptyDataForm($filesData);

        $fileAlias = [];
        $path = Yii::getAlias('@webroot') . '/uploads/product/' . $product_id . '/';

        foreach ($filesData as $key => $value) {
            if (!is_dir($path)) {
                mkdir($path,0755,true);
            }
            $fileName = strtolower(Yii::$app->security->generateRandomString(16));
            move_uploaded_file($value['tmp_name'],$path . $fileName . $value['type']);
            $fileAlias [] = '/uploads/product/' . $product_id . '/' . $fileName . $value['type'];
        }
        return $fileAlias;

    }

    /**
     * @param $files
     * @return array
     */
    private function sortDataFiles($files) {
        $filesData = [];
        $countFiles = count($files['type']);
        for ($i = 0; $i < $countFiles; $i++) {
            $filesData [$i]['tmp_name'] = $files['tmp_name'][$i];
            $filesData [$i]['type'] = $files['type'][$i];
        }
        return $filesData;
    }

    /**
     * @param $data
     * @return array
     */
    private function prepareDataFiles($data) {
        $files = [];

        foreach ($data as $item) {
            if ($item['tmp_name']) {
                foreach ($item['tmp_name'] as $temp) {
                    $files['tmp_name'][] = $temp;
                }
            }
            if ($item['name']) {
                foreach ($item['name'] as $img) {
                    $files['type'][] = (substr($img, strpos($img, '.')));
                }
            }
        }

        return $files;
    }

    public function deleteByModelIdSortId($model_id,$sort_id) {
        $result = self::find()->where(['product_id' => $model_id])->andWhere(['sort_id' => $sort_id])->one();
        if ($result) {
            $path = Yii::getAlias('@webroot');
            if (is_file($link = $path . $result->alias)) {
                unlink($link);
            }
            $result->delete();
        }
    }

}
