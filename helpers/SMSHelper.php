<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 29.07.18
 * Time: 21:14
 */

namespace app\helpers;

use Yii;

class SMSHelper {


    public static function sendSMS($phone,$message) {
        $login = Yii::$app->params['sms_login'];
        $password = Yii::$app->params['sms_password'];
        $url = "https://smsc.ua/sys/send.php";
        $postData = [
            'login' => $login,
            'psw' => $password,
            'phones' => $phone,
//            'cost' => 1, // get cost
            'time' => 0,
            'sender' => 'eurosport',
            'flash' => 1,
            'charset' => 'utf-8',
            'mes' => $message,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        $result = curl_exec($ch);
//        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//        $error = curl_error($ch);
//        $errorno = curl_errno($ch);
        curl_close($ch);
        return $result;
    }
}