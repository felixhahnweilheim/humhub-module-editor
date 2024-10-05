<?php

namespace humhub\modules\moduleEditor\assets;

use humhub\modules\moduleEditor\models\FileEditor;
use Yii;
use yii\web\View;

class AceAssets extends \humhub\components\assets\AssetBundle
{
    public $sourcePath = '@module-editor/resources/ace';

    public $publishOptions = [
        'forceCopy' => false
    ];

    public $js = [
        'src-min/ace.js',
        'humhub-module-editor.js'
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
        $view->registerJSConfig('module_editor', [
            'mode' => $mode,
            'text' => [
                'warning.notsaved' => Yii::t('ModuleEditorModule.admin', 'Changes you made might not be saved.'),
                'solveErrors' => Yii::t('ModuleEditorModule.admin', 'Solve syntax errors before saving the file!')
            ]
        ]);
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
