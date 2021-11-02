<?php

namespace App\Controller;

use App\Request\DestinationRequest;
use App\Response\FunctionResponse;
use App\Service\EventManagerService;
use App\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DestinationFunctionController extends AbstractController
{
    public function __construct(private EventManagerService $eventManagerService)
    {
    }

    /**
     * @Route("/destination", methods={"POST"})
     */
    public function runDestination(DestinationRequest $destinationRequest): JsonResponse
    {
        if ($eventId = $destinationRequest->getEvent()->getId()) {
            $destinationRequest = RequestService::setEventData(
                $this->eventManagerService, $eventId, $destinationRequest
            );
        }
        /** @var FunctionResponse $functionResponse */
        $functionResponse = RequestService::runFunction($destinationRequest);
        $this->eventManagerService->patchEvent($functionResponse->getUpdateEventRequest());
        $this->eventManagerService->patchEventEntities($functionResponse->getUpdateEventEntities());

        return $this->json($functionResponse);
    }
}
