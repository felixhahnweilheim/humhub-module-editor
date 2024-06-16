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
            'label' => Yii::t('ModuleEditorModule.admin', 'File Editor'),
            'url' => ['/module-editor'],
            'sortOrder' => 100,
            'isActive' => MenuLink::isActiveState('module-editor', 'editor', 'index'),
            'isVisible' => true
        ]));
        
        $this->addEntry(new MenuLink([
            'label' => Yii::t('ModuleEditorModule.admin', 'Create New Module'),
            'url' => ['/module-editor/create'],
            'sortOrder' => 200,
            'isActive' => MenuLink::isActiveState('module-editor', 'create', 'index'),
            'isVisible' => true
        ]));

        parent::init();
    }
}
