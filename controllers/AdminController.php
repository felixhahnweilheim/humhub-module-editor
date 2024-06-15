<?php

namespace humhub\modules\moduleEditor\controllers;

use humhub\modules\moduleEditor\models\ModuleBasic;
use humhub\modules\moduleEditor\models\FileEditor;
use Yii;

class AdminController extends \humhub\modules\admin\components\Controller
{
    public $subLayout = '@module-editor/views/layouts/admin';

    public function actionIndex(): string
    {
        $form = new ModuleBasic();

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            $this->view->saved();
        }

        return $this->render('index', ['model' => $form]);
    }
    
    public function actionFileEditor(string $moduleId = 'module-editor', string $file = '/Module.php'): string
    {
        $form = new FileEditor($moduleId, $file);
        
        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            $this->view->saved();
        }
        
        return $this->render('file-editor', ['model' => $form]);
    }
}
