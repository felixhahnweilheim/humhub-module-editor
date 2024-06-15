<?php

namespace humhub\modules\moduleEditor\models;

use Yii;
use yii\helpers\FileHelper;

class FileEditor extends \yii\base\Model
{
    public $moduleId;
    public $filePath;
    public $content;
    
    public function __construct(string $moduleId = 'module-editor', string $file = '/Module.php')
    {
        $this->moduleId = $moduleId;
        $this->filePath = Yii::getAlias('@' . $moduleId . $file);
        $this->content = file_get_contents($this->filePath);
    }
    
    public function rules(): array
    {
        return [
            [['moduleId', 'filePath', 'content'], 'required']
        ];
    }

    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }
        
        if (!file_put_contents($this->filePath, $this->content)) {
            return false;
        }
        return true;
    }
}
