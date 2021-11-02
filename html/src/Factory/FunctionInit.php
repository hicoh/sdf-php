<?php

namespace App\Factory;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

final class FunctionInit
{
    public const FOLDER_NAME = 'Functions';
    public const CLASS_NAME = 'Main';

    public static function namespace(string $system, string $name): string
    {
        $class = '\\'.self::FOLDER_NAME.'\\'.$system.'\\'.$name.'\\'.self::CLASS_NAME;
        if (class_exists($class)) {
            return $class;
        }
        throw new FileNotFoundException('Class does not exists. Check your Function folder structure');
    }
}
