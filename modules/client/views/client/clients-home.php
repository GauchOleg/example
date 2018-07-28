<?php
/* @var $user \app\modules\user\models\User */
/* @var $countOrders @type integer @method \app\modules\dashboard\models\Cart::getTotalOrdersByPhone() */
?>
<h3><?php echo isset($user->metaData->email) ? '' : 'Для восстановления доступа к аккаунту используеться "email", заполните поле "email" во вкладке "настройки" '?></h3>
<br>
<div class="row">
    <div class="col-md-4">
        <table class="table table-condensed">
            <tbody>
                <tr>
                    <td>username</td>
                    <td><?php echo $user->username?></td>
                </tr>
                <tr>
                    <td>Основной номер тел.</td>
                    <td><?php echo $user->metaData->phone?></td>
                </tr>
                <tr>
                    <td>Дополнительный тел.</td>
                    <td><?php echo (isset($user->metaData->add_phone) && !empty($user->metaData->add_phone) ? $user->metaData->add_phone : 'не установлен')?></td>
                </tr>
                <tr>
                    <td>Дата регистрации</td>
                    <td><?php echo $user->create_date?></td>
                </tr>
                <tr>
                    <td>Количество заказов</td>
                    <td><?php echo $countOrders?></td>
                </tr>
            </tbody>
        </table>

    </div>
</div>

