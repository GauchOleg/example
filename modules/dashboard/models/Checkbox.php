<?php

namespace app\modules\dashboard\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%checkbox}}".
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property int $active
 */
class Checkbox extends \yii\db\ActiveRecord
{
    public $allCategory;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%checkbox}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'integer'],
            [['category_id'], 'required', 'message' => '{attribute} не может быть пустым'],
            [['name'], 'string', 'max' => 100],
            [['active'], 'string', 'max' => 1],
            [['allCategory'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'category_id' => 'Категория: ',
            'active' => 'Активный',
            'allCategory' => 'Добавить ко всем категориям'
        ];
    }
    
    public function beforeSave($insert)
    {
        if ($this->allCategory) {
            $this->addInAllCategory();
        }
        return parent::beforeSave($insert);
    }

    public static function getAllCheckboxesByCategoryId($id) {
        $allCheckboxes = self::find()->where(['category_id' => $id])->andWhere(['active' => 1])->all();
        if (!is_null($allCheckboxes)) {
            return ArrayHelper::map($allCheckboxes,'id','name');
        } else {
            return false;
        }
    }

    private function addInAllCategory(){
        $ids = $this->getAllIdsCategory();
        if ($this->autoAddCategory($ids)) {
            return true;
        } else {
            return false;
        }
    }

    private function autoAddCategory($ids){
        foreach ($ids as $id) {
            if ($this->category_id == $id) {
                continue;
            }
            $model = new self;
            $model->name = $this->name;
            $model->category_id = $id;
            $model->active = $this->active;
            $model->save(false);
        }
        return true;
    }

    private function getAllIdsCategory(){
        return ArrayHelper::map(Category::find()->asArray()->indexBy('id')->all(),'id','id');
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public static function getCategoryList() {
        return ArrayHelper::map(Category::find()->asArray()->all(),'id','name');
    }

    public function getCategoryName() {
        if (is_null($this->category_id)) {
            return null;
        }
        return self::getCategoryList()[$this->category_id];
    }

    public function checkActive() {
        if ($this->active) {
            return '<span style="color: green">Да</span>';
        } else {
            return '<span style="color: red">Нет</span>';
        }
    }
}
