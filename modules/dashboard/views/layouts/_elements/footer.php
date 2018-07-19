<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner"> <?= Yii::$app->name ?></div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>
<!-- END FOOTER -->

<?php if(Yii::$app->user->isGuest || Yii::$app->user->can('admin')): ?>
<?php endif; ?>