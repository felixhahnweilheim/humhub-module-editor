<?php

namespace humhub\modules\moduleEditor\helpers;

use Yii;

class BaseHelper
{
    /**
     * returns an array of all non-core modules, enabled and disabled
     * array keys are module ids, values are module name and id in brackets
     */
    public static function getModules(): array
    {
        $result = [];
        $modules = Yii::$app->moduleManager->getModules();
        foreach ($modules as $id => $module) {
            $result[$id] = $module->getName() . ' (' . $id . ')';
        }
        return $result;
    }
    
    /**
     * maybe later: only modules in custom module folder
     */
    public static function isAllowedModule(string $moduleId): bool
    {
        $modules = self::getModules();
        if (isset($modules[$moduleId])) {
            return true;
        }
        return false;
    }
}