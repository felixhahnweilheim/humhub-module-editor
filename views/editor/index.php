<?php

use humhub\modules\moduleEditor\assets\AceAssets;
use humhub\modules\moduleEditor\assets\NavigatorAssets;
use humhub\modules\moduleEditor\helpers\Url;
use humhub\modules\moduleEditor\widgets\ModuleNavigator;
use humhub\modules\moduleEditor\widgets\FileNavigator;
use humhub\modules\moduleEditor\widgets\DeleteButton;
use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\libs\Html;
use humhub\modules\ui\icon\widgets\Icon;
use yii\web\View;

AceAssets::addAssetsFor($this, $model->extension);
NavigatorAssets::register($this);
?>
<div class="module-editor-nav-container">
    <?= ModuleNavigator::widget(['moduleId' => $model->moduleId]); ?>
    <?= FileNavigator::widget(['moduleId' => $model->moduleId, 'currentFile' => $model->file]) ?>
</div>
<?php $form = ActiveForm::begin(['id' => 'file-editor-form']); ?>
    <?= $form->field($model, 'file')->label(false); ?>
    <div class="form-group required">
        <div style="position:relative;width:100%;height:57vh;min-height:300px">
            <?= $form->field($model, 'content')->textarea(); ?>
            <div id="editor"><?= htmlspecialchars($model->content) ?></div>
        </div>
    </div>
    <div class="form-group">
        <?= DeleteButton::widget(['model' => $model]) ?>
        <?= Html::saveButton(Icon::get('floppy-o') . Yii::t('base', 'Save')) ?>
        <div class="button-help-text"><small>&nbsp;Ctrl + S</small></div>
    </div>
<?php ActiveForm::end() ?>