<?php

namespace Functions\{SYSTEM_NAME}\{FUNCTION_NAME};

use App\Request\ContextRequest;
use App\Response\FunctionResponse;

class Main
{
    public static function run(ContextRequest $contextRequest): FunctionResponse
    {
        return (new FunctionResponse());
    }
}
