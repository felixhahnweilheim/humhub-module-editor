<?php

namespace humhub\modules\moduleEditor\controllers;

use humhub\modules\moduleEditor\models\ModuleMessages;
use humhub\modules\moduleEditor\helpers\Memory;
use Yii;
use yii\helpers\FileHelper;

class ToolsController extends \humhub\modules\admin\components\Controller
{
    private const ZIP_DIR = '@runtime/module-editor';
    private const EXCLUDE_DEFAULT = ['*/.*'];
    
    public $subLayout = '@module-editor/views/layouts/admin';
    public $editorModuleId;
    
    public function init()
    {
        parent::init();
        $this->setPageTitle(Yii::t('ModuleEditorModule.admin', 'Tools'));
        $this->appendPageTitle(Yii::t('ModuleEditorModule.admin', 'Module Editor'));
    }
    
    public function actionIndex($moduleId = null): string
    {
        if (isset($moduleId)) {
            $this->editorModuleId = $moduleId;
        } else {
            $this->editorModuleId = Memory::getLastModule();
        }
        if ($this->editorModuleId === null) {
            $this->editorModuleId = 'module-editor';
        }
        Memory::saveLastModule($this->editorModuleId);
		
        $form = new ModuleMessages($this->editorModuleId);

        if ($form->load(Yii::$app->request->post())) {
            $form->save();
        }

        return $this->render('index', ['model' => $form]);
    }
    
    public function actionDownloadZip(string $moduleId, string $exclude = null)
    {
        $modulePath =  Yii::getAlias('@' . $moduleId);
        $pathLength = strlen($modulePath);
        $zip = new \ZipArchive();
        $zipDir = Yii::getAlias(self::ZIP_DIR);
        $tempFile = $zipDir . "/" . $moduleId . ".zip";
        
        if (!is_dir($zipDir)) {
            mkdir($zipDir);
        }
        
        if ($zip->open($tempFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)!==TRUE) {
            throw new \Exception("cannot open <$tempFile>\n");
        }
        
        $files = FileHelper::findFiles($modulePath);
        
        foreach ($files as $file) {
            $relPath = substr($file, $pathLength);
            if (!empty($exclude) && preg_match('#' . $exclude . '#', $relPath)) {
                continue;
            }
            
            $zip->addFile($file, $moduleId . $relPath);
        }

        $zip->close();
        
        return Yii::$app->response->sendFile($tempFile);
    }
}
