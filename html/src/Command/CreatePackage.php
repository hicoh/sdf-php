<?php

namespace App\Command;

use App\Command\Helper\Functions;
use App\Command\Helper\Questions;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreatePackage extends Command
{
    public const PROJECT_DIR = __DIR__.'/../../';
    protected static $defaultName = 'app:create-package';

    protected function configure(): void
    {
        $this
            ->setDescription(
                'HighCohesion Function Package Generator. This command will:
                            - Create new package structure.
                            - Update project composer repository.
                '
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $questions = new Questions();
        $vendor = $questions->getVendorQuestion($helper, $input, $output);
        $system = $questions->getSystemQuestion($helper, $input, $output);
        $function = $questions->getFunctionQuestion($helper, $input, $output);

        self::initFunctionDirectory($vendor, $system, $function);
        self::initComposerFunction($vendor, $system, $function);
        self::initComposerProject($vendor, $system, $function);
        self::initMain($system, $function);

        return Command::SUCCESS;
    }

    /**
     * @throws Exception
     */
    private static function initFunctionDirectory(string $vendor, string $system, string $function): void
    {
        if (!file_exists(Functions::ROOT_DIR.'/'.$system.'/'.$function)) {
            mkdir(Functions::getRootDir().'/'.$system.'/'.$function, 0777, true);
        } else {
            throw new Exception('This function already exists. Please, choose a different name.');
        }
    }

    private static function initComposerFunction(string $vendor, string $system, string $function): void
    {
        $composer = json_decode(file_get_contents(
            Functions::getRootDir().'/templates/composer.json') ?: '', true);
        $composer['name'] = self::getComposerPackageName($vendor, $system, $function);
        file_put_contents(
            Functions::getRootDir().'/'.$system.'/'.$function.'/composer.json',
            json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
    }

    private static function initComposerProject(string $vendor, string $system, string $function): void
    {
        $composer = json_decode(file_get_contents(self::PROJECT_DIR.'composer.json') ?: '', true);
        $composer['repositories'][self::getComposerPackageName($vendor, $system, $function)] = [
            'type' => 'path',
            'url' => '../functions/'.$system.'/'.$function,
        ];
        file_put_contents(
            self::PROJECT_DIR.'composer.json',
            json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
    }

    private static function initMain(string $system, string $function): void
    {
        $main = file_get_contents(Functions::getRootDir().'/templates/Main.php') ?: '';
        $main = str_replace('{System}', $system, $main);
        $main = str_replace('{Function}', $function, $main);
        file_put_contents(Functions::getRootDir().'/'.$system.'/'.$function.'/Main.php', $main);
    }

    private static function getComposerPackageName(string $vendor, string $system, string $function): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $vendor)).'/'.
        strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $system)).'-'.
        strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $function));
    }
}
