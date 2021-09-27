<?php

namespace App\Controller;

use App\Request\SourceRequest;
use App\Service\EventManagerService;
use App\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SourceFunctionController extends AbstractController
{
    public function __construct(private EventManagerService $eventManagerService)
    {
    }

    /**
     * @Route("/source", methods={"POST"})
     */
    public function runSource(SourceRequest $sourceRequest): JsonResponse
    {
        $result = RequestService::runFunction($sourceRequest);
        if ($sourceRequest->getStream() && $streamId = $sourceRequest->getStream()->getId()) {
            $this->eventManagerService->createJob(
                $streamId,
                $result
            );
        }

        return $this->json($result);
    }
}
