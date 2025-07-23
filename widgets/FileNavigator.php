<?php

namespace humhub\modules\moduleEditor\widgets;

use humhub\modules\ui\icon\widgets\Icon;
use humhub\modules\moduleEditor\helpers\Url;
use humhub\components\Widget;
use Yii;

/**
 * File Navigation for File Editor
 */
class FileNavigator extends Widget
{
    public string $moduleId;
    public ?string $currentFile = null;
    
    public function run()
    {
        $result = '<div class="module-editor-nav"><div class="module-editor-nav-heading">' . Icon::get('folder') . ' <b>' . Yii::t('ModuleEditorModule.admin', 'File Navigator') . '</b>
<a class="btn btn-primary btn-sm pull-right" href="' . Url::getEditorUrl($this->moduleId, null, 'create') . '">+</a></div>';
        
        $result .= '<div id="file-nav-content-main" style="display:none">' . self::dirToHtml($this->getBasePath()) . '</div></div>';
        
        return $result;
    }
    
    private function dirToHtml(string $dir): string
    {
        $result = '<div class="module-editor-nav-content">';
        
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
        foreach ($subdirs as $subdir) {
            if (isset($this->currentFile)) {
                $d = $relDir . DIRECTORY_SEPARATOR . $subdir;
                $l = strlen($d);
                $e = substr($this->currentFile, 0, $l);
                if ($d === $e) {
                    $result .= '<details open="open">';
                } else {
                    $result .= '<details>';
                }
            
            } else {
                $result .= '<details>';
            }
            $result .= "<summary>$subdir</summary>";
            $result .= self::dirToHtml($dir . DIRECTORY_SEPARATOR . $subdir);
            $result .= "</details>";
        }
        foreach ($files as $file) {
            // @todo: mark current file
            $f = $relDir . DIRECTORY_SEPARATOR . $file;
            if ($f == $this->currentFile) {
                $result .= '<p class="current">' . $file . '</p>';
            } else {
                $result .= '<p><a href="' . Url::getEditorUrl($this->moduleId, $f) . '">' . $file  . '</a></p>';
            }
        }
        $result .= "</div>";
        
        return $result;
    }
    
    private function getBasePath(): string
    {
        return Yii::getAlias('@' . $this->moduleId);
    }
}
