<?php

namespace App\Command\Helper;

class Functions
{
    public const ROOT_DIR = __DIR__.'/../../../../functions';

    public static function getRootDir(): string
    {
        return self::ROOT_DIR;
    }

    public static function getFunctionsDir(string $vendorName): string
    {
        return self::ROOT_DIR.'/'.$vendorName;
    }
}
