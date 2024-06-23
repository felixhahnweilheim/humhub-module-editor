<?php

use humhub\modules\moduleEditor\assets\AceAssets;
use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\libs\Html;
use \yii\web\View;

AceAssets::addAssetsFor($this, $model->extension);
?>

<?= $model->getModuleNavigatorHtml() ?>
<?= $model->getFileNavigatorHtml() ?>

<?php $form = ActiveForm::begin(['id' => 'file-editor-form']); ?>
    <div class="form-group">
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