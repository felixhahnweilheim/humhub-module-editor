<?php

use humhub\modules\moduleEditor\assets\ToolsAssets;
use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\modules\ui\icon\widgets\Icon;
use humhub\widgets\Button;
use humhub\libs\Html;

ToolsAssets::register($this);
?>

<?php $form = ActiveForm::begin(['id' => 'admin-index-form']); ?>
    <?= Html::activeHiddenInput($model, 'moduleId') ?>
<div class="row">
    <div class="col-md-6">
    <div class="form-group">
        <h2 style="margin-top:0;font-size:24px;font-weight:300"><?= Yii::t('ModuleEditorModule.admin', 'Create/Update module messages') ?></h2>
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
        <?= Html::saveButton(Icon::get('language') . ' ' . Yii::t('ModuleEditorModule.admin', 'Create/Update'), ['id' => "messages-btn"]) ?>
    </div>
    </div>
    <div class="col-md-6">
<div class="form-group">
    <h2 style="margin-top:0;font-size:24px;font-weight:300"><?= Yii::t('ModuleEditorModule.admin', 'Download Module Files (zip)') ?></h2>
</div>

<div class="form-group">
    <label class="control-label" for="exclude-input"><?= Yii::t("ModuleEditorModule.admin", "Exclude paths") ?> (regex)</label>
    <div>
        <div id="default-exclude-button" class="btn btn-sm btn-default"><?= Icon::get('add') ?> <?= Yii::t('ModuleEditorModule.admin', 'Default for Marketplace') ?></div> 
        <div id="remove-button" class="btn btn-sm btn-default"><?= Icon::get('remove') ?> <?= Yii::t('ModuleEditorModule.admin', 'Remove') ?></div>
    <textarea style="width:100%;height: 90px;resize:vertical" name="exclude-input" rows="20" style="height:100px"></textarea>
    </div>
</div>
<div class="form-group">
    <?= Button::primary(Yii::t('ModuleEditorModule.admin', 'Download'))->icon('download')->link(['#'])->loader(false)->id('download-zip-btn') ?>
</div>
</div>
</div>
<?php ActiveForm::end(); ?>
