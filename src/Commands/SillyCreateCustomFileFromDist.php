<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Silly;

class SillyCreateCustomFileFromDist
{
    /**
     * @var string
     */
    public $custom_file;

    /**
     * @var string
     */
    public $dist_file;

    /**
     * @var \Silly\Application
     */
    public $app;


    public function __construct(Silly\Application $application, string $dist_file, string $custom_file)
    {
        $this->app = $application;
        $this->dist_file = $dist_file;
        $this->custom_file = $custom_file;
    }


    public function __invoke(InputInterface $input, OutputInterface $output, bool $yes): int
    {
        if (is_file($this->custom_file)) {
            return Command::SUCCESS;
        }

        $output->writeln([
            sprintf("Dist file:   %s", $this->dist_file),
            sprintf("Custom file: %s", $this->custom_file),
            "",
            "Custom file does not exist and must be created.",
        ]);

        $confirmationQuestion = new ConfirmationQuestion('Create? (y/n) ', false);

        $helper = $this->app->getHelperSet()->get('question');

        // PhpStan shall ignore
        // "Call to an undefined method Symfony\Component\Console\Helper\HelperInterface::ask()."
        /** @phpstan-ignore-next-line */
        if ($yes || $helper->ask($input, $output, $confirmationQuestion)) {
            if (!is_file($this->dist_file)) {
                $output->writeln("Dist file not found.");
                return Command::FAILURE;
            }

            $copy_result = copy($this->dist_file, $this->custom_file);
            if (!$copy_result) {
                $output->writeln('Failed.');
                return Command::FAILURE;
            }

            $output->writeln([
                'Created.',
                'Open custom file in your editor and adapt to your needs.',
                ""
            ]);
        }

        return Command::SUCCESS;
    }
}
