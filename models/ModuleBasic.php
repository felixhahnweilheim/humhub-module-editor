<?php

namespace humhub\modules\moduleEditor\models;

use Yii;

class ModuleBasic extends \yii\base\Model
{
    public $modulePath;
    public $moduleId;
    public $moduleTitle;
    public $moduleDescription;
    
    public function rules(): array
    {
        return [
            [['modulePath'], 'isModulePath'],
            [['moduleId', 'moduleTitle', 'moduleDescription'], 'string'],
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
        
        // do something

        return true;
    }
    
    public function getModulePaths(): array
    {
        return Yii::$app->params['moduleAutoloadPaths'];
    }
}
