<?php

namespace humhub\modules\moduleEditor\controllers;

use humhub\modules\moduleEditor\models\ModuleBasic;
use Yii;

class CreateController extends \humhub\modules\admin\components\Controller
{
    public $subLayout = '@module-editor/views/layouts/admin';
    
    public function init()
    {
        parent::init();
        $this->setPageTitle(Yii::t('ModuleEditorModule.admin', 'New Module'));
        $this->appendPageTitle(Yii::t('ModuleEditorModule.admin', 'Module Editor'));
    }
    
    public function actionIndex(): string
    {
        $form = new ModuleBasic();

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            $this->view->saved();
            $this->redirect(['/module-editor', 'moduleId' => $form->moduleId, 'file' => '/Module.php']);
        }

        return $this->render('index', ['model' => $form]);
    }
}
