<?php

namespace humhub\modules\module-creator\models;

use Yii;

class ModuleBasic extends \yii\base\Model
{

    public function rules(): array
    {
        return [
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
