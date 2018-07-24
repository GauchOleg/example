<?php

namespace app\modules\client;

/**
 * client module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\client\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->layout = '@app/modules/dashboard/views/layouts/main.php';

        // custom initialization code goes here
    }
}
