<?php

namespace humhub\modules\moduleEditor\models;

use humhub\components\Module;
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
        $module = Yii::$app->getModule($this->$attribute);
        if (!$module instanceof Module) {
            $this->addError($attribute, Yii::t('ModuleEditorModule.admin', 'Module not found.'));
        }
    }
    
    public function attributeLabels(): array
    {
        return [
            'moduleId' => Yii::t('ModuleEditorModule.admin', 'Module'),
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
        
        $path = Yii::getAlias('@app');
        $output = null;
        $return_val = null;
        
        exec('cd ' . $path . ' && php yii message/extract-module ' . $this->moduleId . ' 2> /dev/null', $output, $return_val);
        
        $this->response = implode("\n", $output);
        
        if ($return_val === 0) {
            return true;
        }
        return false;
    }
    
    public function getModules(): array
    {
        $result =[];
        $modules = Yii::$app->moduleManager->getModules();
        foreach ($modules as $id => $module) {
            $result[$id] = $module->getName() . ' (' . $id . ')';
        }
        return $result;
    }
}
