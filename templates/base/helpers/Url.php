<?php

namespace humhub\modules\{module_camelCase}\helpers;

use yii\helpers\Url as BaseUrl;
use yii\web\Controller;

class Url extends BaseUrl
{
    public const ROUTE_ADMIN = '/{module_id}/admin';

    public static function getConfigUrl(): string
    {
        return static::toRoute(static::ROUTE_ADMIN);
    }
}
