<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

trait Timestampable
{
    /**
     * @var \DatetimeInterface
     * @ORM\Column (type="datetime")
     * @Groups({"article:read","user:read", "article:details:read"})
     */
    private \DateTimeInterface $createdAt;

    /**
     * @var \DatetimeInterface
     * @ORM\Column (type="datetime", nullable=true)
     * @Groups({"article:read","user:read", "article:details:read"})
     */
    private ?\DateTimeInterface $updatedAt;

    function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
    function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
    function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
}
