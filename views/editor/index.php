<?php

use humhub\modules\moduleEditor\assets\AceAssets;
use humhub\modules\moduleEditor\helpers\Url;
use humhub\modules\moduleEditor\widgets\FileNavigator;
use humhub\modules\moduleEditor\widgets\DeleteButton;
use humhub\widgets\form\ActiveForm;
use humhub\helpers\Html;
use humhub\modules\ui\icon\widgets\Icon;
use humhub\components\View;

AceAssets::addAssetsFor($this, $model->extension);
?>

<?php foreach ($errors as $error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endforeach; ?>

<?php $form = ActiveForm::begin(['id' => 'file-editor-form']); ?>
<div class="row">
<div class="col col-xl-2 col-md-3 col-sm-4 module-editor-nav-container">
    <?= FileNavigator::widget(['moduleId' => $model->moduleId, 'currentFile' => $model->file]); ?>
</div>
<div class="col col-xl-10 col-md-9 col-sm-8 module-editor-main">
    <?php if ($model->oldFile === null): ?>
        <h1 style="font-size:14px"><?= Yii::t('ModuleEditorModule.admin', 'Create New File') ?></h1>
    <?php endif; ?>
    <?= $form->field($model, 'file')->label(false); ?>
    <div class="form-group required" style="margin-top:0;margin-bottom:5px">
        <div style="position:relative;width:100%;height:57vh;min-height:300px">
            <?= $form->field($model, 'content')->textarea(); ?>
            <div id="editor"><?= htmlspecialchars($model->content) ?></div>
        </div>
    </div>
    <div class="form-group" style="margin-bottom:0">
        <?= DeleteButton::widget(['model' => $model]) ?>
        <?= Html::saveButton(Icon::get('floppy-o') . Yii::t('base', 'Save'), ['style' => 'float:left;margin-right:5px']) ?>
        <div class="button-help-text" style="padding: 10px 5px"><small>&nbsp;Ctrl + S</small></div>
    </div>
</div>
<?php ActiveForm::end() ?>