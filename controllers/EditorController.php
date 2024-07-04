<?php

namespace humhub\modules\moduleEditor\controllers;

use humhub\modules\moduleEditor\models\FileEditor;
use humhub\modules\moduleEditor\models\FileDelete;
use humhub\modules\moduleEditor\helpers\Url;
use Yii;

class EditorController extends \humhub\modules\admin\components\Controller
{
    public $subLayout = '@module-editor/views/layouts/admin';
    
    public function init()
    {
        parent::init();
        $this->setPageTitle(Yii::t('ModuleEditorModule.admin', 'Module Editor'));
        $this->appendPageTitle(Yii::t('ModuleEditorModule.admin', 'File Editor'));
    }
    
    public function actionIndex(string $moduleId = 'module-editor', string $file = null)
    {
        $form = new FileEditor($moduleId, $file);
        
        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            $this->view->saved();
            
            // Redirect if file has been renamed or created
            if ($form->file !== $form->oldFile || $form->oldFile === null) {
                return $this->redirect(Url::getEditorUrl($form->moduleId, $form->file));
            }
        }
        
        return $this->render('index', ['model' => $form]);
    }
    
    public function actionDeleteModal(string $moduleId, string $file)
    {
        $form = new FileDelete($moduleId, $file);
        
        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            $this->view->saved();
            return $this->redirect(Url::getEditorUrl($form->moduleId));
        }
        
        return $this->renderAjax('delete-modal', ['model' => $form]);
    }
}
