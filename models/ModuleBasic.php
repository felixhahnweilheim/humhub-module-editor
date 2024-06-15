<?php

namespace humhub\modules\moduleEditor\models;

use Yii;

class ModuleBasic extends \yii\base\Model
{
    public $moduleId;
    public $moduleTitle;
    public $moduleDescription;
    
    public function rules(): array
    {
        return [
            [['moduleId', 'moduleTitle', 'moduleDescription'], 'string'],
            [['moduleId'], 'uniqueModuleId']
        ];
    }
    
    public function uniqueModuleId(string $attribute, $params, $validator)
    {
        $modules = Yii::$app->moduleManager->getModules();
        
        if (isset($modules[$attribute])) {
            $this->addError($attribute, Yii::t('ModuleEditorModule.admin', 'Module ID is already taken'));
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
}
