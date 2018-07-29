<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 26.07.18
 * Time: 21:35
 */

namespace app\modules\user\models;


use app\modules\user\helpers\Password;
use Yii;
use yii\base\Model;
use yii\helpers\Json;


/*
 * Description of LoginForm
 *
 * @property string $password
 * @property string $newPassword
 * @property string $passwordRepeat
 *
 */
class LoginForm extends Model {

    public $phone;
    public $email;
    public $password;

    const RESET_PASSWORD = 'reset';
    const REGISTER = 'register';

    /** @inheritdoc */
    public function rules()
    {
        return [
            [['phone','password','email'],'required'],
            [['email'], 'email'],
            [['password'], 'string', 'min' => 6],
        ];
    }

    public function attributeLabels() {
        return [
            'phone' => Yii::t('app', 'Телефон'),
            'password' => Yii::t('app', 'Пароль'),
            'email' => Yii::t('app', 'Email'),
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::RESET_PASSWORD] = ['email','phone'];
        $scenarios[self::REGISTER] = ['phone','password'];
        return $scenarios;
    }

    public function register() {
        $phone = $this->convertPhone($this->phone);
        if ($this->checkUser($phone)) {
            $user = $this->addUser($phone);
            return $user;
        } else {
            return false;
        }
    }

    private function convertPhone($phone) {
        if (isset($phone)) {
            return preg_replace('/-/','',preg_replace('/\) /','',preg_replace('/(\+38){1}(\(){1}/','',$phone)));
        }
    }

    private function checkUser($phone) {
        $user = new User();
        if ($user->findUserByUsername($phone) == null) {
            return true;
        } else {
            return false;
        }
    }

    private function addUser($phone) {
        $user = new User();
        $user->username = $phone;
        $user->status = User::STATUS_APPROVED;
        $user->role = User::ROLE_USER;
        $user->password = Password::hash($this->password);
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->referral_code = Yii::$app->security->generateRandomString(12);
        $user->access_token = Yii::$app->security->generateRandomString(40);
        if ($user->save(false)) {
            $userMeta = new UserMeta();
            $userMeta->user_id = $user->id;
            $userMeta->meta_key = 'phone';
            $userMeta->meta_value = $this->phone;
            $userMeta->save(false);
        }
        return $user;
    }

    public function resetPassword() {
        $model = new User();
        $userName = $this->convertPhone($this->phone);
        $user = $model->findUserByUsername($userName);
        if ($user == null) {
            return Json::encode(['error' => 'Пользователь не найден']);
        } else {
            $userMata = new UserMeta();
            $email = $userMata->getValueByKeyAndUserId($user->id,'email');
            if (!is_null($email)) {
                if ($this->email == $email->meta_value) {
                    $updatedModel = $model->findUserById($user->id);
                    $updatedModel->scenario = 'update';
                    $updatedModel->setAttribute('password',Password::hash($user->username));
                    if ($updatedModel->update()) {
                        $this->sendNewPassword($this->email,$user->username);
                        return Json::encode(['success' => 'Новый пароль был отправлен на Ваш email, проверте папку спам!']);
                    } else {
                        return Json::encode(['error', 'Не удалось восстановить доступ, обратитесь в службу поддержки']);
                    }
                } else {
                    return Json::encode(['error' => 'Не верный email']);
                }
            } else {
                return Json::encode(['error' => 'С этим аккаунтом не связан email-адрес, обратитесь в службу поддержки для восстановления доступа']);
            }
        }
    }

    public function sendNewPassword($email,$username) {
        $siteName = Yii::$app->name;
        $message = 'Восстановление доступа в личный кабинет '. Yii::$app->params['baseUrl'] . '/dashboard/login' .'
                    <br><br>
                    <b>Логин: </b>' . $username .'<br>
                    <b>Пароль: </b>' . $username .'
                    <br><br>
                    '. $siteName .'
                    ';
        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['admin'])
            ->setTo($email)
            ->setSubject('Восстановления доступа на сайте ' . $siteName)
            ->setTextBody($siteName)
            ->setHtmlBody($message)
            ->send();
    }

}