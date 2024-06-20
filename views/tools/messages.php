<?php

use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\libs\Html;

?>

<?php $form = ActiveForm::begin(['id' => 'admin-index-form']); ?>
    <div class="form-group">
        <h3 style="margin-top:0"><?= Yii::t('ModuleEditorModule.admin', 'Create/Update module <strong>messages</strong>') ?></h3>
    </div>
    <?php if (isset($model->response)): ?>
        <div>
            <?= $model->response ?>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <?= $form->field($model, 'moduleId'); ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('ModuleEditorModule.admin', 'Create/Update Module Messages'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']); ?>
    </div>
<?php ActiveForm::end(); ?>