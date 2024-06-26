<?php

namespace humhub\modules\moduleEditor\assets;

use humhub\modules\moduleEditor\models\FileEditor;
use yii\web\View;

class AceAssets extends \humhub\components\assets\AssetBundle
{
    public $sourcePath = '@module-editor/resources/ace';

    public $publishOptions = [
        'forceCopy' => true
    ];

    public $js = [
        'ace.js',
    ];
    
    public $defer = false;
    
    public static function addAssetsFor($view, string $fileType)
    {
        $success = parent::register($view);
        if (isset(FileEditor::ACE_MODES[$fileType])) {
            $mode = FileEditor::ACE_MODES[$fileType];
        } else {
            $mode = 'text';
        }
        $view->registerJS(
            'var editor = ace.edit("editor");
            editor.setTheme("ace/theme/monokai");
            editor.session.setMode("ace/mode/' . $mode . '");
            editor.session.setUseWrapMode(true);
            editor.session.setTabSize(4);
            editor.session.setUseSoftTabs(true);
            editor.setOption("showInvisibles", true);
            var unloadListener = function() {
                return "Changes you made might not be saved.";
            };
            editor.session.on("change", function(delta){
                document.forms["file-editor-form"]["FileEditor[content]"].value = editor.getValue();
                window.onbeforeunload = function() {
                    return "Changes you made might not be saved.";
                };
                window.addEventListener("beforeunload", unloadListener);
            });
            $( "#file-editor-form" ).on( "submit", function( event ) {
                window.removeEventListener("beforeunload", unloadListener);
                window.onbeforeunload = null;
            });
            $(document).on("pjax:beforeSend", function (evt, xhr, options) {
                return confirm("Changes you made might not be saved.");
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
        return $success;
    }
}
