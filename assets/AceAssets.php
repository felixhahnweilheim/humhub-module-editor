<?php

namespace humhub\modules\moduleEditor\assets;

use humhub\modules\moduleEditor\models\FileEditor;
use yii\web\View;

class AceAssets extends \humhub\components\assets\AssetBundle
{
    public $sourcePath = '@module-editor/resources/ace';

    public $publishOptions = [
        'forceCopy' => false
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
            
            var userConfirmed = false;
            var unloadListener = function() {
                return "Changes you made might not be saved.";
            };
            var pjaxBeforeListener = function(evt, xhr, options) {
                if (userConfirmed === false) {
                    userConfirmed = confirm("Changes you made might not be saved.");
                }
                return userConfirmed;
            };
            var pjaxAfterListener = function(evt, xhr, options) {
                 $(document).off("pjax:beforeSend", "**");
            };
            var isFirstChange = 1;
            
            $(document).on("pjax:success", pjaxAfterListener);
            editor.session.on("change", function(delta){
                document.forms["file-editor-form"]["FileEditor[content]"].value = editor.getValue();
                if (isFirstChange === 1) {
                    window.onbeforeunload = unloadListener;
                    window.addEventListener("beforeunload", unloadListener);
                    $(document).on("pjax:beforeSend", "**", pjaxBeforeListener);
                    isFirstChange = 0;
                }
            });
            $( "#file-editor-form" ).on( "submit", function( event ) {
                window.removeEventListener("beforeunload", unloadListener);
                window.onbeforeunload = null;
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
