<?php

/* @var $metaData \app\modules\dashboard\models\MetaData @type array */
?>

<?php if (isset($metaData) && !empty($metaData)) :?>
<!-- Service section start -->
<div class="section service-section" id="service">
    <div class="container">
        <!-- Start title section -->
        <div class="title">
            <h1><?php echo $metaData['service_title']['meta_value'] ?></h1>
            <!-- Section's title goes here -->
            <p><?php echo $metaData['service_description']['meta_value'] ?></p>
            <!--Simple description for section goes here. -->
        </div>
        <div class="row-fluid">
            <div class="span4">
                <div class="centered service">
                    <div class="circle-border zoom-in">
                        <img class="img-circle" src="/frontend/images/Service2.png" alt="service 2" />
                    </div>
                    <h3><?php echo $metaData['service_first_item_title']['meta_value'] ?></h3>
                    <p><?php echo $metaData['service_first_item_description']['meta_value'] ?></p>
                </div>
            </div>
            <div class="span4">
                <div class="centered service">
                    <div class="circle-border zoom-in">
                        <img class="img-circle" src="/frontend/images/Service1.png" alt="service 1">
                    </div>
                    <h3><?php echo $metaData['service_second_item_title']['meta_value'] ?></h3>
                    <p><?php echo $metaData['service_second_item_description']['meta_value'] ?></p>
                </div>
            </div>
            <div class="span4">
                <div class="centered service">
                    <div class="circle-border zoom-in">
                        <img class="img-circle" src="/frontend/images/Service3.png" alt="service 3">
                    </div>
                    <h3><?php echo $metaData['service_third_item_title']['meta_value'] ?></h3>
                    <p><?php echo $metaData['service_third_item_description']['meta_value'] ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service section end -->
<?php endif; ?>