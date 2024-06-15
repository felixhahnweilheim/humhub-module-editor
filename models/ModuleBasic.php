<?php

namespace humhub\modules\moduleEditor\models;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;

class ModuleBasic extends \yii\base\Model
{
    private const MODULE_TEMPLATE = '@module-editor/templates/base';
    
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
        $replaceData['{module_title}'] = $this->moduleTitle;
        $replaceData['{module_description}'] = $this->moduleDescription;
        $replaceData['{module_camelCase}'] = Inflector::variablize($this->moduleId);
        $replaceData['{module_PascalCase}'] = Inflector::camelize($this->moduleId);
        $replaceData['{module_minHumHub}'] = $this->moduleMinHumHub;
        $replaceData['{module_author}'] = $this->moduleAuthor;
        
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
			$result[$path] = $path;
		}
		return $result;
    }
}
