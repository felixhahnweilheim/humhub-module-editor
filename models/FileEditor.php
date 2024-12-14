<?php

namespace humhub\modules\moduleEditor\models;

use humhub\modules\moduleEditor\helpers\Url;
use humhub\modules\moduleEditor\helpers\Memory;
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

    public function __construct(string $moduleId = null, ?string $file)
    {
        parent::__construct();
        if (isset($moduleId)) {
            $this->moduleId = $moduleId;
        } else {
            $this->moduleId = Memory::getLastModule();
        }
        if ($this->moduleId === null) {
            $this->moduleId = 'module-editor';
        }
        Memory::saveLastModule($this->moduleId);
        
        $this->extension = pathinfo($file, PATHINFO_EXTENSION);
        $this->file = $file;
        $this->oldFile = $this->file;
        if ($this->file !== null) {
            $this->content = file_get_contents($this->getFullPath());
            if (!$this->validate()) {
                throw new \yii\web\HttpException(422, Yii::t('ModuleEditorModule.admin', 'This file type is not supported.'));
            }
        }
    }

    public function rules(): array
    {
        return [
            [['moduleId', 'file'], 'required'],
            [['content'], 'safe'],
            [['file'], 'checkFile']
        ];
    }
    
    public function checkFile(string $attribute, $params, $validator)
    {
        // Check mime type
        if (!isset(self::ACE_MODES[$this->extension])) {
            // Only allow known file types for creating
            if ($this->oldFile === null) {
                $this->addError($attribute, Yii::t('ModuleEditorModule.admin', 'This file type is not supported.'));
                return;
            }
            // Allow other plain text files for editing
            if (mime_content_type($this->getFullPath()) !== 'text/plain') {
                $this->addError($attribute, Yii::t('ModuleEditorModule.admin', 'This file type is not supported.'));
            }
        }
        
        // File creating: Do not overwrite an existing file
        if ($this->oldFile === null && file_exists(self::getFullPath())) {
            $this->addError($attribute, Yii::t('ModuleEditorModule.admin', 'The file already exists.'));
        }
    }
    
    public function attributeHints(): array
    {
        return [
            'file' => Yii::t('ModuleEditorModule.admin', 'File name & path relative to the module directory')
        ];
    }
	
	public function beforeValidate(): bool
	{
		$this->extension = pathinfo($this->file, PATHINFO_EXTENSION);
		return true;
	}

    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }
        
        // Create directory if it does not exist yet
        if (!is_dir(dirname($this->getFullPath()))) {
            mkdir(dirname($this->getFullPath()), 0755, true);
        }
        
        // Write contents / Create file
        if (file_put_contents($this->getFullPath(), $this->content) === false) {
            return false;
        }
        
        // Rename: If File name was changed, delete old file
        if ($this->file !== $this->oldFile && $this->oldFile !== null) {
            unlink($this->getFullPathOld());
        }
        return true;
    }
    
    private function getFullPath(): string
    {
        return Yii::getAlias('@' . $this->moduleId . $this->file);
    }
    
    private function getFullPathOld(): string
    {
        return Yii::getAlias('@' . $this->moduleId . $this->oldFile);
    }
	
    public function getModules(): array
    {
        $result = [];
        $modules = Yii::$app->moduleManager->getModules();
        foreach ($modules as $id => $module) {
            $result[$id] = $module->getName() . ' (' . $id . ')';
        }
        return ksort($result);
    }
}
