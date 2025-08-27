<?php

namespace humhub\modules\moduleEditor\assets;

use humhub\modules\moduleEditor\models\FileEditor;
use Yii;
use humhub\components\View;

class AceAssets extends \humhub\components\assets\AssetBundle
{
    public $publishOptions = [
        'forceCopy' => false
    ];
    
    public $sourcePath = '@module-editor/resources/ace';
    
    public $js = [
        'src-min/ace.js',
        'humhub-module-editor-ace.js'
    ];
    
    public $defer = false;
    
    public static function addAssetsFor(View $view, ?string $fileType)
    {
        $success = parent::register($view);
        if (isset($fileType) && isset(FileEditor::ACE_MODES[$fileType])) {
            $mode = FileEditor::ACE_MODES[$fileType];
        } else {
            $mode = 'text';
        }
        $view->registerJSConfig('module_editor.ace', [
            'mode' => $mode,
            'text' => [
                'warning.notSaved' => Yii::t('ModuleEditorModule.admin', 'Changes you made might not be saved.'),
                'warning.solveErrors' => Yii::t('ModuleEditorModule.admin', 'Solve syntax errors before saving the file!')
            ]
        ]);
        return $success;
    }
}
