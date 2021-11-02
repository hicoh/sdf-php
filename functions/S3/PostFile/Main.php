<?php

namespace Functions\S3\PostFile;

use App\Request\ContextRequest;
use App\Response\FunctionResponse;
use HiCo\EventManagerClient\Model\UpdateEventRequest;

class Main
{
    public static function run(ContextRequest $contextRequest): FunctionResponse
    {
        $payloadOut = $contextRequest->getEvent()->getPayload()->getContent();
        # send data to destination
        # ...
        # ...
        return (new FunctionResponse())->setUpdateEventRequest(
            (new UpdateEventRequest())
                ->setId($contextRequest->getEvent()->getId())
                ->setStatus('OK')
                ->setMessage('SENT')
                ->setDestinationId('SKU-00001')
        );
    }
}
