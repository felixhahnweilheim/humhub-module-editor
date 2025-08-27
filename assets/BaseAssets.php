<?php

namespace humhub\modules\moduleEditor\assets;

class BaseAssets extends \humhub\components\assets\AssetBundle
{
    public $sourcePath = '@module-editor/resources/base';

    public $publishOptions = [
        'forceCopy' => false
    ];

    public $css = [
        'module-editor.css',
    ];
    
    public $js = [
        'module-editor.js'
    ];
}
