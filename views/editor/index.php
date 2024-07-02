<?php

use humhub\modules\moduleEditor\assets\AceAssets;
use humhub\modules\moduleEditor\assets\NavigatorAssets;
use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\libs\Html;
use \yii\web\View;

AceAssets::addAssetsFor($this, $model->extension);
NavigatorAssets::register($this);
?>
<div class="module-editor-nav-container">
    <?= $model->getModuleNavigatorHtml() ?>
    <?= $model->getFileNavigatorHtml() ?>
</div>
<?php $form = ActiveForm::begin(['id' => 'file-editor-form']); ?>
    <h2 style="margin-top:0">
        <?= $model->oldFile ? Yii::t('ModuleEditorModule.admin', 'Edit File') : Yii::t('ModuleEditorModule.admin', 'New File')?>
    </h2>
    <div class="form-group filename">
        <?= $form->field($model, 'file'); ?>
    </div>
    <div class="form-group required"><label><?= Yii::t('ModuleEditorModule.admin', 'Content') ?></label></div>
    <div class="form-group" style="position:relative;width:100%;height:500px;">
        <?= $form->field($model, 'content')->textarea(); ?>
        <div id="editor"><?= htmlspecialchars($model->content) ?></div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(\Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']); ?>
    </div>
<?php ActiveForm::end(); ?>