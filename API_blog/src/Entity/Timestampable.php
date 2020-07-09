<?php

declare(strict_types=1);

namespace App\Entity;

trait Timestampable
{
    /**
     * @var \DatetimeInterface
     * @ORM\Column (type="datetime")
     */
    private \DateTimeInterface $createdAt;

    /**
     * @var \DatetimeInterface
     * @ORM\Column (type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $updatedAt;

    function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
    function setUpdatedAt(?\DateTimeInterface $updatedAt): Timestampable
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
    function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
}
