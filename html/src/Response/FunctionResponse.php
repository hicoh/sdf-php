<?php

namespace App\Response;

use HiCo\EventManagerClient\Model\UpdateEventEntityRequest;
use HiCo\EventManagerClient\Model\UpdateEventRequest;

class FunctionResponse
{
    /**
     * @var array<object>
     */
    private ?array $data = null;
    private ?UpdateEventRequest $updateEventRequest = null;
    /**
     * @var UpdateEventEntityRequest[]|null
     */
    private ?array $updateEventEntities = null;

    /**
     * @param array<object> $data
     *
     * @return $this
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array<object>|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    public function setUpdateEventRequest(UpdateEventRequest $updateEventRequest): self
    {
        $this->updateEventRequest = $updateEventRequest;

        return $this;
    }

    public function getUpdateEventRequest(): ?UpdateEventRequest
    {
        return $this->updateEventRequest;
    }

    public function addUpdateEventEntity(UpdateEventEntityRequest $updateEventEntityRequest): self
    {
        $this->updateEventEntities[] = $updateEventEntityRequest;

        return $this;
    }

    /**
     * @return UpdateEventEntityRequest[]|null
     */
    public function getUpdateEventEntities(): ?array
    {
        return $this->updateEventEntities;
    }
}
