<?php

namespace App\Command\Helper;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class Questions
{
    public function getVendorQuestion(mixed $helper, InputInterface $input, OutputInterface $output): string
    {
        $question = new Question('Enter the Vendor name (I.e. HighCohesion): ', false);
//        $callback = function (string $userInput): array {
//            return array_map(function ($dirOrFile) use ($userInput) {
//                return $dirOrFile;
//            }, Vendor::getAllVendorsDir() ?: []);
//        };
//        $question->setAutocompleterCallback($callback);
        $question->setValidator(function ($answer) {
            if (!preg_match('/([A-Z][a-z0-9]+)+/', $answer)) {
                throw new \RuntimeException('Format is not correct. Enter Upper Camel Case format. E.g., HighCohesion');
            }

            return $answer;
        });
        $question->setMaxAttempts(5);

        return $helper->ask($input, $output, $question);
    }

    public function getSystemQuestion(mixed $helper, InputInterface $input, OutputInterface $output): string
    {
        $question = new Question('Enter the System name (I.e. Shopify, Magento): ', false);
        $question->setValidator(function ($answer) {
            if (!preg_match('/([A-Z][a-z0-9]+)+/', $answer)) {
                throw new \RuntimeException('Format is not correct. Enter Upper Camel Case format. E.g., HighCohesion');
            }

            return $answer;
        });
        $question->setMaxAttempts(5);

        return $helper->ask($input, $output, $question);
    }

    public function getFunctionQuestion(mixed $helper, InputInterface $input, OutputInterface $output): string
    {
        $question = new Question('Enter the Function name (I.e. GetOrder, GetProduct, GetFile): ', false);
        $question->setValidator(function ($answer) {
            if (!preg_match('/([A-Z][a-z0-9]+)+/', $answer)) {
                throw new \RuntimeException('Format is not correct. Enter Upper Camel Case format (I.e. HighCohesion)');
            }

            return $answer;
        });
        $question->setMaxAttempts(5);

        return $helper->ask($input, $output, $question);
    }
}
