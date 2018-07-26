<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 26.07.18
 * Time: 21:35
 */

namespace app\modules\user\models;


use Yii;
use yii\base\Model;


/*
 * Description of LoginForm
 *
 * @property string $password
 * @property string $newPassword
 * @property string $passwordRepeat
 *
 */
class LoginForm extends Model {

    public $password;
    public $newPassword;
    public $passwordRepeat;
    public $remember;
    public $userId;

    /** @inheritdoc */
    public function rules()
    {
        return [
            [['password','newPassword','passwordRepeat'], 'string', 'min' => 6],
            ['passwordRepeat', 'compare' ,'compareAttribute' => 'newPassword'],
            ['password', 'required'],
            [['remember'], 'integer'],
            [['userId'], 'integer'],
        ];
    }

    public function attributeLabels() {
        return [
            'password' => Yii::t('app', 'Пароль'),
            'newPassword' => Yii::t('app', 'Новый пароль'),
            'passwordRepeat' => Yii::t('app', 'Еще раз новый пароль'),
            'remember' => Yii::t('app', 'Запомнить меня'),
            'userId' => Yii::t('app', 'User ID'),
        ];
    }

}