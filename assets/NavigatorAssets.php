<?php

namespace humhub\modules\moduleEditor\assets;

class AceAssets extends \humhub\components\assets\AssetBundle
{
    public $sourcePath = '@module-editor/resources/nav';

    public $publishOptions = [
        'forceCopy' => false
    ];

    public $css = [
        'module-editor-nav.css',
    ];
}
