<?php

namespace app\modules\dashboard\models;

use app\helpers\Translit;
use yii\helpers\Html;
use yii\web\UploadedFile;
use app\helpers\FileUploaderHelper;
use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $alias
 * @property string $image
 * @property string $text
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 */
class Category extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name'], 'required'],
            [['text','alias'], 'string'],
            [['name', 'seo_title'], 'string', 'max' => 100],
            [['alias'], 'string', 'max' => 120],
            [['image', 'seo_keywords', 'seo_description'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Родительская',
            'name' => 'Название',
            'alias' => 'Ссылка',
            'image' => 'Изображение',
            'text' => 'Описание',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
        ];
    }

    public static function getAllCategory() {
        return self::find()->asArray()->all();
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->name = trim($this->name);
        $this->alias = $this->checkAlias();
        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete();
    }

    private function getCategoryByAliasAsArray($alias) {
        return self::find()->where(['alias' => $alias])->asArray()->all();
    }

    /**
     * @return mixed|string
     *  if find equals alias, concat random char else return translit string @alias
     */
    private function checkAlias() {
        $alias = Translit::str2url($this->name);
        if ($this->isNewRecord) {
            if (empty($this->getCategoryByAliasAsArray($alias))) {
                return $alias;
            } else {
                return $alias . '-' . strtolower(Yii::$app->security->generateRandomString(1));
            }
        } else {
            $current = $this->getCategoryByAliasAsArray($alias);
            if (!empty($current)) {
                if ($current[0]['id'] == $this->id) {
                    return $alias;
                } else {
                    return $this->alias;
                }
            } else {
                return $alias;
            }
        }
    }

    /**
     * @return bool
     */
    public function uploadImage() {

        $image = UploadedFile::getInstance($this, 'imageFile');
        if ($image instanceof UploadedFile) {
            if (null !== $image = FileUploaderHelper::saveAs($image, 'uploads' . DIRECTORY_SEPARATOR . 'category', explode('x', '200x200'), Yii::$app->request->post('img'))) {
                $this->setAttribute('image',$image['thumbSrc']);
                $basePath = Yii::getAlias('@webroot');
                if (is_file($basePath . $image['imgSrc'])) {
                    unlink($basePath . $image['imgSrc']);
                }
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * @return bool|string tag img or false;
     */
    public function getFileImage() {
        if ($this->image) {
            return Html::img($this->image);
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function deleteImage() {
        $basePath = Yii::getAlias('@webroot');
        if (is_file($basePath . $this->image)) {
            unlink($basePath . $this->image);
            $this->image = null;
        } else {
            $this->image = null;
        }
        $this->save(false);
        return true;
    }

    public static function getCategoryByAlias($alias) {
        if (!empty($alias)) {
            $category = self::find()->where(['alias' => $alias])->one();
            if ($category != null) {
                return $category;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function noImage() {
        return Yii::getAlias('@web') .'/default/img/category_no_img.png';
    }
}
