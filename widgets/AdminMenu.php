<?php

namespace humhub\modules\moduleEditor\widgets;

use humhub\modules\moduleEditor\helpers\BaseHelper;
use humhub\modules\moduleEditor\helpers\Url;
use humhub\libs\Html;
use Yii;
use humhub\modules\ui\menu\MenuLink;
use humhub\modules\ui\menu\widgets\TabMenu;

/**
 * SEO Administration Menu
 */
class AdminMenu extends TabMenu
{
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        $this->addEntry(new MenuLink([
            'icon' => 'edit',
            'label' => Yii::t('ModuleEditorModule.admin', 'File Editor'),
            'url' => Url::getEditorUrl(),
            'sortOrder' => 100,
            'isActive' => MenuLink::isActiveState('module-editor', 'editor', 'index'),
            'isVisible' => true
        ]));
        
        $this->addEntry(new MenuLink([
            'icon' => 'wrench',
            'label' => Yii::t('ModuleEditorModule.admin', 'Tools'),
            'url' => Url::getToolsUrl(),
            'sortOrder' => 200,
            'isActive' => MenuLink::isActiveState('module-editor', 'tools'),
            'isVisible' => true
        ]));
        
        $this->addEntry(new MenuLink([
            'icon' => 'add',
            'label' => Yii::t('ModuleEditorModule.admin', 'New Module'),
            'url' => Url::getCreateUrl(),
            'sortOrder' => 300,
            'isActive' => MenuLink::isActiveState('module-editor', 'create', 'index'),
            'isVisible' => true
        ]));

        parent::init();
    }
    
    private function getModuleDropDownList(): string
    {
        if (isset(Yii::$app->controller->editorModuleId)) {
            return '<div id="module-editor-module-dropdown" class="pull-right">' . Html::dropDownList('moduleId', Yii::$app->controller->editorModuleId, BaseHelper::getModules()) . '</div>';
        }
        return '<div id="module-editor-module-dropdown" class="pull-right" style="text-align:right;color:var(--text-color-soft2);font-size:18px;padding-top:8px">Module Editor</div>';
    }
    
    public function run()
    {
        return '<div id="module-editor-topbar">' . $this->getModuleDropDownList() . parent::run() . '</div>';
    }
}
