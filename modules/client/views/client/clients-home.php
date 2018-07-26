<?php
/* @var $user \app\modules\user\models\User */
/* @var $countOrders @type integer @method \app\modules\dashboard\models\Cart::getTotalOrdersByPhone() */
?>

<div class="row">
    <div class="col-md-4">
        <table class="table table-condensed">
            <tbody>
                <tr>
                    <td>username</td>
                    <td><?php echo $user->username?></td>
                </tr>
                <tr>
                    <td>Номер телефона</td>
                    <td><?php echo $user->metaData->phone?></td>
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

