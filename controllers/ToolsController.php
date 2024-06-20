<?php

namespace humhub\modules\moduleEditor\controllers;

use humhub\modules\moduleEditor\models\ModuleMessages;
use Yii;

class ToolsController extends \humhub\modules\admin\components\Controller
{
    public $subLayout = '@module-editor/views/layouts/admin';

    public function actionIndex(): string
    {
        $form = new ModuleMessages();

        if ($form->load(Yii::$app->request->post())) {
            $form->save();
        }

        return $this->render('index', ['model' => $form]);
    }
}
