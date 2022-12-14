<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Unit;

use App\Commands\SillyCreateCustomFileFromDist;
use Prophecy\PhpUnit\ProphecyTrait;

class SillyCreateCustomFileFromDistTest extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;

    public function testInstantiation(): SillyCreateCustomFileFromDist
    {
        $silly_mock = $this->prophesize(\Silly\Application::class);
        $silly = $silly_mock->reveal();

        $sut = new SillyCreateCustomFileFromDist($silly, "dist", "custom");

        $this->assertIsCallable($sut);

        return $sut;
    }
}
