<?php

namespace humhub\modules\moduleEditor\models;

use humhub\modules\moduleEditor\helpers\Url;
use Yii;
use yii\helpers\FileHelper;

class FileEditor extends \yii\base\Model
{
    public const ALLOWED_FORMATS = ['php', 'json', 'md', 'css', 'js', 'html', 'htm', 'xsl', 'sh', 'txt', 'yml'];

    public $moduleId;
    public $file;
    public $oldFile;
    public $content;
    public $extension;

    public function __construct(string $moduleId, string $file)
    {
        $this->moduleId = $moduleId;
        $this->extension = pathinfo($file, PATHINFO_EXTENSION);
        if (!in_array($this->extension, self::ALLOWED_FORMATS)) {
            throw new \yii\web\HttpException(422, Yii::t('ModuleEditorModule.admin', 'This file type is not supported!'));
        }
        $this->file = $file;
        $this->oldFile = $this->file;
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
        
        if (!file_put_contents($this->getFullPath(), $this->content)) {
            return false;
        }
        
        // Rename: If File name was changed, delete old file
        if ($this->file !== $this->oldFile) {
            unlink($this->getFullPathOld());
        }
        return true;
    }
    
    public function getModulesUrls(bool $excludeCurrent = false): array
    {
        $result = [];
        $modules = Yii::$app->moduleManager->getModules();
        foreach ($modules as $id => $module) {
            $result[$id] = Url::getEditorUrl($id);
        }
        if ($excludeCurrent) {
            unset($result[$this->moduleId]);
        }
        return $result;
    }
    
    public function getFilesUrls(bool $excludeCurrentUrl = false): array
    {
        $result = [];
        $path = Yii::getAlias('@' . $this->moduleId);
        $files = FileHelper::findFiles($path);
        foreach ($files as $file) {
            $file = str_replace($path, '', $file);
            $result[$file] = Url::getEditorUrl($this->moduleId, $file);
        }
        if ($excludeCurrentUrl) {
            $result[$this->file] = '';
        }
        ksort($result, SORT_STRING);
        return $result;
    }
    
    private function getFullPath(): string
    {
        return Yii::getAlias('@' . $this->moduleId . $this->file);
    }
    
    private function getFullPathOld(): string
    {
        return Yii::getAlias('@' . $this->moduleId . $this->oldFile);
    }
}
