<?php

use humhub\widgets\modal\ModalButton;
use humhub\widgets\modal\Modal;

?>

<?php $form = Modal::beginFormDialog([
    'footer' => ModalButton::cancel() . ModalButton::save(Yii::t('ModuleEditorModule.admin', 'Delete'))->submit(),
]); ?>
<div class="text-center">
    <h2><?= Yii::t('ModuleEditorModule.admin', 'Permanently delete this file?') ?></h2>
    <p><?= Yii::t('ModuleEditorModule.admin', 'Module:') . ' ' . $model->moduleId ?></p>
    <p><?= Yii::t('ModuleEditorModule.admin', 'File:') . ' ' . $model->file ?></p>
    <?= $form->field($model, 'moduleId')->hiddenInput(['value'=> $model->moduleId])->label(false) ?>
    <?= $form->field($model, 'file')->hiddenInput(['value'=> $model->file])->label(false) ?>
</div>
<?php Modal::endFormDialog(); ?>