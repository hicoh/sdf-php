<?php

namespace App\Service;

use App\Factory\FunctionInit;
use App\Request\ContextRequest;
use App\Request\Payload;
use App\Response\FunctionResponse;

class RequestService
{
    public static function runFunction(ContextRequest $contextRequest): FunctionResponse
    {
        $class = self::getClassNameSpace($contextRequest);

        return $class::run($contextRequest);
    }

    public static function setEventData(EventManagerService $eventManagerService, string $eventId, ContextRequest $contextRequest): ContextRequest
    {
        if ($event = $eventManagerService->getEvent($eventId)) {
            $eventPayloadUrl = $event->getPayloadOutUrl();
            $payload = (new Payload())->setUrl($eventPayloadUrl);
            try {
                $contentArray = json_decode(file_get_contents($eventPayloadUrl) ?: '', true);
            } catch (\Exception $e) {
                $contentArray = [];
            }
            $payload->setContent($contentArray);
            $contextRequest->getEvent()->setPayload($payload);
        } else {
            throw new \Exception('Error fetching Event with ID: '.$eventId);
        }

        return $contextRequest;
    }

    private static function getClassNameSpace(ContextRequest $contextRequest): string
    {
        return FunctionInit::namespace($contextRequest->getSystem()->getName(),
            $contextRequest->getFunctionConfiguration()->getName()
        );
    }
}
