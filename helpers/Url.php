<?php

namespace humhub\modules\moduleEditor\helpers;

use yii\helpers\Url as BaseUrl;
use yii\web\Controller;

class Url extends BaseUrl
{
    public const ROUTE_ADMIN = '/module-editor';

    public static function getConfigUrl(): string
    {
        return static::to([static::ROUTE_ADMIN]);
    }
	
    public static function getEditorUrl(string $moduleId, string $file = '/Module.php')
    {
        return static::to([static::ROUTE_ADMIN, 'moduleId' => $moduleId, 'file' => $file]);
    }
}
