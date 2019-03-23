<?php

namespace kittyfamous\webmanager;

use Yii;

class WebManagerModule extends \yii\base\Module
{

    public $controllerNamespace = 'kittyfamous\webmanager\controllers';

    public function init()
    {
        parent::init();

        if (Yii::$app->user->isGuest) {
            Yii::$app->response->redirect(['/site/login', 'ref'=>'/webmanager/default/index']);
//            Yii::$app->end();
        }
    }

}
