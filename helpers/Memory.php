<?php

namespace humhub\modules\moduleEditor\helpers;

use humhub\modules\user\models\User;
use Yii;

class Memory
{
    static function saveLastModule(string $moduleId): bool
    {
        $settings = Yii::$app->getModule('module-editor')->settings->user();
        $settings->set('lastModule', $moduleId);
        
        return true;
    }
    
    static function getLastModule(): ?string
    {
        $settings = Yii::$app->getModule('module-editor')->settings->user();
        return $settings->get('lastModule');
    }
}