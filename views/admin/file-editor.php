<?php

use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\libs\Html;

?>

<?php $form = ActiveForm::begin(['id' => 'admin-index-form']); ?>
    <div class="form-group">
        <h3 style="margin-top:0"><?= Yii::t('ModuleEditorModule.admin', 'File Editor') ?></h3>
    </div>
    <div class="form-group">
        <p><?= Yii::t('ModuleEditorModul.admin', 'Module: ') . $model->moduleId ?></p>
        <p><?= Yii::t('ModuleEditorModul.admin', 'File: ') . $model->file ?></p>
        <?= $form->field($model, 'content')->textarea(['rows' => 20]); ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton(\Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']); ?>
    </div>
<?php ActiveForm::end(); ?>