<?php

namespace humhub\modules\{module_camelCase};

use humhub\modules\{module_camelCase}\helpers\Url;
use Yii;

class Module extends \humhub\components\Module
{
    public $resourcesPath = 'resources';
    
    // Translatable Module Title
    public function getName(): string
    {
        return Yii::t('{module_translation_base}.admin', '{module_title}');
    }

    // Translatable Module Description
    public function getDescription(): string
    {
        return Yii::t('{module_translation_base}.admin', '{module_description}');
    }

    // Link to configuration page
    public function getConfigUrl(): string
    {
        return Url::getConfigUrl();
    }
}
