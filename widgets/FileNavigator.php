<?php

namespace humhub\modules\moduleEditor\widgets;

use humhub\modules\moduleEditor\helpers\Url;
use humhub\components\Widget;
use Yii;

/**
 * File Navigation for File Editor
 */
class FileNavigator extends Widget
{
    public $moduleId;
    
    public function run()
    {
        $result = '<details class="module-editor-nav"><summary><b>' . Yii::t('ModuleEditorModule.admin', 'File Navigator') . '</b>
<a class="btn btn-primary btn-sm pull-right" href="' . Url::getEditorUrl($this->moduleId, null) . '">+</a>
</summary>';
        
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
}
