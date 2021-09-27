<?php

namespace App\Controller;

use App\Request\DestinationRequest;
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
    public function runSource(DestinationRequest $destinationRequest): JsonResponse
    {
        if ($eventId = $destinationRequest->getEvent()->getId()) {
            $destinationRequest = RequestService::setEventData(
                $this->eventManagerService, $eventId, $destinationRequest
            );
        }

        return $this->json(RequestService::runFunction($destinationRequest));
    }
}
