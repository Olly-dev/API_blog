<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

trait Timestampable
{
    /**
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

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
}
