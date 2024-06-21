<?php

use humhub\modules\moduleEditor\assets\AceAssets;
use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\libs\Html;
use \yii\web\View;

AceAssets::register($this);
?>

<p><details>
    <summary style="display:list-item;margin-bottom:1em">
        <b><?= Yii::t('ModuleEditorModule.admin', 'Module:'); ?></b> <?= $model->moduleId ?> 
   </summary>

    <?php foreach($model->getModulesUrls(true) as $id => $url): ?>
        <p><a href="<?= $url ?>"><?= $id ?></a></p>
    <?php endforeach; ?>
</details></p>

<p><details>
    <summary style="display:list-item;margin-bottom:1em">
        <b><?= Yii::t('ModuleEditorModule.admin', 'File:')?></b> <?= $model->file ?>
    </summary>

    <?php foreach($model->getFilesUrls(true) as $file => $url): ?>
        <?php if (!empty($url)): ?>
            <p><a href="<?= $url ?>"><?= $file ?></a></p>
        <?php else: ?>
            <p><?= $file ?></p>
        <?php endif; ?>
    <?php endforeach; ?>
</details></p>

<?php $form = ActiveForm::begin(['id' => 'admin-index-form']); ?>
    <div class="form-group" style="position:relative;width:100%;height:500px;">
        <?= $form->field($model, 'content')->textarea(); ?>
        <div id="editor"><?= htmlspecialchars($model->content) ?></div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(\Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']); ?>
    </div>
<?php ActiveForm::end(); ?>