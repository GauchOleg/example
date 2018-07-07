<?php
/* @var $allCategory \app\modules\dashboard\models\Category */
use yii\helpers\Url;
?>

<?php echo $this->render('home_section');?>

<?php echo $this->render('catalog_section',compact('allCategory'));?>

<?php echo $this->render('service_section');?>

<?php echo $this->render('portfolio_section');?>

<?php echo $this->render('about_section');?>

<?php echo $this->render('provider_section');?>

<?php echo $this->render('contact_section'); ?>