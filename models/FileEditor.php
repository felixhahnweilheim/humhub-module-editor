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
        'txt' => 'text',
        'php' => 'php',
        'sh' => 'sh',
        'yaml' => 'yaml'
    ];
    
    // ID of the edited module
    public $moduleId;
    // file name including path relative to the modul's directory
    public $file;
    // old file name (null if we create a new file, different to file when we rename the file)
    public $oldFile = null;
    // file extension
    public $extension;
    // content of the file
    public $content;
    
    public function __construct(string $moduleId, ?string $file)
    {
        parent::__construct();
        
        $this->moduleId = $moduleId;
        $this->file = $file;
        $this->oldFile = $this->file;
        
        if ($this->file !== null) {
            $this->extension = $this->getExtension();
            if (!$this->validate()) {
                throw new \yii\web\HttpException(422, Yii::t('ModuleEditorModule.admin', 'This file type is not supported.'));
            }
            $this->content = file_get_contents($this->getFullPath());
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
    
    /**
     * Create: Do not overwrite an existing file
     * Accept all files without extension or with known extension
     * Create and Rename: Do not accept unknown file type
     * Edit: Allow other plain text files
     */
    public function checkFile(string $attribute, $params, $validator): void
    {
        // Create: Do not overwrite an existing file
        if ($this->oldFile === null && file_exists(self::getFullPath())) {
            $this->addError($attribute, Yii::t('ModuleEditorModule.admin', 'The file already exists.'));
            return;
        }
        
        // Accept all files without extension or with known extension
        if ($this->extension === null || isset(self::ACE_MODES[$this->extension])) {
            return;
        }
        
        // If we reach here the file extension is unknown
        // Create and Rename: Do not accept unknown file type
        if ($this->oldFile === null || $this->file !== $this->oldFile) {
            $this->addError($attribute, Yii::t('ModuleEditorModule.admin', 'This file type can not be created.'));
            return;
        }
        // Edit: Allow other plain text files
        if (mime_content_type($this->getFullPath()) !== 'text/plain') {
            $this->addError($attribute, Yii::t('ModuleEditorModule.admin', 'This file type can not be edited.'));
        }
    }
    
    public function attributeHints(): array
    {
        return [
            'file' => Yii::t('ModuleEditorModule.admin', 'File name & path relative to the module directory')
        ];
    }
    
    /**
     * Adds "/" at beginning of file name if needed
     * Update extension
     */
    public function beforeValidate(): bool
    {
        if (substr($this->file,0,1) !== '/') {
            $this->file = '/' . $this->file;
        }
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
    
    private function getExtension(): ?string
    {
        // for files like "/.gitattributes" remove the dot
        $fileWithoutDot = (substr($this->file,0,2) === '/.') ? '/' . substr($this->file,2) : $this->file;
        $pathInfo = pathinfo($fileWithoutDot);
        
        return isset($pathInfo['extension']) ? $pathInfo['extension'] : null;
    }
}
