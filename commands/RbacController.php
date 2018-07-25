<?php

namespace app\commands;


use app\models\User;
use Yii;
use yii\web\Request;

/**
 * RBAC generator
 * @package app\commands
 */
class RbacController extends \yii\console\Controller {

    public function actionInit() {

        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $user = $auth->createRole('user');
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $auth->addChild($admin,$user);

        $this->stdout('Done!' . PHP_EOL);
    }

    public function actionTest() {

        Yii::$app->set('request', new Request());
        $auth = Yii::$app->authManager;

        $user = new User(['id' => 1, 'username' => 'User']);
        $admin = new User(['id' => 1, 'username' => 'Admin']);

        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create post';
        $auth->add($createPost);

//        var_dump(Yii::$app->user->id);
//        Yii::$app->user->login($user);
//        var_dump(Yii::$app->user->id);
//        Yii::$app->user->logout();
//        var_dump(Yii::$app->user->id);
//
        $auth->revokeAll($user->id);
//        $auth->revokeAll($admin->id);

    }
}