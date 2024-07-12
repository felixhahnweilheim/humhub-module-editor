<?php

namespace humhub\modules\moduleEditor\assets;

class ToolsAssets extends \humhub\components\assets\AssetBundle
{
    public $sourcePath = '@module-editor/resources/tools';

    public $publishOptions = [
        'forceCopy' => false
    ];

    public $js = [
        'humhub-module-editor.tools.js'
    ];
    
    public $defer = false;
}
