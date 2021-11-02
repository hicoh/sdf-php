<?php

namespace App\Request;

interface RequestInterface
{
    public static function getParamConverterClass(): string;
}
