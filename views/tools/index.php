<?php

use humhub\modules\moduleEditor\assets\ToolsAssets;
use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\widgets\Button;
use humhub\libs\Html;

ToolsAssets::register($this);
?>

<?php $form = ActiveForm::begin(['id' => 'admin-index-form']); ?>
    <div class="form-group">
        <?= $form->field($model, 'moduleId')->dropdownList($model->getModules()); ?>
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
    <label class="control-label" for="exclude-input"><?= Yii::t("ModuleEditorModule.admin", "Exclude paths") ?></label>
    <div>
        <div id="default-exclude-button" class="btn btn-sm btn-default"><?= Yii::t('ModuleEditorModule.admin', 'Set to default') ?></div> 
        <div id="remove-button" class="btn btn-sm btn-default"><?= Yii::t('ModuleEditorModule.admin', 'Remove') ?></div>
    <textarea style="width:100%;height: 90px;resize:vertical" name="exclude-input" rows="20" style="height:100px"></textarea>
    </div>
</div>
<div class="form-group">
    <?= Button::primary(Yii::t('ModuleEditorModule.admin', 'Download'))->icon('download')->link(['#'])->loader(false)->id('download-zip-btn') ?>
</div>
<?php ActiveForm::end(); ?>
