<?php

namespace humhub\modules\moduleEditor\controllers;

use humhub\modules\moduleEditor\models\FileEditor;
use Yii;

class EditorController extends \humhub\modules\admin\components\Controller
{
    public $subLayout = '@module-editor/views/layouts/admin';
    
    public function actionIndex(string $moduleId = 'module-editor', string $file = '/Module.php'): string
    {
        $form = new FileEditor($moduleId, $file);
        
        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            $this->view->saved();
        }
        
        return $this->render('index', ['model' => $form]);
    }
}
