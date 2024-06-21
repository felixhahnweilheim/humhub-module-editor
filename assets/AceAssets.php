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
        $view->registerJS(
            'var editor = ace.edit("fileeditor-content");
            editor.setTheme("ace/theme/monokai");
            editor.session.setMode("ace/mode/php")',
            View::POS_END
        );
        $view->registerCSS(
            '#fileeditor-content { 
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
            }'
        );
        return parent::register($view);
    }
}
