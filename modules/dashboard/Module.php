<?php

namespace app\modules\dashboard;

/**
 * dashboard module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\dashboard\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->layout = 'main.php';

        // custom initialization code goes here
    }
}
