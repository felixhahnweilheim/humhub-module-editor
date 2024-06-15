<?php

use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\libs\Html;

?>

<?php $form = ActiveForm::begin(['id' => 'admin-index-form']); ?>
    <div class="form-group">
        <h3 style="margin-top:0"><?= Yii::t('ModuleEditorModule.admin', 'Module Editor') ?></h3>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'moduleId'); ?>
        <?= $form->field($model, 'moduleTitle'); ?>
        <?= $form->field($model, 'moduleDescription'); ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton(\Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']); ?>
    </div>
<?php ActiveForm::end(); ?>