<?php

namespace humhub\modules\moduleEditor\assets;

use \yii\web\View;

class AceAssets extends \humhub\components\assets\AssetBundle
{
    public $sourcePath = '@module-editor/resources';

    public $publishOptions = [
        'forceCopy' => false
    ];

    public $js = [
        'js/ace.js',
    ];
    
    public $defer = false;
    
    public static function register($view)
    {
        $view->registerJS('
            var editor = ace.edit("editor");
            editor.setTheme("ace/theme/monokai");
            editor.session.setMode("ace/mode/javascript")', View::POS_END);
        return parent::register($view);
    }
}
