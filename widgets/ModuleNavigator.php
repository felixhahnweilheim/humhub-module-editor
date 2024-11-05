<?php

namespace humhub\modules\moduleEditor\widgets;

use humhub\modules\moduleEditor\helpers\Url;
use humhub\components\Widget;
use Yii;

/**
 * Module Navigation for File Editor
 */
class ModuleNavigator extends Widget
{
    public $moduleId;
    
    public function run()
    {
        $result = '<details class="module-editor-nav"><summary><b>' . Yii::t('ModuleEditorModule.admin', 'Module:') . ' </b>' . $this->moduleId . '
<a class="btn btn-primary btn-sm pull-right" href="' . Url::getCreateUrl($this->moduleId, null) . '">+</a>
</summary><div class="module-editor-nav-content">';
        
        $modules = Yii::$app->moduleManager->getModules();
        
        ksort($modules);
        
        foreach ($modules as $id => $module) {
            if ( $module->id === $this->moduleId) {
                $result .= '<p class="current">' . $id . ' - ' . $module->getName() . '</p>';
            } else {
                $result .= '<p><a href="' . Url::getEditorUrl($id)  . '">' . $id . ' - <i>' . $module->getName() . '</i></a></p>';
            }
        }
        $result .= '</div></details>';
        
        return $result;
    }
}
