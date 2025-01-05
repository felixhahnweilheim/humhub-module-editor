<?php

namespace humhub\modules\moduleEditor\controllers;

use humhub\modules\moduleEditor\models\FileEditor;
use humhub\modules\moduleEditor\models\FileDelete;
use humhub\modules\moduleEditor\helpers\BaseHelper;
use humhub\modules\moduleEditor\helpers\Url;
use humhub\modules\moduleEditor\helpers\Memory;
use Yii;

class EditorController extends \humhub\modules\admin\components\Controller
{
    public $subLayout = '@module-editor/views/layouts/admin';
    public $editorModuleId;
    
    public function init()
    {
        parent::init();
        $this->setPageTitle(Yii::t('ModuleEditorModule.admin', 'Module Editor'));
        $this->appendPageTitle(Yii::t('ModuleEditorModule.admin', 'File Editor'));
    }
    
    public function actionIndex(string $moduleId = null, string $file = null, string $action = 'edit')
    {
        if (isset($moduleId)) {
            $this->editorModuleId = $moduleId;
        } else {
            $this->editorModuleId = Memory::getLastModule();
        }
        if ($this->editorModuleId === null) {
            $this->editorModuleId = 'module-editor';
        }
        
        if ($file === null && $action === 'edit') {
            list($m, $f) = Memory::getLastFile();
            if ($m === $this->editorModuleId) {
                $file = $f;
            }
        }
        
        //check data
        if (!BaseHelper::isAllowedModule($this->editorModuleId)) {
            throw new \yii\web\HttpException(422, Yii::t('ModuleEditorModule.admin', 'Module not found.'));
        }
        Memory::saveLastModule($this->editorModuleId);
        if ($file) {
            Memory::saveLastEditedFile($this->editorModuleId, $file);
        }
        
        $form = new FileEditor($this->editorModuleId, $file);
        
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
