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
            [['moduleId', 'moduleTitle', 'moduleDescription'], 'string']
        ];
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
