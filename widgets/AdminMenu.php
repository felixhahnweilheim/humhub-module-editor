<?php

namespace humhub\modules\moduleEditor\widgets;

use humhub\modules\moduleEditor\helpers\Url;
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
            'url' => Url::getEditorUrl(),
            'sortOrder' => 100,
            'isActive' => MenuLink::isActiveState('module-editor', 'editor', 'index'),
            'isVisible' => true
        ]));
        
        $this->addEntry(new MenuLink([
            'label' => Yii::t('ModuleEditorModule.admin', 'Create New Module'),
            'url' => Url::getCreateUrl(),
            'sortOrder' => 200,
            'isActive' => MenuLink::isActiveState('module-editor', 'create', 'index'),
            'isVisible' => true
        ]));
        
        $this->addEntry(new MenuLink([
            'label' => Yii::t('ModuleEditorModule.admin', 'Translations'),
            'url' => Url::getToolsUrl('messages'),
            'sortOrder' => 300,
            'isActive' => MenuLink::isActiveState('module-editor', 'tools', 'messages'),
            'isVisible' => true
        ]));

        parent::init();
    }
}
