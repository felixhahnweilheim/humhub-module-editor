<?php
use humhub\modules\moduleEditor\assets\BaseAssets;

BaseAssets::register($this);
?>
<div class="panel panel-default" style="max-width:98vw;margin: 0 auto">
    <?= \humhub\modules\moduleEditor\widgets\AdminMenu::widget(); ?>

    <div class="panel-body">
        <?= $content; ?>
    </div>
</div>