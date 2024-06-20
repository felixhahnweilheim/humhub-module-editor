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
			\Yii::error('DEB F : ' . $this->$attribute);
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
        
        exec('php yii message/extract-module ' . $this->moduleId . ' 2> /dev/null', $output, $return_val);
        
        $this->response = implode("/n", $output);
        
        return true;
    }
}
