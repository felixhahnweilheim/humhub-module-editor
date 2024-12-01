<?php

namespace humhub\modules\moduleEditor\helpers;

use yii\helpers\Url as BaseUrl;
use yii\web\Controller;

class Url extends BaseUrl
{
    public const ROUTE_EDITOR = '/module-editor';
    public const ROUTE_CREATE = '/module-editor/create';
    public const ROUTE_TOOLS = '/module-editor/tools';
    public const ROUTE_DELETE = '/module-editor/editor/delete-modal';

    public static function getConfigUrl(): string
    {
        return static::getEditorUrl();
    }
	
    public static function getEditorUrl(string $moduleId = null, ?string $file = "/Module.php")
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
    
    public static function getDeleteUrl(string $moduleId, string $file)
    {
        return static::to([static::ROUTE_DELETE, 'moduleId' => $moduleId, 'file' => $file]);
    }
}
