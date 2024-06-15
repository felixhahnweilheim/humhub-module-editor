<?php

namespace humhub\modules\moduleEditor\models;

use Yii;
use yii\helpers\FileHelper;

class FileEditor extends \yii\base\Model
{
    public $moduleId;
    public $file;
    public $content;
    
    public function __construct(string $moduleId, string $file)
    {
        $this->moduleId = $moduleId;
        $this->file = $file;
        $this->content = file_get_contents($this->getFullPath());
    }
    
    public function rules(): array
    {
        return [
            [['moduleId', 'file', 'content'], 'required']
        ];
    }

    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }
        
        if (!file_put_contents($this->getFullPath, $this->content)) {
            return false;
        }
        return true;
    }
    
    private function getFullPath(): string
    {
        return Yii::getAlias('@' . $this->moduleId . $this->file);
    }
}
