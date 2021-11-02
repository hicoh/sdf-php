<?php

namespace App\Command;

use App\Command\Helper\Functions;
use App\Command\Helper\Questions;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteFunction extends Command
{
    public const PROJECT_DIR = __DIR__.'/../../';
    protected static $defaultName = 'app:delete-function';

    protected function configure(): void
    {
        $this
            ->setDescription(
                'HighCohesion Function Delete Command. This command will:
                            - Delete a function and update project composer.
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

        self::deleteFunctionDirectory($vendor, $system, $function);
        self::removeRepositoryFromComposerProject($vendor, $system, $function);

        return Command::SUCCESS;
    }

    /**
     * @throws Exception
     */
    private static function deleteFunctionDirectory(string $vendor, string $system, string $function): void
    {
        $dir = Functions::ROOT_DIR.'/'.$system.'/'.$function;
        system('rm -rf -- '.escapeshellarg($dir));
    }

    private static function removeRepositoryFromComposerProject(string $vendor, string $system, string $function): void
    {
        $composer = json_decode(file_get_contents(self::PROJECT_DIR.'composer.json') ?: '', true);
        unset($composer['repositories'][self::getComposerPackageName($vendor, $system, $function)]);
        file_put_contents(
            self::PROJECT_DIR.'composer.json',
            json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
    }

    private static function getComposerPackageName(string $vendor, string $system, string $function): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $vendor)).'/'.
            strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $system)).'-'.
            strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $function));
    }
}
