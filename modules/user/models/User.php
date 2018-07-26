<?php

namespace app\modules\user\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use app\modules\user\helpers\Password;
use app\modules\user\models\UserMeta;
use yii\helpers\Json;

//use app\modules\user\models\UserGroupRelations;
//use app\helpers\MandrillEmailHelper;

/**
 * Description of User
 *
 * @author Stableflow
 *
 * Database fields:
 * @property integer $id
 * @property string  $username
 * @property string  $email
 * @property integer $role
 * @property string  $password
 * @property string  $auth_key
 * @property string  $access_token
 * @property string  $create_date
 * @property string  $referral_code
 * @property integer $status
 * @property integer $remember
 * @property string $new_password
 * @property string $password_repeat
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface {

    const ROLE_ADMIN        = 1;    // for all and create other admins
    const ROLE_USER         = 2;
    const ROLE_PARTNER      = 3;
    const ROLE_MOBILE_USER  = 4;

    const STATUS_PENDING    = 0;
    const STATUS_APPROVED   = 1;
    const STATUS_BLOCKED    = 2;

    const CREATE_SCENARIO   = 'create';
    const UPDATE_SCENARIO   = 'update';
    const REGISTER_SCENARIO = 'register';
    const LOGIN_SCENARIO    = 'login';

    protected $metaData;
//    public $newPassword;
//    public $_password;
    public $remember;
    
    public $new_password;
    public $password_repeat;

    /** @inheritdoc */
    public static function tableName() {
        return '{{%users}}';
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'auth_key' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'auth_key'
                ],
                'value' => Yii::$app->getSecurity()->generateRandomString(32)
            ],
            'access_token' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'access_token'
                ],
                'value' => Yii::$app->getSecurity()->generateRandomString(40)
            ]
        ];
    }
    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'username'          => Yii::t('app', 'Логин'),
            'email'             => Yii::t('app', 'Email'),
            'role'              => Yii::t('app', 'Role'),
            'password'          => Yii::t('app', 'Пароль'),
            'create_date'       => Yii::t('app', 'Registration time'),
            'status'            => Yii::t('app', 'Статус'),
            'remember'            => Yii::t('app', 'Запомнить меня'),
            'new_password' => 'Новый пароль',
            'password_repeat' => 'Еще раз новый пароль',
        ];
    }

    /** @inheritdoc */
    public function scenarios() {
        return\yii\helpers\ArrayHelper::merge([
            static::LOGIN_SCENARIO      => ['username', 'email'],
            static::UPDATE_SCENARIO     => ['password'],
        ], parent::scenarios());
    }

    /** @inheritdoc */
    public function rules() {
        return [
            // username rules
//            ['username', 'required'],
            ['username', 'unique'],
            ['username', 'match', 'pattern' => '/^[-a-zA-Z0-9_\.@]+$/'],
            ['username', 'string', 'min' => 3, 'max' => 60],
            ['username', 'trim'],
            // email rules
//            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 100],
            ['email', 'unique'],
            ['email', 'trim'],
            // password rules
            ['password', 'required'],
            ['password', 'string', 'min' => 5],

            ['new_password', 'string', 'min' => 5],
            ['password_repeat', 'string', 'min' => 5],

            ['password_repeat', 'compare' ,'compareAttribute' => 'new_password'],

            // status rules
            [['status'], 'integer'],
            // role rules
            [['role'], 'integer'],

            [['auth_key'], 'string', 'max' => 32],
            [['access_token'], 'string', 'max' => 40],
//            [['last_login'], 'datetime'],

            [['remember'], 'integer'],

        ];
    }

    /** @inheritdoc */
