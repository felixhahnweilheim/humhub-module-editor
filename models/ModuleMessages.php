<?php

namespace humhub\modules\moduleEditor\models;

use humhub\modules\components\Module;
use Yii;

class ModuleMessages extends \yii\base\Model
{
    public $moduleId;
    public ?string $response = null;
    
    public function rules(): array
    {
        return [
            [['moduleId'], 'moduleExists'],
        ];
    }
    
    public function moduleExists(string $attribute, $params, $validator)
    {
        $module = Yii::$app->moduleManager->getModule($this->$attribute);
        if (!$module instanceof Module) {
            $this->addError($attribute, Yii::t('ModuleEditorModule.admin', 'Module not found.'));
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
        
        $output = null;
        $return_val = null;
        
        exec('php yii message/extract-module ' . $moduleId, $output, $return_val);
        
        $this->response = print_r($output);
        
        return true;
    }
}
