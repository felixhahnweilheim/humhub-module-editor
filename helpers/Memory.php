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
    
    /**
     * saves last edited file with its module
     * deletes the setting if file is null
     */
    static function saveLastEditedFile(?string $moduleId, ?string $file): bool
    {
        $settings = Yii::$app->getModule('module-editor')->settings->user();
        if ($file === null) {
            $settings->delete('lastFile');
        } else {
            $settings->set('lastFile', $moduleId . ',' . $file);
        }
        return true;
    }
    
    static function getLastFile(): array
    {
        $setting = Yii::$app->getModule('module-editor')->settings->user()->get('lastFile');
        return !empty($setting) ? explode(',', $setting) : [null, null];
    }
}
