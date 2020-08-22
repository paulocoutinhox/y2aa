<?php

namespace common\components\ui\picker;

use Yii;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class TimeZonePicker extends InputWidget
{

    const SORT_NAME = 0;
    const SORT_OFFSET = 1;
    public $template = '{name} {offset}';
    public $sortBy = 0;

    /** @var string|null */
    public $selection = null;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $timeZones = [];
        $timeZonesOutput = [];
        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        foreach (\DateTimeZone::listIdentifiers(\DateTimeZone::ALL) as $timeZone) {
            $now->setTimezone(new \DateTimeZone($timeZone));
            $timeZones[] = [$now->format('P'), $timeZone];
        }

        if ($this->sortBy == static::SORT_OFFSET) {
            array_multisort($timeZones);
        }

        foreach ($timeZones as $timeZone) {
            $content = preg_replace_callback("/{\\w+}/", function ($matches) use ($timeZone) {
                switch ($matches[0]) {
                    case '{name}':
                        return $timeZone[1];
                    case '{offset}':
                        return ' (GMT ' . $timeZone[0] . ')';
                    default:
                        return $matches[0];
                }
            }, $this->template);

            $timeZonesOutput[$timeZone[1]] = $content;
        }

        if ($this->hasModel()) {
            $attributeName = $this->attribute;

            if (empty($this->model->$attributeName)) {
                $this->model->$attributeName = Yii::$app->params['defaultTimeZone'];
            }

            echo Html::activeDropDownList($this->model, $this->attribute, $timeZonesOutput, $this->options);
        } else {
            if (empty($this->selection)) {
                $this->selection = Yii::$app->params['defaultTimeZone'];
            }

            echo Html::dropDownList($this->name, $this->selection, $timeZonesOutput, $this->options);
        }
    }

}