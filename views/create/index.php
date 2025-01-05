<?php

use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\libs\Html;

?>

<?php $form = ActiveForm::begin(['id' => 'admin-index-form']); ?>
<div style="max-width:600px;margin:0 auto">
    <div class="form-group">
        <?= $form->field($model, 'modulePath')->dropDownList($model->getModulePaths()); ?>
        <?= $form->field($model, 'moduleId'); ?>
        <?= $form->field($model, 'moduleTitle'); ?>
        <?= $form->field($model, 'moduleDescription'); ?>
        <?= $form->field($model, 'moduleMinHumHub'); ?>
        <?= $form->field($model, 'moduleAuthor'); ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('ModuleEditorModule.admin', 'Create'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
