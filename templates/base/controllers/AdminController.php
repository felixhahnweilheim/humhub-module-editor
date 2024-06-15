<?php

namespace humhub\modules\{module_camelCase}\controllers;

use Yii;

class AdminController extends \humhub\modules\admin\components\Controller
{
    public $subLayout = '@{module_id}/views/layouts/admin';

    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
