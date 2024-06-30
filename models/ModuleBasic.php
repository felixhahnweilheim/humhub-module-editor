<?php

namespace humhub\modules\moduleEditor\models;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;

class ModuleBasic extends \yii\base\Model
{
    private const MODULE_TEMPLATE = '@module-editor/resources/templates/base';
    
    public $modulePath;
    public $moduleId;
    public $moduleTitle;
    public $moduleDescription;
    public $moduleAuthor;
    public $moduleMinHumHub;
    
    public function rules(): array
    {
        return [
            [['modulePath'], 'isModulePath'],
            [['moduleId', 'moduleTitle', 'moduleDescription', 'moduleAuthor', 'moduleMinHumHub'], 'required'],
            [['moduleId'], 'uniqueModuleId']
        ];
    }
    
    public function uniqueModuleId(string $attribute, $params, $validator)
    {
        $modules = Yii::$app->moduleManager->getModules();
        if (isset($modules[$this->$attribute])) {
            $this->addError($attribute, Yii::t('ModuleEditorModule.admin', 'Module ID is already taken.'));
        }
    }
    
    public function isModulePath(string $attribute, $params, $validator)
    {
        if (!in_array($this->$attribute, $this->getModulePaths())) {
            $this->addError($attribute, Yii::t('ModuleEditorModule.admin', 'unknown module path'));
        }
    }

    public function attributeLabels(): array
    {
        return [
            'modulePath' => Yii::t('ModuleEditorModule.admin', 'Module Loader Path'),
            'moduleId' => Yii::t('ModuleEditorModule.admin', 'ID'),
            'moduleTitle' => Yii::t('ModuleEditorModule.admin', 'Title'),
            'moduleDescription' => Yii::t('ModuleEditorModule.admin', 'Description'),
            'moduleAuthor' => Yii::t('ModuleEditorModule.admin', 'Author'),
            'moduleMinHumHub' => Yii::t('ModuleEditorModule.admin', 'Minimum HumHub version'),
        ];
    }

    public function attributeHints(): array
    {
        return [
        ];
    }

    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }
        
        $replaceData['{module_id}'] = $this->moduleId;
        $replaceData['{module_title}'] = addslashes($this->moduleTitle);
        $replaceData['{module_description}'] = addslashes($this->moduleDescription);
        $replaceData['{module_camelCase}'] = Inflector::variablize($this->moduleId);
        $replaceData['{module_translation_base}'] = Inflector::camelize($this->moduleId) . 'Module';
        $replaceData['{module_minHumHub}'] = addslashes($this->moduleMinHumHub);
        $replaceData['{module_author}'] = addslashes($this->moduleAuthor);
        
        $src = Yii::getAlias(self::MODULE_TEMPLATE);
        $dst = Yii::getAlias($this->modulePath . '/' . $this->moduleId);
        FileHelper::createDirectory($dst);
        FileHelper::copyDirectory($src, $dst);
        
        $files = FileHelper::findFiles($dst);
        foreach ($files as $file) {
            self::insertModuleInfo($file, $replaceData);
        }
        return true;
    }
    
    private function insertModuleInfo($file, array $replaceData): void
    {
        $lines = file($file, FILE_IGNORE_NEW_LINES);
        foreach($lines as $key => $line) {
            
            $lines[$key] = strtr($line, $replaceData);
        }
        $data = implode(PHP_EOL, $lines);
        file_put_contents($file, $data);
    }        
    
    public function getModulePaths(): array
    {
        $paths = Yii::$app->params['moduleAutoloadPaths'];
        foreach ($paths as $path) {
            $result[$path] = $path . ' => ' . Yii::getAlias($path);
        }
        return $result;
    }
}
