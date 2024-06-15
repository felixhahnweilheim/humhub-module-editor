<?php

namespace humhub\modules\moduleEditor;

use humhub\modules\moduleEditor\helpers\Url;
use Yii;

class Module extends \humhub\components\Module
{
    public $resourcesPath = 'resources';
    
    // Translatable Module Title
    public function getName(): string
    {
        return Yii::t('ModuleEditorModule.admin', 'Module Editor');
    }

    // Translatable Module Description
    public function getDescription(): string
    {
        return Yii::t('ModuleEditorModule.admin', 'Create and edit modules via UI');
    }

    // Link to configuration page
    public function getConfigUrl(): string
    {
        return Url::getConfigUrl();
    }
}
