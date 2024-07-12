<?php

use humhub\modules\moduleEditor\assets\ToolsAssets;
use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\widgets\Button;
use humhub\libs\Html;

ToolsAssets::register($this);
?>

<?php $form = ActiveForm::begin(['id' => 'admin-index-form']); ?>
    <div class="form-group">
        <?= $form->field($model, 'moduleId')->dropdownList($model->getModules(), ['prompt' => Yii::t('ModuleEditorModule.admin', 'Select module ...')]); ?>
    </div>
    <div class="form-group">
        <h2 style="margin-top:0"><?= Yii::t('ModuleEditorModule.admin', 'Create/Update module messages') ?></h3>
    </div>
    <?php if (isset($model->response)): ?>
        <div>
            <b><?= Yii::t('ModuleEditorModule.admin', 'Response') ?></b>
            <pre style="max-height: 300px">
                <?= $model->response ?>
            </pre>
        </div>
    <?php endif; ?>
    
    <div class="form-group">
        <?= Html::saveButton(Yii::t('ModuleEditorModule.admin', 'Create/Update'), ['id' => "messages-btn"]) ?>
    </div>
    
    <div class="form-group">
    <h2><?= Yii::t('ModuleEditorModule.admin', 'Download Module Files (zip)') ?></h3>
</div>
<div class="form-group">
    <?= Button::primary(Yii::t('ModuleEditorModule.admin', 'Download'))->icon('download')->link(['tools/download-zip'])->loader(false)->id('download-zip-btn') ?>
</div>
<?php ActiveForm::end(); ?>
