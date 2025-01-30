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
        $installAppCommand = new InstallAppCommand();

        $this->assertInstanceOf(Console\Command\Command::class, $installAppCommand);


        return $installAppCommand;
    }

    /**
     * @depends testInstantiation
     */
    public function testExecution(InstallAppCommand $installAppCommand): void
    {
        // Mock internal processes inside SUT
        $installAppCommand->setProcessFactory(fn () => new Process(['echo', 'foo']));

        $application = new Console\Application();
        $application->add($installAppCommand);

        $command_name = $installAppCommand->getName();
        $command = $application->find($command_name);

        $commandTester = new Console\Tester\CommandTester($command);
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();

        $command_output = $commandTester->getDisplay();

        $this->assertMatchesRegularExpression("/Install Composer dependencies/", $command_output);
        $this->assertMatchesRegularExpression("/Dump Composer autoloader/", $command_output);
        $this->assertMatchesRegularExpression("/Install node\/npm\/JS dependencies/", $command_output);
        $this->assertMatchesRegularExpression("/Repo information/", $command_output);
    }
}
