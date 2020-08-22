<?php

namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class HomeCest
{
    public function checkHome(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/index'));
        $I->see('Y2AA');

        $I->seeLink('About us');
        $I->click('About us');
        $I->wait(2); // wait for page to be opened

        $I->see('Insert content.');
    }
}
