<?php

namespace w3lifer\yii2\translator;

use yii\base\InvalidConfigException;

class Module extends \yii\base\Module
{
    /**
     * @var string
     */
    public $email;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if (!$this->email) {
            throw new InvalidConfigException('You must specify an email');
        }
    }
}
