<?php

namespace humhub\modules\moduleEditor\helpers;

use yii\helpers\Url as BaseUrl;
use yii\web\Controller;

class Url extends BaseUrl
{
    public const ROUTE_ADMIN = '/module-editor';

    public static function getConfigUrl(): string
    {
        return static::toRoute(static::ROUTE_ADMIN);
    }
}
