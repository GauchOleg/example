<?php

/* @var $allSliders \app\modules\dashboard\models\Slider @type array */
//dd($allSliders)
?>
<!-- Start home section -->
<div id="home">
    <!-- Start cSlider -->
    <div id="da-slider" class="da-slider">
        <div class="triangle"></div>
        <!-- mask elemet use for masking background image -->
        <div class="mask"></div>
        <!-- All slides centred in container element -->
        <div class="container">

            <?php if (isset($allSliders) && !empty($allSliders)) :?>
                <?php foreach ($allSliders as $slider) :?>
                    <div class="da-slide">
                        <h2 class="fittext2"><?php echo $slider['title']?></h2>
                        <h4><?php echo $slider['pre_description']?></h4>
                        <p><?php echo $slider['description']?></p>

                        <?php if (!empty($slider['link'])) :?>
                            <a href="<?php echo $slider['link']?>" class="da-link button">Перейти</a>
                        <?php endif; ?>

                        <div class="da-img">
                            <img src="<?php echo $slider['image']?>" alt="image01" width="320">
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Start third slide -->
            <!-- Start cSlide navigation arrows -->
            <div class="da-arrows">
                <span class="da-arrows-prev"></span>
                <span class="da-arrows-next"></span>
            </div>
            <!-- End cSlide navigation arrows -->
        </div>
    </div>
</div>
<!-- End home section -->
