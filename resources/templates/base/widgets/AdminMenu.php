<?php

namespace humhub\modules\{module_camelCase}\widgets;

use Yii;
use humhub\modules\ui\menu\MenuLink;
use humhub\modules\ui\menu\widgets\TabMenu;

class AdminMenu extends TabMenu
{
    public function init()
    {
        $this->addEntry(new MenuLink([
            'label' => Yii::t('{module_translation_base}.admin', 'General'),
            'url' => ['/{module_id}/admin/index'],
            'sortOrder' => 100,
            'isActive' => MenuLink::isActiveState('{module_id}', 'admin', 'index'),
            'isVisible' => true
        ]));

        parent::init();
    }
}
