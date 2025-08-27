<?php

namespace humhub\modules\moduleEditor\widgets;

use humhub\modules\moduleEditor\helpers\Url;
use humhub\modules\moduleEditor\models\FileEditor;
use humhub\components\Widget;
use humhub\modules\ui\icon\widgets\Icon;
use humhub\helpers\Html;

/**
 * Delete Button for File Editor
 */
class DeleteButton extends Widget
{
    public FileEditor $model;
    
    public function run(): string
    {
        if ($this->model->oldFile) {
            $icon = Icon::get('trash-o');
            $options = [
                'class' => 'btn pull-right',
                'style' => 'color:var(--danger);font-size:1.5em',
                'href' => '#',
                'id' => 'delete-button',
                'data-action-click' => 'ui.modal.load',
                'data-action-click-url' => Url::getDeleteUrl($this->model->moduleId, $this->model->file)
            ];
            return Html::a($icon, '#', $options);
        }
        return '';
    }
    
    private function getBasePath(): string
    {
        return Yii::getAlias('@' . $this->moduleId);
    }
}
