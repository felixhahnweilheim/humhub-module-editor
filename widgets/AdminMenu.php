<?php

namespace humhub\modules\moduleEditor\widgets;

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
            'label' => Yii::t('ModuleEditorModule.admin', 'General'),
            'url' => ['/module-editor/admin/index'],
            'sortOrder' => 100,
            'isActive' => MenuLink::isActiveState('module-editor', 'admin', 'index'),
            'isVisible' => true
        ]));
        
        $this->addEntry(new MenuLink([
            'label' => Yii::t('{module_PascalCase}Module.admin', 'File Editor'),
            'url' => ['/{module_id}/admin/file-editor'],
            'sortOrder' => 200,
            'isActive' => MenuLink::isActiveState('{module_id}', 'admin', 'file-editor'),
            'isVisible' => true
        ]));

        parent::init();
    }
}
