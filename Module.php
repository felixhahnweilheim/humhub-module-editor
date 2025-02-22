<?php

namespace humhub\modules\moduleEditor;

use humhub\modules\moduleEditor\helpers\Url;
use Yii;

class Module extends \humhub\components\Module
{
    public $resourcesPath = 'resources';
    public $defaultRoute = 'editor';

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
