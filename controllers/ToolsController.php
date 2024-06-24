<?php

namespace humhub\modules\moduleEditor\controllers;

use humhub\modules\moduleEditor\models\ModuleMessages;
use Yii;

class ToolsController extends \humhub\modules\admin\components\Controller
{
    public $subLayout = '@module-editor/views/layouts/admin';
    
    public function init()
    {
        parent::init();
        $this->setPageTitle(Yii::t('ModuleEditorModule.admin', 'Module Editor'));
    }
    
    public function actionMessages(): string
    {
        $form = new ModuleMessages();

        if ($form->load(Yii::$app->request->post())) {
            $form->save();
        }

        return $this->render('messages', ['model' => $form]);
    }
}
