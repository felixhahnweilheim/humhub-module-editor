<?php

use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\libs\Html;

?>

<?php $form = ActiveForm::begin(['id' => 'admin-index-form']); ?>
    <div class="form-group">
        <h3 style="margin-top:0"><?= Yii::t('ModuleEditorModule.admin', 'New Module') ?></h3>
    </div>
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
<?php ActiveForm::end(); ?>