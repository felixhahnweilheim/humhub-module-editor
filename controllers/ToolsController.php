<?php

namespace humhub\modules\moduleEditor\controllers;

use humhub\modules\moduleEditor\models\ModuleMessages;
use Yii;
use yii\helpers\FileHelper;

class ToolsController extends \humhub\modules\admin\components\Controller
{
    private const ZIP_DIR = '@runtime/module-editor';
    
    public $subLayout = '@module-editor/views/layouts/admin';
    
    public function init()
    {
        parent::init();
        $this->setPageTitle(Yii::t('ModuleEditorModule.admin', 'Tools'));
        $this->appendPageTitle(Yii::t('ModuleEditorModule.admin', 'Module Editor'));
    }
    
    public function actionIndex(): string
    {
        $form = new ModuleMessages();

        if ($form->load(Yii::$app->request->post())) {
            $form->save();
        }

        return $this->render('index', ['model' => $form]);
    }
    
    public function actionDownloadZip($moduleId)
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
            $zip->addFile($file, $moduleId . substr($file, $pathLength));
        }

        $zip->close();
    
        return Yii::$app->response->sendFile($tempFile);
    }
}
