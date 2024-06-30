<?php

use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\libs\Html;

?>

<?php $form = ActiveForm::begin(['id' => 'admin-index-form']); ?>
    <div class="form-group">
        <h3 style="margin-top:0"><?= Yii::t('ModuleEditorModule.admin', 'Create/Update module messages') ?></h3>
    </div>
    <?php if (isset($model->response)): ?>
        <div>
            <b><?= Yii::t('ModuleEditorModule.admin', 'Response') ?></b>
            <pre>
                <?= $model->response ?>
            </pre>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <?= $form->field($model, 'moduleId')->dropdownList($model->getModules()); ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('ModuleEditorModule.admin', 'Create/Update'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']); ?>
    </div>
<?php ActiveForm::end(); ?>
