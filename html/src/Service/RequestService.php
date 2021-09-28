<?php

namespace App\Service;

use App\Factory\FunctionInit;
use App\Request\ContextRequest;
use App\Request\Payload;

class RequestService
{
    /**
     * @return array<object>|null
     */
    public static function runFunction(ContextRequest $contextRequest): ?array
    {
        $class = self::getClassNameSpace($contextRequest);

        return $class::run($contextRequest);
    }

    public static function setEventData(EventManagerService $eventManagerService, string $eventId, ContextRequest $contextRequest): ContextRequest
    {
        if ($event = $eventManagerService->getEvent($eventId)) {
            $eventPayloadUrl = $event->getPayloadOutUrl();
            $payload = (new Payload())->setUrl($eventPayloadUrl);
            $content = json_decode(file_get_contents($eventPayloadUrl) ?: '', true);
            $payload->setContent($content);
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
