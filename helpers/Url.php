<?php

namespace humhub\modules\moduleEditor\helpers;

use yii\helpers\Url as BaseUrl;
use yii\web\Controller;

class Url extends BaseUrl
{
    public const ROUTE_EDITOR = '/module-editor';
    public const ROUTE_ADMIN = '/module-editor/create';
    public const ROUTE_TOOLS = '/module-editor/tools';

    public static function getConfigUrl(): string
    {
        return static::getEditorUrl();
    }
	
    public static function getEditorUrl(string $moduleId = 'module-editor', string $file = '/Module.php')
    {
        return static::to([static::ROUTE_EDITOR, 'moduleId' => $moduleId, 'file' => $file]);
    }
    
    public static function getCreateUrl()
    {
        return static::to([static::ROUTE_CREATE]);
    }
    
    public static function getToolsUrl(string $tool = null)
    {
        return static::to([static::ROUTE_TOOLS . '/' . $tool]);
    }
}
