<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class HomepageCest
{    
    public function _before(AcceptanceTester $I)
    {
    }

    public function seeHeading(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->wantTo('Test the Homepage');
        $I->see('Heading 1', '/html/body/h1');
    }

}
