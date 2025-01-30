<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class HomepageCest
{    
    public function _before(AcceptanceTester $acceptanceTester)
    {
    }

    public function seeHeading(AcceptanceTester $acceptanceTester)
    {
        $acceptanceTester->amOnPage('/');
        $acceptanceTester->wantTo('Test the Homepage');
        $acceptanceTester->see('Heading 1', '/html/body/h1');
    }

}
