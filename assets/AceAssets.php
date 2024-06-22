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
    
    public static function addAssetsFor($view, string $fileType)
    {
        switch ($fileType) {
            case 'php':
                $mode = 'php';
                break;
            case 'js':
                $mode = 'javascript';
                break;
            default:
                $mode = 'text';
                break;
        }
        $view->registerJS(
            'var editor = ace.edit("editor");
            editor.setTheme("ace/theme/monokai");
            editor.session.setMode("ace/mode/' . $mode . '");
            editor.session.setUseWrapMode(true)
            editor.session.on("change", function(delta){
                document.forms["file-editor-form"]["FileEditor[content]"].value = editor.getValue();
            });',
            View::POS_END
        );
        $view->registerCSS(
            '#editor {
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
