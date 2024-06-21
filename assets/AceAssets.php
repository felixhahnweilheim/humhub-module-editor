<?php

namespace humhub\modules\moduleEditor\assets;

class AceAssets extends \yii\web\AssetBundle
{
    public $publishOptions = [
        'forceCopy' => false
    ];
    
    public $sourcePath = 'resources';
    
    public $js = ['js/ace.js'];
}
