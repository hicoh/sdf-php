<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HealthController extends AbstractController
{
    /**
     * @Route("/health", methods={"GET"})
     */
    public function getHealth(): JsonResponse
    {
        return $this->json(
            [
                'status' => 'ok',
            ]
        );
    }
}
