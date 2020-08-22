<?php

namespace frontend\tests\unit\models;

use Codeception\Test\Unit;
use frontend\models\form\ContactForm;
use yii\mail\MessageInterface;

class ContactFormTest extends Unit
{
    public function testSendEmail()
    {
        $model = new ContactForm();

        $model->attributes = [
            'name' => 'Tester',
            'email' => 'customer@prsolucoes.com',
            'message' => 'very important letter subject',
            'verifyCode' => 'testme',
        ];

        expect_that($model->sendEmail('paulo@prsolucoes.com'));

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        /** @var MessageInterface $emailMessage */
        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('paulo@prsolucoes.com');
        expect($emailMessage->getFrom())->hasKey('customer@prsolucoes.com');
        expect($emailMessage->getReplyTo())->hasKey('paulo@prsolucoes.com');
        expect($emailMessage->getSubject())->equals('Site contact email');
        expect($emailMessage->toString())->stringContainsString('a new contact message has arrived from the site');
    }
}
