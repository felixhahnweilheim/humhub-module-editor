<?php

$this->beginContent('@admin/views/layouts/main.php') ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('{module_translation_base}.admin', '{module_title}'); ?>
    </div>

    <?= \humhub\modules\{module_camelCase}\widgets\AdminMenu::widget(); ?>

    <div class="panel-body">
        <?= $content; ?>
    </div>

</div>
<?php $this->endContent(); ?>
