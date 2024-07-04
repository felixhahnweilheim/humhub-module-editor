<?php

namespace humhub\modules\moduleEditor\models;

use Yii;

class FileDelete extends \yii\base\Model
{
    public $moduleId;
    public $file;

    public function __construct(string $moduleId, ?string $file)
    {
        $this->moduleId = $moduleId;
        $this->file = $file;
    }

    public function rules(): array
    {
        return [
            [['moduleId', 'file'], 'required']
        ];
    }

    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }
        if (unlink($this->getFullPath()) === false) {
            return false;
        }
        return true;
    }
    
    private function getFullPath(): string
    {
        return Yii::getAlias('@' . $this->moduleId . $this->file);
    }
}
