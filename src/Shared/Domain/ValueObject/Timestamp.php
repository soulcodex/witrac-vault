<?php

namespace Witrac\Shared\Domain\ValueObject;

class Timestamp
{
    protected CreatedAt $createdAt;

    protected ?UpdatedAt $updatedAt = null;

    public function __construct(CreatedAt $createdAt, ?UpdatedAt $updatedAt = null)
    {
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return CreatedAt
     */
    public function getCreatedAt(): CreatedAt
    {
        return $this->createdAt;
    }

    /**
     * @return UpdatedAt|null
     */
    public function getUpdatedAt(): ?UpdatedAt
    {
        return $this->updatedAt;
    }
}
