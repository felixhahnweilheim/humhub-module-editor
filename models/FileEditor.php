<?php

namespace humhub\modules\moduleEditor\models;

use humhub\modules\moduleEditor\helpers\Url;
use Yii;
use yii\helpers\FileHelper;

class FileEditor extends \yii\base\Model
{
    public const ACE_MODES = [
        'css' => 'css',
        'gitignore' => 'gitignore',
        'html' => 'html',
        'htm' => 'html',
        'js' => 'javascript',
        'json' => 'json',
        'less' => 'less',
        'md' => 'markdown',
        'php' => 'php',
        'sh' => 'sh',
        'yaml' => 'yaml'
    ];
    
    public $moduleId;
    public $file;
    public $oldFile;
    public $content;
    public $extension;

    public function __construct(string $moduleId, string $file)
    {
        $this->moduleId = $moduleId;
        $this->extension = pathinfo($file, PATHINFO_EXTENSION);
        $this->file = $file;
        $this->oldFile = $this->file;
        $this->content = file_get_contents($this->getFullPath());
        if (!$this->validate()) {
            throw new \yii\web\HttpException(422, Yii::t('ModuleEditorModule.admin', 'This file type is not supported.'));
        }
    }

    public function rules(): array
    {
        return [
            [['moduleId', 'file', 'content'], 'required'],
            [['file'], 'knownFileType']
        ];
    }
    
    public function knownFileType(string $attribute, $params, $validator)
    {
        if (!isset(self::ACE_MODES[$this->extension])) {
            if (mime_content_type($this->getFullPath()) !== 'text/plain') {
                $this->addError($attribute, Yii::t('ModuleEditorModule.admin', 'This file type is not supported.'));
            }
        }
    }
    
    public function attributeLabels(): array
    {
        return [
            'file' => Yii::t('ModuleEditorModule.admin', 'File')
        ];
    }
    
    public function attributeHints(): array
    {
        return [
            'file' => Yii::t('ModuleEditorModule.admin', 'including the path relative to the module base directory')
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
    
    public function getModuleNavigatorHtml(): string
    {
        $result = '<details><summary><b>' . Yii::t('ModuleEditorModule.admin', 'Module:') . ' </b>' . $this->moduleId . '</summary>';
        
        $modules = Yii::$app->moduleManager->getModules();
        foreach ($modules as $id => $module) {
            $result .= '<p><a href="' . Url::getEditorUrl($id)  . '">' . $id . '</a> - ' . $module->getName() . '</p>';
        }
        $result .= '</details>';
        
        return $result;
    }
    
    public function getFileNavigatorHtml(): string
    {
        $result = '<details><summary><b>' . Yii::t('ModuleEditorModule.admin', 'File Navigator') . '</b></summary>';
    
        $result .= self::dirToHtml($this->getBasePath());
        
        $result .= '</details>';
        
        return $result;
    }
    
    private function dirToHtml(string $dir): string
    {
        $result = '';
        
        // relative to module path
        $relDir = str_replace($this->getBasePath(), '', $dir);
        
        $cdir = scandir($dir);
        $files = [];
        $subdirs = [];
        foreach ($cdir as $key => $value)
        {
            if (!in_array($value, [".",".."]))
            {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
                {
                    $subdirs[] = $value;
                } else {
                    $files[] = $value;
                }
            }
        }
        foreach ($files as $file) {
            $result .= '<p><a href="' . Url::getEditorUrl($this->moduleId, $relDir . DIRECTORY_SEPARATOR . $file) . '">' . $file  . '</a></p>';
        }
        foreach ($subdirs as $subdir) {
            $result .= "<details><summary>$subdir</summary>";
            $result .= self::dirToHtml($dir . DIRECTORY_SEPARATOR . $subdir);
            $result .= "</details>";
        }
        
        return $result;
    }
    
    private function getBasePath(): string
    {
        return Yii::getAlias('@' . $this->moduleId);
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
