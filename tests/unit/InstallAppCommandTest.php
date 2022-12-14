<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Unit;

use App\Commands\InstallAppCommand;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Console;
use Symfony\Component\Process\Process;

class InstallAppCommandTest extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;

    public function testInstantiation(): InstallAppCommand
    {
        $sut = new InstallAppCommand();

        $this->assertInstanceOf(Console\Command\Command::class, $sut);


        return $sut;
    }

    /**
     * @depends testInstantiation
     */
    public function testExecution(InstallAppCommand $sut): void
    {
        // Mock internal processes inside SUT
        $sut->setProcessFactory(fn () => new Process(['echo', 'foo']));

        $application = new Console\Application();
        $application->add($sut);

        $command_name = $sut->getName();
        $command = $application->find($command_name);

        $tester = new Console\Tester\CommandTester($command);
        $tester->execute([]);

        $tester->assertCommandIsSuccessful();

        $command_output = $tester->getDisplay();

        $this->assertMatchesRegularExpression("/Install Composer dependencies/", $command_output);
        $this->assertMatchesRegularExpression("/Dump Composer autoloader/", $command_output);
        $this->assertMatchesRegularExpression("/Install node\/npm\/JS dependencies/", $command_output);
        $this->assertMatchesRegularExpression("/Repo information/", $command_output);
    }
}
