<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Commands;

# https://symfony.com/doc/current/console/style.html#content-methods
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Attribute\AsCommand;

use Symfony\Component\Process;

#[AsCommand(
    name: 'install',
    description: 'Perform installation'
)]
class InstallAppCommand extends Command
{

    /**
     * @var callable
     */
    protected $process_factory;

    /**
     * @var string[]
     */
    protected $directories;

    /**
     * @var string
     */
    protected $pem_directory;


    /**
     * @param string[] $directories Utility Directories
     */
    public function __construct(array $directories = [])
    {
        $this->directories = $directories;
        $this->setProcessFactory(fn(...$args) => new Process\Process(...$args));
        parent::__construct();
    }


    public function setProcessFactory(callable $process_factory): self
    {
        $this->process_factory = $process_factory;
        return $this;
    }

    public function setCertificatesDirectory(string $directory): self
    {
        $this->pem_directory = $directory;
        return $this;
    }


    // Define a description, help message and the input options and arguments:
    protected function configure(): void
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Create cache directories and install dependencies, basically using "git pull" and "composer install"')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Basically using "git pull" and "composer install".')

            ->addOption('no-dev', null, InputOption::VALUE_NONE, 'Do not install dev dependencies (composer install --no-dev)')
        ;
    }



    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $symfonyStyle = new SymfonyStyle($input, $output);
        $symfonyStyle->title('Install application');

        $verbose = $output->isVerbose();

        $is_not_dev = $input->getOption('no-dev');
        $is_dev = !$is_not_dev;


        try {
            $directories = array_filter($this->directories);

            if ($directories !== []) {
                $symfonyStyle->section('Create utility directories');
            }

            foreach ($directories as $directory) {
                if (!is_dir($directory)) {
                    $process = ($this->process_factory)(['mkdir', '-p', $directory]);
                    $this->runProcess($process, $output, $symfonyStyle, $verbose);
                } else {
                    $output->writeln(sprintf("Directory '%s' exists", $directory));
                }

                if (is_writable($directory)) {
                    $process = ($this->process_factory)(['chmod', '0775', $directory]);
                    $this->runProcess($process, $output, $symfonyStyle, $verbose);
                } else {
                    $msg = sprintf("Can't chmod on directory '%s'", $directory);
                    $output->writeln($msg);
                }
            }


            if (!empty($this->pem_directory) && $is_dev) {
                $symfonyStyle->section('Development SSL certificates');
                $glob_str = sprintf("%s/*.pem", $this->pem_directory);
                $pem_keys = glob($glob_str);
                if ($pem_keys !== [] && $pem_keys !== false) {
                    $output->writeln("Found certificates:");
                    $output->writeln($pem_keys);
                } else {
                    $symfonyStyle->caution([
                        "No development certificates found.",
                        "See README on how to install using 'mkcert'"
                    ]);
                }

                $symfonyStyle->newLine();
            }



            $symfonyStyle->section('Install Composer dependencies');

            $composer_install_params = ['composer', 'install'];
            if ($is_not_dev) {
                $composer_install_params[] = "--no-dev";
            }

            if ($verbose) {
                $composer_install_params[] = "-v";
            }

            $process = ($this->process_factory)($composer_install_params);
            $this->runProcess($process, $output, $symfonyStyle, $verbose);





            $symfonyStyle->section('Dump Composer autoloader');

            $process = ($this->process_factory)(['composer', 'dump-autoload', '--optimize']);
            $this->runProcess($process, $output, $symfonyStyle, $verbose);





            $symfonyStyle->section('Install node/npm/JS dependencies');

            $npm_install_params = ['npm', 'install'];
            if ($is_dev) {
                $npm_install_params[] = "--dev";
            }

            $process = ($this->process_factory)($npm_install_params);
            $this->runProcess($process, $output, $symfonyStyle, $verbose);




            $symfonyStyle->section('Repo information: git remote');
            $git_remote_args = array_filter(['git', 'remote', $verbose ? '-v' : null]);
            $process = ($this->process_factory)($git_remote_args);
            $this->runProcess($process, $output, $symfonyStyle, $verbose);



            try {
                $symfonyStyle->section('Repo information: git describe');
                $process = ($this->process_factory)(['git', 'describe']);
                $process->mustRun();
                $output->writeln($process->getOutput());
            } catch (Process\Exception\ProcessFailedException $e) {
                if ($verbose) {
                    $output->writeln($e->getMessage());
                } else {
                    $output->writeln([
                        "'Git describe' failed, possibly due to missing tags.",
                        "In this case, this can be ignored; run installer with -v option otherwise."
                    ]);
                }

                $symfonyStyle->newLine();
            } catch (\Throwable $e) {
                $symfonyStyle->newLine();
                $symfonyStyle->error(array_filter([
                   $e::class,
                   $e->getMessage(),
                   $verbose ? sprintf("Line %s in '%s'", $e->getLine(), $e->getFile()) : null
                ]));
            }



            $symfonyStyle->section('Repo information: git status');
            $process = ($this->process_factory)(['git', 'status']);
            $this->runProcess($process, $output, $symfonyStyle, $verbose);
        } catch (Process\Exception\ProcessFailedException $processFailedException) {
            $symfonyStyle->newLine();
            $symfonyStyle->error(array_filter([
               $processFailedException::class,
               $processFailedException->getMessage(),
               $verbose ? sprintf("Line %s in '%s'", $processFailedException->getLine(), $processFailedException->getFile()) : null
            ]));
        }

        return Command::SUCCESS;
    }


    protected function runProcess(Process\Process $process, OutputInterface $output, SymfonyStyle $symfonyStyle, bool $verbose): void
    {
        try {
            $process->mustRun();
            $output->writeln($process->getOutput());
        } catch (\Throwable $throwable) {
            $symfonyStyle->newLine();
            $symfonyStyle->error(array_filter([
               $throwable::class,
               $throwable->getMessage(),
               $verbose ? sprintf("Line %s in '%s'", $throwable->getLine(), $throwable->getFile()) : null
            ]));
        }
    }
}
