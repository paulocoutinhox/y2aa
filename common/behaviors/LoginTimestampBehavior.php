<?php

namespace common\behaviors;

use yii\base\Behavior;
use yii\web\User;
use yii\web\UserEvent;

class LoginTimestampBehavior extends Behavior
{

    /**
     * @var string
     */
    public $attribute = 'logged_at';


    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            User::EVENT_AFTER_LOGIN => 'afterLogin'
        ];
    }

    /**
     * @param $event UserEvent
     */
    public function afterLogin($event)
    {
        $user = $event->identity;
        $user->touch($this->attribute);
        $user->save(false);
    }

}