//    public function beforeValidate() {
//        if (!empty($this->new_password)) {
//            $this->password = $this->new_password;
//        }
//        return parent::beforeValidate();
//    }

    /** @inheritdoc */
    public function beforeSave($insert) {

        if ($this->isNewRecord) {
            $this->auth_key = Yii::$app->security->generateRandomString();
            $this->password = Password::hash($this->password);
        }

        return parent::beforeSave($insert);
    }

    /** @inheritdoc */
    public function getId() {
        return $this->getAttribute('id');
    }

    /** @inheritdoc */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /** @inheritdoc */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /** @inheritdoc */
    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /** @inheritdoc */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['access_token' => $token]);
    }

    public function setAccessToken() {
        if (isset($this->access_token)) {
            Yii::$app->session->set('access_token',$this->access_token);
        }
    }
    
    public function loginUser($model) {
        Yii::$app->user->login($model);
        if ($model->remember == 1) {
            $this->setAccessToken();
        }
    }

    public function logoutUser(){
        Yii::$app->user->logout();
        $this->removeAccessToken();
    }

    public function checkUserData($model) {
        $user = $this->findUserByUsername($model->username);
        if (is_null($user)) {
            return 'user';
        }
        if (!Password::validate($model->password,$user->password)) {
            return 'password';
        }
        return $user;
    }

    public function errorUserPassword() {
        Yii::$app->session->setFlash('error','Не верный логин/пароль',true);
    }

    public function forbiddenUser() {
        Yii::$app->session->setFlash('error','Доступ к Вашему аккаунту не возможен. Обратитесь к админимстрации сайта');
    }

    public function removeAccessToken() {
        if (Yii::$app->session->get('access_token')) {
            Yii::$app->session->remove('access_token');
        }
    }

    public function getSessionToken() {
        if (Yii::$app->session->get('access_token')) {
            return Yii::$app->session->get('access_token');
        } else {
            return false;
        }
    }

    /**
     * @return boolean Whether the user is blocked or not.
     */
    public function getIsBlocked() {
        return $this->status == self::STATUS_BLOCKED;
    }

    /**
     * @return boolean Whether the user is approved or not.
     */
    public function getIsApproved() {
        return $this->status == self::STATUS_APPROVED;
    }

    /**
     * Finds a user by the given username or email.
     *
     * @param  string      $usernameOrEmail Username or email to be used on search.
     * @return User
     */
    public function findUserByUsernameOrEmail($usernameOrEmail) {
        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            return $this->findUserByEmail($usernameOrEmail);
        }
        return $this->findUserByUsername($usernameOrEmail);
    }

    /**
     * Finds a user by the given email.
     *
     * @param  string      $email Email to be used on search.
     * @return User
     */
    public function findUserByEmail($email) {
        return self::findOne(['email' => $email]);
    }
    /**
     * Finds a user by the given secret_key.
     *
     * @param  string      $email Email to be used on search.
     * @return User
     */
    public static function findUserBySecretKey($secret_key) {
        return self::findOne(['secret_key' => $secret_key]);
    }

    /**
     * Finds a user by the given username.
     *
     * @param  string      $username Username to be used on search.
     * @return User
     */
    public function findUserByUsername($username) {
        return self::findOne(['username' => $username]);
    }

    /**
     * Get status list
     * @return array
     */
    public static function getStatusList() {
        return [
            static::STATUS_APPROVED     => Yii::t('app', 'Подтвержденный'),
            static::STATUS_BLOCKED      => Yii::t('app', 'Заблокирован'),
            static::STATUS_PENDING      => Yii::t('app', 'В ожидании'),
        ];
    }

    public function getRole() {
        return $this->getRoleList()[$this->role];
    }
    
    public static function getIdentityName(){
        $user = Yii::$app->user->identity;
        if (!$user) {
            return false;
        }
        $role = self::getRoleList()[$user->role];
        $userName =$user->username;
        return $userName .', ' . $role;
    }

    /**
     * Get status
     * @param boolean $html
     * @return string
     */
    public function getStatus($html = false) {
        $data = $this->getStatusList();
        if (isset($data[$this->status])) {
            if (false !== $html) {
                switch ($this->status) {
                    case static::STATUS_APPROVED :
                        $status = 'success';
                        break;
                    case static::STATUS_BLOCKED:
                        $status = 'danger';
                        break;
                    case static::STATUS_PENDING:
                        $status = 'info';
                        break;
                }
                return "<span class=\"label label-sm label-$status\">{$data[$this->status]}</span>";
            }
            return $data[$this->status];
        }

        return 'unknown';
    }

    /**
     * Get role list
     * @return array
     */
    public static function getRoleList() {
        return [
            static::ROLE_USER   => Yii::t('app', 'Клиент'),
            static::ROLE_ADMIN  => Yii::t('app', 'Admin'),
        ];
    }

    /**
     * Get role
     * @return string Description
     */
    public function getRoles() {
        $roles = static::getRoleList();

        if (isset($roles[$this->role]))
            return $roles[$this->role];

        return 'unknown';
    }

    /**
     * Resets password.
     *
     * @param string $password
     * @return boolean
     */
    public function resetPassword($password) {
        return (bool) $this->updateAttributes(['password' => Password::hash($password), 'secret_key' => null]);
    }

    /**
     * @return bool Whether the user is confirmed or not.
     */
    public function getIsConfirmed() {
        return $this->status !== static::STATUS_PENDING;
    }

    /**
     * Get user by referral code
     * @param string $code
     * @return models/User
     */
    public static function getUserByReferralCode($code) {
        return self::findOne(['referral_code' => $code]);
    }

    /**
     * Register new user
     * @param User $referral
     * @return boolean
     */
    public function register($referral = null) {
        $this->role = static::ROLE_USER;
        $this->status = static::STATUS_APPROVED;
        if ($this->save()) {
            if (null !== $referral) {
                Referral::linkReferral($referral->id, $this->id);
            }
            Yii::$app->user->login($this);
            return true;
        }
        return false;
    }

    /**
     */
    public function getReturnUrl() {
        switch ($this->role) {
            case static::ROLE_ADMIN:
                $url = '/dashboard/index-backend/index';
                break;
            case static::ROLE_USER:
            case static::ROLE_MOBILE_USER:
            default :
                $url = Yii::$app->getModule('user')->loginSuccess;
                break;
        }
        return $url;
    }

    /**
     */
    public function active() {
        return $this->andWhere('status != :status', [':status' => static::STATUS_APPROVED]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeta(){
        return $this->hasMany(UserMeta::className(), ['user_id' => 'id']);
    }

    /** @inheritdoc */
    public function afterFind() {
        $this->metaData = new \stdClass();
        foreach ($this->meta as $key => $value){
            $this->metaData->{$value->meta_key} = $value->meta_value;
        }
    }

    /**
     * Get user meta data
     * @return object
     */
    public function getMetaData() {
        return $this->metaData;
    }

    public function getAvatar() {
        return isset($this->metaData->avatar) ? $this->metaData->avatar : null;
    }

    public function getLastName() {
        return isset($this->metaData->last_name) ? $this->metaData->last_name : null;
    }

    public function getFirstName() {
        return isset($this->metaData->first_name) ? $this->metaData->first_name : null;
    }

    public function getAbout() {
        return isset($this->metaData->about) ? $this->metaData->about : null;
    }

    public function getName() {
        return isset($this->metaData->last_name, $this->metaData->first_name) ? "{$this->metaData->last_name}  {$this->metaData->first_name}" : null;
    }

    public function getPhone() {
        return isset($this->metaData->phone) ? $this->metaData->phone : null;
    }

    public function getInterests() {
        return isset($this->metaData->interests) ? $this->metaData->interests : null;
    }

    public function getAllUsers($currentUser) {
        return $this->find()->where(['not',['id' => $currentUser]]);
    }

    public function findUserById($id) {
        return $this->findOne(['id' => $id]);
    }

    public function updatePassword($post) {
        $model = $this->findUserById($post['User']['id']);
//        dd($model);
        if (!$model) {
            return Json::encode(['error' => 'Пользователь не найден']);
        }
        if (!Password::validate($post['User']['password'],$model->password)) {
            return Json::encode(['error' => 'Не вырный текущий пароль']);
        }
        $model->scenario = 'update';
        $model->load($post);
        $model->setAttribute('password',Password::hash($post['User']['new_password']));
//        $model->password = Password::hash($post['User']['password']);
        if ($model->update()) {
            return Json::encode(['success' => 'Пароль успешно обновлнен']);
        } else {
            return Json::encode(['error' => 'Пароль не обновлнен']);
        }
    }

    public function setFlash($jsonData) {
        $data = Json::decode($jsonData);
        if (key_exists('error',$data)) {
            Yii::$app->session->setFlash('error',$data['error'],true);
        }
        if (key_exists('success',$data)) {
            Yii::$app->session->setFlash('success',$data['success'],true);
        }
        return true;
    }

}