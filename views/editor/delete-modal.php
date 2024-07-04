<?php

use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\widgets\ModalButton;
use humhub\widgets\ModalDialog;

?>

<?php ModalDialog::begin(); ?>
<?php $form = ActiveForm::begin(); ?> 
<div class="modal-body" style="text-align:center">
    <h2><?= Yii::t('ModuleEditorModule.admin', 'Permanently delete this file?') ?></h2>
    <p><?= Yii::t('ModuleEditorModule.admin', 'Module:') . ' ' . $model->moduleId ?></p>
    <p><?= Yii::t('ModuleEditorModule.admin', 'File:') . ' ' . $model->file ?></p>
    <?= $form->field($model, 'moduleId')->hiddenInput(['value'=> $model->moduleId])->label(false) ?>
    <?= $form->field($model, 'file')->hiddenInput(['value'=> $model->file])->label(false) ?>
</div>
<div class="modal-footer">
    <?= ModalButton::cancel() ?>
    <?= ModalButton::submitModal(null, Yii::t('ModuleEditorModule.admin', 'Delete')) ?>
</div>
<?php ActiveForm::end(); ?>
<?php ModalDialog::end(); ?>