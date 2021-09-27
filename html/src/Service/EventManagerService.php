<?php

namespace App\Service;

use GuzzleHttp\Client;
use HiCo\EventManagerClient\ApiException;
use HiCo\EventManagerClient\Configuration;
use HiCo\EventManagerClient\Model\AsyncResponse;
use HiCo\EventManagerClient\Model\Event;
use HiCo\EventManagerClient\Model\JobRequest;
use HiCo\EventManagerClient\Service\EventApi;
use HiCo\EventManagerClient\Service\JobApi;

class EventManagerService
{
    private static Configuration $config;
    private Client $client;

    public function __construct(string $highCohesionApiHost, string $highCohesionApiKey)
    {
        self::$config = Configuration::getDefaultConfiguration()->setHost($highCohesionApiHost)
            ->setApiKey('apikey', $highCohesionApiKey);
        $this->client = new Client();
    }

    /**
     * @param object[]|null $payloadInList
     *
     * @throws ApiException
     */
    public function createJob(string $streamId, ?array $payloadInList): AsyncResponse
    {
        $apiInstance = new JobApi($this->client, self::$config);
        $jobRequest = (new JobRequest())->setStreamId($streamId)->setPayloadInList($payloadInList);

        return $apiInstance->createJob($jobRequest);
    }

    public function getEvent(string $eventId): ?Event
    {
        $apiInstance = new EventApi($this->client, self::$config);
        $event = $apiInstance->getEventById($eventId);
        if ($event instanceof Event) {
            return $event;
        }

        return null;
    }
}
