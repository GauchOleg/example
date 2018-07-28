<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180723_183229_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ('mysql' === $this->db->driverName) {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $security = new yii\base\Security();
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(60)->notNull(),
            'email' => $this->string(100)->notNull(),
            'role' => $this->smallInteger()->notNull(),
            'password' => $this->string(64)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(40)->notNull(),
            'referral_code' => $this->string(12)->notNull(),
            'create_date' => $this->dateTime()->notNull(),
            'status' => $this->smallInteger()->notNull()
        ], $tableOptions);

        $this->insert('{{%users}}', [
            'username' => 'admin',
            'email' => 'dev.0424384@gmail.com',
            'role' => \app\modules\user\models\User::ROLE_ADMIN,
            'password' => \app\modules\user\helpers\Password::hash('admin'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(32),
            'access_token' => 'VBVUgk010qNN49VJFUHYeErX5IBk5wTXZd_298ur',
            'referral_code' => $security->generateRandomString(12),
            'create_date' => gmdate("Y-m-d H:i:s", time()),
            'status' => \app\modules\user\models\User::STATUS_APPROVED
        ]);

        $this->insert('{{%users}}', [
            'username' => 'user',
            'email' => 'gauch_oleg@ukr.net',
            'role' => \app\modules\user\models\User::ROLE_USER,
            'password' => \app\modules\user\helpers\Password::hash('pass123123'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(32),
            'access_token' => Yii::$app->getSecurity()->generateRandomString(40),
            'referral_code' => $security->generateRandomString(12),
            'create_date' => gmdate("Y-m-d H:i:s", time()),
            'status' => \app\modules\user\models\User::STATUS_APPROVED
        ]);

        $this->createIndex('referral_code_unique', '{{%users}}', ['referral_code'], true);
        $this->createIndex('username_unique', '{{%users}}', ['username'], true);
//        $this->createIndex('email_unique', '{{%users}}', ['email'], true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%users}}');
    }
}
