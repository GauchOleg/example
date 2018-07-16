<?php

/* @var $orderData \app\modules\dashboard\models\Cart */

?>

<?php if (isset($orderData) && !empty($orderData)): ?>
    <table class="table">
        <thead>
            <tr>
                <th>№</th>
                <th>Название</th>
                <th>Кол-во</th>
                <th>Цена</th>
            </tr>
        </thead>
    <tbody>
    <?php foreach ($orderData as $item): ?>
        <tr>
            <td><?php echo $item['num'] ?></td>
            <td><?php echo $item['name'] ?></td>
            <td><?php echo $item['count'] ?></td>
            <td><?php echo $item['price'] ?></td>
        </tr>
    <?php endforeach;?>
    </tbody>
    </table>
<?php endif; ?>
